<?php

use MessageBird\Objects\Conversation\Webhook;

class ConversationWebhookTest extends BaseTest
{
    const LIST_RESPONSE = '{
        "offset": 0,
        "limit": 25,
        "count": 1,
        "totalCount": 1,
        "items": [
            {
                "id": "some-id",
                "url": "https://example.com/webhook",
                "channelId": "chid",
                "events": [
                    "conversation.created",
                    "message.created"
                ],
                "createdDatetime": "2018-07-31T12:12:43Z",
                "updatedDatetime": null
            }
        ]
    }';

    const READ_RESPONSE = '{
        "id": "some-id",
        "channelId": "chid",
        "href": "https://conversations.messagebird.com/v1/webhooks/some-id",
        "url": "https://messagebird.com/webhook-receiver",
        "events": [
            "conversation.updated",
            "message.updated"
        ],
        "createdDatetime": "2018-07-20T12:13:41+00:00",
        "updatedDatetime": "2018-07-20T12:13:51+00:00"
    }';

    public function setUp()
    {
        parent::setUp();

        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testDelete()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('DELETE', 'webhooks/some-id', null, null)
            ->willReturn(array(204, '', null));

        $this->client->conversationWebhooks->delete('some-id');
    }

    public function testCreate()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'webhooks', null, '{"channelId":"chid","events":["conversation.created","message.created"],"url":"https:\/\/messagebird.com\/webhook-receiver"}')
            ->willReturn(array(200, '', '{}'));

        $webhook = new Webhook();
        $webhook->channelId = 'chid';
        $webhook->url = 'https://messagebird.com/webhook-receiver';
        $webhook->events = array(
            Webhook::EVENT_CONVERSATION_CREATED,
            Webhook::EVENT_MESSAGE_CREATED,
        );

        $this->client->conversationWebhooks->create($webhook);
    }

    public function testListPagination()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'webhooks', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE));

        $webhooks = $this->client->conversationWebhooks->getList();

        $this->assertEquals(1, $webhooks->count);
        $this->assertEquals(1, $webhooks->totalCount);
        $this->assertEquals(25, $webhooks->limit);
        $this->assertEquals(0, $webhooks->offset);
    }

    public function testListObject()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'webhooks', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE));

        $expectedWebhook = new Webhook();
        $expectedWebhook->id = 'some-id';
        $expectedWebhook->channelId = 'chid';
        $expectedWebhook->events = array('conversation.created', 'message.created');
        $expectedWebhook->url = 'https://example.com/webhook';
        $expectedWebhook->createdDatetime = '2018-07-31T12:12:43Z';

        $this->assertEquals(
            $expectedWebhook,
            $this->client->conversationWebhooks->getList()->items[0]
        );
    }

    public function testRead()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'webhooks/some-id', null, null)
            ->willReturn(array(200, '', self::READ_RESPONSE));

        $webhook = new Webhook();
        $webhook->id = 'some-id';
        $webhook->href = 'https://conversations.messagebird.com/v1/webhooks/some-id';
        $webhook->channelId = 'chid';
        $webhook->url = 'https://messagebird.com/webhook-receiver';
        $webhook->events = array(
            Webhook::EVENT_CONVERSATION_UPDATED,
            Webhook::EVENT_MESSAGE_UPDATED,
        );
        $webhook->createdDatetime = '2018-07-20T12:13:41+00:00';
        $webhook->updatedDatetime = '2018-07-20T12:13:51+00:00';

        $this->assertEquals(
            $webhook,
            $this->client->conversationWebhooks->read('some-id')
        );
    }
}
