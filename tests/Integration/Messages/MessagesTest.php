<?php

namespace Tests\Integration\Messages;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Message;
use MessageBird\Objects\MessageResponse;
use Tests\Integration\BaseTest;

class MessagesTest extends BaseTest
{
    public function testCreateMessage()
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{
                  "id":"e8077d803532c0b5937c639b60216938",
                  "href":"https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938",
                  "direction":"mt",
                  "type":"sms",
                  "originator":"YourName",
                  "body":"This is a test message",
                  "reference":null,
                  "validity":null,
                  "gateway":null,
                  "typeDetails":{

                  },
                  "datacoding":"plain",
                  "mclass":1,
                  "scheduledDatetime":null,
                  "createdDatetime":"2015-07-03T07:55:31+00:00",
                  "recipients":{
                    "totalCount":1,
                    "totalSentCount":1,
                    "totalDeliveredCount":0,
                    "totalDeliveryFailedCount":0,
                    "items":[
                      {
                        "recipient":31612345678,
                        "status":"sent",
                        "statusDatetime":"2015-07-03T07:55:31+00:00"
                      }
                    ]
                  },
                  "reportUrl":null
                }',
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"sms","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":[],"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }

    public function testPremiumSmsMessage()
    {
        $this->expectException(ServerException::class);
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->setPremiumSms(2002, 'mb', 1, 2);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"premium","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":{"shortcode":2002,"keyword":"mb","tariff":1,"mid":2},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }

    public function testBinarySmsMessage()
    {
        $this->expectException(ServerException::class);
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->setBinarySms("HEADER", "test");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }


    public function testFlashSmsMessage()
    {
        $this->expectException(ServerException::class);
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->setBinarySms("HEADER", "test");
        $message->setFlash(true);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":0,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }


    public function testListMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'messages',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $this->client->messages->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'messages/message_id',
            null,
            null
        );
        $this->client->messages->read("message_id");
    }

    public function testDeleteMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "DELETE",
            'messages/message_id',
            null,
            null
        );
        $this->client->messages->delete("message_id");
    }

    public function testCreateMessageResponse()
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{
                  "id":"e8077d803532c0b5937c639b60216938",
                  "href":"https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938",
                  "direction":"mt",
                  "type":"sms",
                  "originator":"YourName",
                  "body":"This is a test message",
                  "reference":null,
                  "validity":null,
                  "gateway":null,
                  "typeDetails":{

                  },
                  "datacoding":"plain",
                  "mclass":1,
                  "scheduledDatetime":null,
                  "createdDatetime":"2015-07-03T07:55:31+00:00",
                  "recipients":{
                    "totalCount":1,
                    "totalSentCount":1,
                    "totalDeliveredCount":0,
                    "totalDeliveryFailedCount":0,
                    "items":[
                      {
                        "recipient":31612345678,
                        "status":"sent",
                        "statusDatetime":"2015-07-03T07:55:31+00:00"
                      }
                    ]
                  },
                  "reportUrl":null
                }',
        ]);

        /** @var MessageResponse $messageResponse */
        $messageResponse = $this->client->messages->create($message);

        $this->assertSame('e8077d803532c0b5937c639b60216938', $messageResponse->id);
        $this->assertSame(
            'https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938',
            $messageResponse->href
        );
        $this->assertSame('mt', $messageResponse->direction);
        $this->assertSame('sms', $messageResponse->type);
        $this->assertSame('YourName', $messageResponse->originator);
        $this->assertSame('This is a test message', $messageResponse->body);
        $this->assertNull($messageResponse->reference);
        $this->assertNull($messageResponse->validity);
        $this->assertNull($messageResponse->gateway);
        $this->assertEmpty($messageResponse->typeDetails);
        $this->assertSame('plain', $messageResponse->datacoding);
        $this->assertSame(1, $messageResponse->mclass);
        $this->assertNull($messageResponse->scheduledDatetime);
        $this->assertSame('2015-07-03T07:55:31+00:00', $messageResponse->createdDatetime);
        $this->assertSame(1, $messageResponse->recipients->totalCount);
        $this->assertSame(1, $messageResponse->recipients->totalSentCount);
        $this->assertSame(0, $messageResponse->recipients->totalDeliveredCount);
        $this->assertSame(0, $messageResponse->recipients->totalDeliveryFailedCount);
        $this->assertCount(1, $messageResponse->recipients->items);
        $this->assertSame(31612345678, $messageResponse->recipients->items[0]->recipient);
        $this->assertSame('sent', $messageResponse->recipients->items[0]->status);
        $this->assertSame('2015-07-03T07:55:31+00:00', $messageResponse->recipients->items[0]->statusDatetime);
    }
}
