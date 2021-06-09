<?php

namespace Tests\Integration\Conversation;

use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Message;
use Tests\Integration\BaseTest;

class ConversationMessageTest extends BaseTest
{
    public const LIST_RESPONSE = '{
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

    public const READ_RESPONSE = '{
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

    public function testCreateImage(): void
    {
        $this->mockClient
            ->expects(self::once())->method('performHttpRequest')
            ->with(
                'POST',
                'conversations/some-conversation-id/messages',
                null,
                '{"channelId":"abcd1234","type":"image","content":{"image":{"url":"https:\/\/developers.messagebird.com\/assets\/images\/glyph.svg"}}}'
            )
            ->willReturn([200, '', '{}']);

        $content = new Content();
        $content->image = [
            'url' => 'https://developers.messagebird.com/assets/images/glyph.svg',
        ];

        $message = new Message();
        $message->channelId = 'abcd1234';
        $message->content = $content;
        $message->type = 'image';

        $this->client->conversationMessages->create('some-conversation-id', $message);
    }

    public function testCreateLocation(): void
    {
        $this->mockClient
            ->expects(self::once())->method('performHttpRequest')
            ->with(
                'POST',
                'conversations/some-contact-id/messages',
                null,
                '{"channelId":"abcd1234","type":"location","content":{"location":{"latitude":"52.379112","longitude":"4.900384"}}}'
            )
            ->willReturn([200, '', '{}']);

        $content = new Content();
        $content->location = [
            'latitude' => '52.379112',
            'longitude' => '4.900384',
        ];

        $message = new Message();
        $message->channelId = 'abcd1234';
        $message->content = $content;
        $message->type = 'location';

        $this->client->conversationMessages->create('some-contact-id', $message);
    }

    public function testCreateText(): void
    {
        $this->mockClient
            ->expects(self::once())->method('performHttpRequest')
            ->with(
                'POST',
                'conversations/some-other-contact-id/messages',
                null,
                '{"channelId":"abcd1234","type":"text","content":{"text":"Hello world"}}'
            )
            ->willReturn([200, '', '{}']);

        $content = new Content();
        $content->text = 'Hello world';

        $message = new Message();
        $message->content = $content;
        $message->channelId = 'abcd1234';
        $message->type = 'text';

        $this->client->conversationMessages->create('some-other-contact-id', $message);
    }

    public function testCreateWithoutChannel(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('POST', 'conversations/genid/messages', null, '{"type":"text","content":{"text":"Hello world"}}')
             ->willReturn([200, '', '{}']);

        $content = new Content();
        $content->text = 'Hello world';

        $message = new Message();
        $message->content = $content;
        $message->type = 'text';

        $this->client->conversationMessages->create('genid', $message);
    }

    public function testListPagination(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('GET', 'conversations/genid/messages', [], null)
             ->willReturn([200, '', self::LIST_RESPONSE]);

        $messages = $this->client->conversationMessages->getList('genid');

        self::assertEquals(1, $messages->count);
        self::assertEquals(1, $messages->totalCount);
        self::assertEquals(25, $messages->limit);
        self::assertEquals(0, $messages->offset);
    }

    public function testListObject(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('GET', 'conversations/genid/messages', [], null)
             ->willReturn([200, '', self::LIST_RESPONSE]);

        $message = $this->client->conversationMessages->getList('genid')->items[0];

        $expectedContent = new Content();
        $expectedContent->video = [
            'url' => 'https://developers.messagebird.com/assets/videos/foo.mp4',
        ];

        $expectedMessage = new Message();
        $expectedMessage->id = 'genid';
        $expectedMessage->channelId = 'chid';
        $expectedMessage->conversationId = 'conid';
        $expectedMessage->content = $expectedContent;
        $expectedMessage->type = 'video';
        $expectedMessage->direction = 'received';
        $expectedMessage->status = 'delivered';
        $expectedMessage->createdDatetime = '2002-10-02T16:00:00Z';

        self::assertEquals($expectedMessage, $message);
    }

    public function testReadMessage(): void
    {
        $this->mockClient
             ->expects(self::once())->method('performHttpRequest')
             ->with('GET', 'messages/message-id', [], null)
             ->willReturn([200, '', self::READ_RESPONSE]);


        $message = $this->client->conversationMessages->read('message-id');

        $expectedContent = new Content();
        $expectedContent->video = [
            'url' => 'https://developers.messagebird.com/assets/videos/foo.mp4',
        ];
        $expectedMessage = new Message();
        $expectedMessage->id = 'genid';
        $expectedMessage->channelId = 'chid';
        $expectedMessage->conversationId = 'conid';
        $expectedMessage->content = $expectedContent;
        $expectedMessage->type = 'video';
        $expectedMessage->direction = 'received';
        $expectedMessage->status = 'delivered';
        $expectedMessage->createdDatetime = '2002-10-02T16:00:00Z';

        self::assertEquals($expectedMessage, $message);
    }
}
