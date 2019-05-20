<?php

use MessageBird\Client;
use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Message;

class ConversationMessageTest extends BaseTest
{
    const LIST_RESPONSE = '{
        "count": 1,
        "totalCount": 1,
        "limit": 25,
        "offset": 0,
        "items": [
            {
                "channelId": "chid",
                "contactId": "conid",
                "content": {
                    "video": {
                        "url": "https://developers.messagebird.com/assets/videos/foo.mp4"
                    }
                },
                "conversationId": "conid",
                "createdDatetime": "2002-10-02T16:00:00Z",
                "direction": "received",
                "id": "genid",
                "status": "delivered",
                "type": "video"
            }
        ]
    }';

    const READ_RESPONSE = '{
        "channelId": "chid",
        "contactId": "conid",
        "content": {
            "video": {
                "url": "https://developers.messagebird.com/assets/videos/foo.mp4"
            }
        },
        "conversationId": "conid",
        "createdDatetime": "2002-10-02T16:00:00Z",
        "direction": "received",
        "id": "genid",
        "status": "delivered",
        "type": "video"
    }';

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateImage()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/some-conversation-id/messages', null, '{"channelId":"abcd1234","type":"image","content":{"image":{"url":"https:\/\/developers.messagebird.com\/assets\/images\/glyph.svg"}}}')
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->image = array(
            'url' => 'https://developers.messagebird.com/assets/images/glyph.svg'
        );

        $message = new Message();
        $message->channelId = 'abcd1234';
        $message->content = $content;
        $message->type = 'image';

        $this->client->conversationMessages->create('some-conversation-id', $message);
    }

    public function testCreateLocation()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/some-contact-id/messages', null, '{"channelId":"abcd1234","type":"location","content":{"location":{"latitude":"52.379112","longitude":"4.900384"}}}')
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->location = array(
            'latitude' => '52.379112',
            'longitude' => '4.900384'
        );

        $message = new Message();
        $message->channelId = 'abcd1234';
        $message->content = $content;
        $message->type = 'location';

        $this->client->conversationMessages->create('some-contact-id', $message);
    }

    public function testCreateText()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/some-other-contact-id/messages', null, '{"channelId":"abcd1234","type":"text","content":{"text":"Hello world"}}')
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->text = 'Hello world';

        $message = new Message();
        $message->content = $content;
        $message->channelId = 'abcd1234';
        $message->type = 'text';

        $this->client->conversationMessages->create('some-other-contact-id', $message);
    }

    public function testCreateWithoutChannel()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/genid/messages', null, '{"type":"text","content":{"text":"Hello world"}}')
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->text = 'Hello world';

        $message = new Message();
        $message->content = $content;
        $message->type = 'text';

        $this->client->conversationMessages->create('genid', $message);
    }

    public function testListPagination()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'conversations/genid/messages', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE));

        $messages = $this->client->conversationMessages->getList('genid');

        $this->assertEquals(1, $messages->count);
        $this->assertEquals(1, $messages->totalCount);
        $this->assertEquals(25, $messages->limit);
        $this->assertEquals(0, $messages->offset);
    }

    public function testListObject()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'conversations/genid/messages', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE));

        $message = $this->client->conversationMessages->getList('genid')->items[0];

        $expectedContent = new Content();
        $expectedContent->video = array(
            'url' => 'https://developers.messagebird.com/assets/videos/foo.mp4'
        );

        $expectedMessage = new Message();
        $expectedMessage->id = 'genid';
        $expectedMessage->channelId = 'chid';
        $expectedMessage->conversationId = 'conid';
        $expectedMessage->content = $expectedContent;
        $expectedMessage->type = 'video';
        $expectedMessage->direction = 'received';
        $expectedMessage->status = 'delivered';
        $expectedMessage->createdDatetime = '2002-10-02T16:00:00Z';

        $this->assertEquals($expectedMessage, $message);
    }

    public function testReadMessage()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'messages/message-id', array(), null)
            ->willReturn(array(200, '', self::READ_RESPONSE));


        $message = $this->client->conversationMessages->read('message-id');

        $expectedContent = new Content();
        $expectedContent->video = array(
            'url' => 'https://developers.messagebird.com/assets/videos/foo.mp4'
        );
        $expectedMessage = new Message();
        $expectedMessage->id = 'genid';
        $expectedMessage->channelId = 'chid';
        $expectedMessage->conversationId = 'conid';
        $expectedMessage->content = $expectedContent;
        $expectedMessage->type = 'video';
        $expectedMessage->direction = 'received';
        $expectedMessage->status = 'delivered';
        $expectedMessage->createdDatetime = '2002-10-02T16:00:00Z';

        $this->assertEquals($expectedMessage, $message);
    }
}
