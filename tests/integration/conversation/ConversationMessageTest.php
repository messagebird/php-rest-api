<?php

use MessageBird\Client;
use MessageBird\Objects\Conversation\Content;
use MessageBird\Objects\Conversation\Hsm;
use MessageBird\Objects\Conversation\HsmParam;
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

    const LIST_RESPONSE_WITH_HSM = '{
        "count": 1,
        "totalCount": 1,
        "limit": 25,
        "offset": 0,
        "items": [
            {
                "channelId": "chid",
                "contactId": "conid",
                "content": {
                    "hsm": {
                        "namespace": "foons",
                        "templateName": "welcome",
                        "language": {
                            "code": "en_US",
                            "policy": "deterministic"
                        },
                        "params":
                        [
                            {
                                "default": "EUR 13,37",
                                "currency": {
                                    "currencyCode": "EUR",
                                    "amount": 13370
                                }
                            },
                            {
                                "default": "Hello world"
                            }
                        ]
                    }
                },
                "conversationId": "conid",
                "createdDatetime": "2002-10-02T16:00:00Z",
                "direction": "received",
                "id": "genid",
                "status": "delivered",
                "type": "hsm"
            }
        ]
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
            ->with('POST', 'conversations/some-conversation-id/messages', null, '{"id":null,"conversationId":null,"channelId":"abcd1234","direction":null,"status":null,"type":"image","content":{"audio":null,"file":null,"hsm":null,"image":{"url":"https:\/\/developers.messagebird.com\/assets\/images\/glyph.svg"},"location":null,"text":null,"video":null},"to":null,"createdDatetime":null,"updatedDatetime":null}')
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
            ->with('POST', 'conversations/some-contact-id/messages', null, '{"id":null,"conversationId":null,"channelId":"abcd1234","direction":null,"status":null,"type":"location","content":{"audio":null,"file":null,"hsm":null,"image":null,"location":{"latitude":"52.379112","longitude":"4.900384"},"text":null,"video":null},"to":null,"createdDatetime":null,"updatedDatetime":null}')
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
            ->with('POST', 'conversations/some-other-contact-id/messages', null, '{"id":null,"conversationId":null,"channelId":"abcd1234","direction":null,"status":null,"type":"text","content":{"audio":null,"file":null,"hsm":null,"image":null,"location":null,"text":"Hello world","video":null},"to":null,"createdDatetime":null,"updatedDatetime":null}')
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
            ->with('POST', 'conversations/genid/messages', null, '{"id":null,"conversationId":null,"channelId":null,"direction":null,"status":null,"type":"text","content":{"audio":null,"file":null,"hsm":null,"image":null,"location":null,"text":"Hello world","video":null},"to":null,"createdDatetime":null,"updatedDatetime":null}')
            ->willReturn(array(200, '', '{}'));

        $content = new Content();
        $content->text = 'Hello world';

        $message = new Message();
        $message->content = $content;
        $message->type = 'text';

        $this->client->conversationMessages->create('genid', $message);
    }

    public function testCreateHsm()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('POST', 'conversations/id/messages', null, '{"id":null,"conversationId":null,"channelId":null,"direction":null,"status":null,"type":"hsm","content":{"audio":null,"file":null,"hsm":{"namespace":"foons","templateName":"welcome","language":{"code":"en_US","policy":"deterministic"},"params":[{"default":"EUR 13.37","currency":{"currencyCode":"EUR","amount":13370},"dateTime":null},{"default":"can not localize","currency":null,"dateTime":"2018-08-09T11:44:40+00:00"}]},"image":null,"location":null,"text":null,"video":null},"to":null,"createdDatetime":null,"updatedDatetime":null}')
            ->willReturn(array(200, '', '{}'));

        $hsm = new Hsm();
        $hsm->namespace = 'foons';
        $hsm->templateName = 'welcome';
        $hsm->setLanguage('en_US', Hsm::LANGUAGE_POLICY_DETERMINISTIC);
        $hsm->addParam(HsmParam::currency('EUR 13.37', 'EUR', 13370));
        $hsm->addParam(HsmParam::dateTime('can not localize', '2018-08-09T11:44:40+00:00'));

        $message = new Message();
        $message->type = Content::TYPE_HSM;
        $message->content = $hsm->toContent();

        $this->client->conversationMessages->create('id', $message);
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

    public function testListWithHsm()
    {
        $this->mockClient
            ->expects($this->once())->method('performHttpRequest')
            ->with('GET', 'conversations/genid/messages', array(), null)
            ->willReturn(array(200, '', self::LIST_RESPONSE_WITH_HSM));

        $message = $this->client->conversationMessages->getList('genid')->items[0];

        $hsm = new Hsm();
        $hsm->namespace = 'foons';
        $hsm->templateName = 'welcome';
        $hsm->setLanguage('en_US', 'deterministic');
        $hsm->addParam(HsmParam::currency('EUR 13,37', 'EUR', 13370));
        $hsm->addParam(HsmParam::text('Hello world'));

        // Can also use $hsm->toContent()
        $expectedContent = new Content();
        $expectedContent->hsm = $hsm;

        $expectedMessage = new Message();
        $expectedMessage->id = 'genid';
        $expectedMessage->channelId = 'chid';
        $expectedMessage->conversationId = 'conid';
        $expectedMessage->content = $expectedContent;
        $expectedMessage->type = 'hsm';
        $expectedMessage->direction = 'received';
        $expectedMessage->status = 'delivered';
        $expectedMessage->createdDatetime = '2002-10-02T16:00:00Z';

        $this->assertEquals($expectedMessage, $message);
    }
}
