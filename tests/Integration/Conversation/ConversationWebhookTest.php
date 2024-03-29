<?php

namespace Tests\Integration\Conversation;

use MessageBird\Objects\Conversation\Webhook;
use Tests\Integration\BaseTest;

class ConversationWebhookTest extends BaseTest
{
    public const LIST_RESPONSE = '{
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

    public const READ_RESPONSE = '{
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

    public function testDelete(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('DELETE', 'webhooks/some-id', null, null)
             ->willReturn([204, '', null]);

        $this->client->conversationWebhooks->delete('some-id');
    }

    public function testCreate(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with(
                 'POST',
                 'webhooks',
                 null,
                 '{"channelId":"chid","events":["conversation.created","message.created"],"url":"https:\/\/messagebird.com\/webhook-receiver"}'
             )
             ->willReturn([200, '', '{}']);

        $webhook = new Webhook();
        $webhook->channelId = 'chid';
        $webhook->url = 'https://messagebird.com/webhook-receiver';
        $webhook->events = [
            Webhook::EVENT_CONVERSATION_CREATED,
            Webhook::EVENT_MESSAGE_CREATED,
        ];

        $this->client->conversationWebhooks->create($webhook);
    }

    public function testListPagination(): void
    {
        $this->mockClient
              ->expects(self::once())->method('performHttpRequest')
              ->with('GET', 'webhooks', [], null)
              ->willReturn([200, '', self::LIST_RESPONSE]);

        $webhooks = $this->client->conversationWebhooks->getList();

        self::assertEquals(1, $webhooks->count);
        self::assertEquals(1, $webhooks->totalCount);
        self::assertEquals(25, $webhooks->limit);
        self::assertEquals(0, $webhooks->offset);
    }

    public function testListObject(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('GET', 'webhooks', [], null)
             ->willReturn([200, '', self::LIST_RESPONSE]);

        $expectedWebhook = new Webhook();
        $expectedWebhook->id = 'some-id';
        $expectedWebhook->channelId = 'chid';
        $expectedWebhook->events = ['conversation.created', 'message.created'];
        $expectedWebhook->url = 'https://example.com/webhook';
        $expectedWebhook->createdDatetime = '2018-07-31T12:12:43Z';

        self::assertEquals(
            $expectedWebhook,
            $this->client->conversationWebhooks->getList()->items[0]
        );
    }

    public function testRead(): void
    {
        $this->mockClient
            ->expects(self::once())->method('performHttpRequest')
            ->with('GET', 'webhooks/some-id', null, null)
            ->willReturn([200, '', self::READ_RESPONSE]);

        $webhook = new Webhook();
        $webhook->id = 'some-id';
        $webhook->href = 'https://conversations.messagebird.com/v1/webhooks/some-id';
        $webhook->channelId = 'chid';
        $webhook->url = 'https://messagebird.com/webhook-receiver';
        $webhook->events = [
            Webhook::EVENT_CONVERSATION_UPDATED,
            Webhook::EVENT_MESSAGE_UPDATED,
        ];
        $webhook->createdDatetime = '2018-07-20T12:13:41+00:00';
        $webhook->updatedDatetime = '2018-07-20T12:13:51+00:00';

        self::assertEquals(
            $webhook,
            $this->client->conversationWebhooks->read('some-id')
        );
    }
}
