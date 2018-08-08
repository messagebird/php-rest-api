<?php

use MessageBird\Client;
use MessageBird\Objects\BaseList;
use MessageBird\Objects\Conversation\Channel;
use MessageBird\Objects\Conversation\Contact;
use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Conversation\Message;
use MessageBird\Objects\Conversation\MessageReference;

class ConversationTest extends BaseTest
{
    const START_REQUEST = '{"channelId":"channel-id","type":"location","content":{"location":{"latitude":"37.778326","longitude":"-122.394648"}},"to":"31612345678"}';
    const CREATE_REQUEST = '{"contactId":"some-contact-id"}';

    const LIST_RESPONSE = '{
        "count": 1,
        "totalCount": 1,
        "limit": 10,
        "offset": 0,
        "items": [
            {
                "channels": [
                    {
                        "createdDatetime": "2018-07-20T12:13:31+00:00",
                        "id": "channel-id",
                        "name": "channel-name",
                        "platformId": "messenger",
                        "status": "active",
                        "updatedDatetime": "2018-07-20T12:13:41+00:00"
                    }
                ],
                "contact": {
                    "createdDatetime": "2018-07-20T12:13:41+00:00",
                    "customDetails": {
                        "custom1": "Baz"
                    },
                    "firstName": "Foo",
                    "href": "https://rest.messagebird.com/contacts/contact-id",
                    "id": "contact-id",
                    "lastName": "Bar",
                    "msisdn": "31612345678",
                    "updatedDatetime": "2018-07-20T12:13:51+00:00"
                },
                "createdDatetime": "2018-07-20T12:13:21+00:00",
                "href": "https://conversations.messagebird.com/v1/conversations/conversation-id",
                "id": "conversation-id",
                "lastReceivedDatetime": "2018-07-20T12:13:41+00:00",
                "lastUsedChannelId": "channel-id",
                "messages": {
                    "href": "https://conversations.messagebird.com/v1/conversations/conversation-id/messages",
                    "totalCount": 12
                },
                "status": "active",
                "updatedDatetime": "2018-07-20T12:13:31+00:00"
            }
        ]
    }';

    const READ_RESPONSE = '{
        "id": "conversation-id",
        "href": "https://conversations.messagebird.com/v1/conversations/conversation-id",
        "contact": {
            "id": "contact-id",
            "href": "https://rest.messagebird.com/contacts/contact-id",
            "msisdn": "31612345678",
            "firstName": "Foo",
            "lastName": "Bar",
            "customDetails": {
                "custom1": "Baz"
            },
            "createdDatetime": "2018-07-20T12:13:41+00:00",
            "updatedDatetime": "2018-07-20T12:13:51+00:00"
        },
        "channels": [
            {
                "id": "channel-id",
                "name": "channel-name",
                "platformId": "messenger",
                "status": "active",
                "createdDatetime": "2018-07-20T12:13:31+00:00",
                "updatedDatetime": "2018-07-20T12:13:41+00:00"
            }
        ],
        "status": "active",
        "messages": {
            "href": "https://conversations.messagebird.com/v1/conversations/conversation-id/messages",
            "totalCount": 12
        },
        "createdDatetime": "2018-07-20T12:13:21+00:00",
        "updatedDatetime": "2018-07-20T12:13:31+00:00",
        "lastReceivedDatetime": "2018-07-20T12:13:41+00:00",
        "lastUsedChannelId": "channel-id"
    }';

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testStart()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/start', null, self::START_REQUEST)
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->location = array(
            'latitude' => '37.778326',
            'longitude' => '-122.394648',
        );

        $message = new Message();
        $message->channelId = 'channel-id';
        $message->to = '31612345678';
        $message->type = 'location';
        $message->content = $content;
        
        $this->client->conversations->start($message);
    }

    /**
     * We can also start a conversation without a message.
     */
    public function testCreate()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations', null, self::CREATE_REQUEST)
            ->willReturn(array(200, '', '{}'));
        
        $this->client->conversations->create('some-contact-id');
    }
    
    public function testList()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'conversations', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE));

        $list = new BaseList();
        $list->limit = 10;
        $list->offset = 0;
        $list->count = 1;
        $list->totalCount = 1;
        $list->items = array($this->getConversation());

        $this->assertEquals(
            $list,
            $this->client->conversations->getList()
        );
    }

    public function testRead()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'conversations/conversation-id', null, null)
            ->willReturn(array(200, '', self::READ_RESPONSE));

        $this->assertEquals(
            $this->getConversation(),
            $this->client->conversations->read('conversation-id')
        );
    }

    public function testUpdate()
    {
        $this->mockClient
            ->expects($this->exactly(2))->method('performHttpRequest')
            ->withConsecutive(
                array('PATCH', 'conversations/conversation-id', null, '{"status":"archived"}'),
                array('PATCH', 'conversations/conversation-id', null, '{"status":"active"}')                
            )
            ->willReturn(array(200, '', '{}'));

        $conversation = new Conversation();
        
        $conversation->status = Conversation::STATUS_ARCHIVED;
        $this->client->conversations->update($conversation, 'conversation-id');

        $conversation->status = Conversation::STATUS_ACTIVE;
        $this->client->conversations->update($conversation, 'conversation-id');
    }

    /**
     * Gets an arbitrary conversation that's used in tests.
     *
     * @return Conversation
     */
    private function getConversation()
    {
        $contact = new Contact();
        $contact->id = 'contact-id';
        $contact->href = 'https://rest.messagebird.com/contacts/contact-id';
        $contact->msisdn = '31612345678';
        $contact->firstName = 'Foo';
        $contact->lastName = 'Bar';
        $contact->customDetails = array(
            'custom1' => 'Baz',
        );
        $contact->createdDatetime = '2018-07-20T12:13:41+00:00';
        $contact->updatedDatetime = '2018-07-20T12:13:51+00:00';

        $channel = new Channel();
        $channel->id = 'channel-id';
        $channel->name = 'channel-name';
        $channel->platformId = 'messenger';
        $channel->status = 'active';
        $channel->createdDatetime = '2018-07-20T12:13:31+00:00';
        $channel->updatedDatetime = '2018-07-20T12:13:41+00:00';

        $messages = new MessageReference();
        $messages->href = 'https://conversations.messagebird.com/v1/conversations/conversation-id/messages';
        $messages->totalCount = 12;

        $conversation = new Conversation();
        $conversation->contact = $contact;
        $conversation->channels = array($channel);
        $conversation->id = 'conversation-id';
        $conversation->href = 'https://conversations.messagebird.com/v1/conversations/conversation-id';
        $conversation->messages = $messages;
        $conversation->status = Conversation::STATUS_ACTIVE;
        $conversation->createdDatetime = '2018-07-20T12:13:21+00:00';
        $conversation->updatedDatetime = '2018-07-20T12:13:31+00:00';
        $conversation->lastReceivedDatetime = '2018-07-20T12:13:41+00:00';
        $conversation->lastUsedChannelId = 'channel-id';

        return $conversation;
    }
}