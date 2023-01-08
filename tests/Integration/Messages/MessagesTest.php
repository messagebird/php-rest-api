<?php

namespace Tests\Integration\Messages;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Message;
use MessageBird\Objects\MessageResponse;
use Tests\Integration\BaseTest;

class MessagesTest extends BaseTest
{
    public function testCreateMessage(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([
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
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"sms","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":[],"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }

    public function testBinarySmsMessage(): void
    {
        $this->expectException(ServerException::class);
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->setBinarySms("HEADER", "test");
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }


    public function testFlashSmsMessage(): void
    {
        $this->expectException(ServerException::class);
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->setBinarySms("HEADER", "test");
        $message->setFlash(true);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":0,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}'
        );
        $this->client->messages->create($message);
    }


    public function testListMessage(): void
    {
        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            file_get_contents(__DIR__ . '/get-list-response.json')
        ]);

        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'messages',
            ['offset' => 100, 'limit' => 30],
            null
        );


        $messageList = $this->client->messages->getList(['offset' => 100, 'limit' => 30]);

        self::assertSame('7d8451f8', $messageList->items[0]->id);
        self::assertSame('https://rest.messagebird.com/messages/7d8451f8', $messageList->items[0]->href);

        self::assertSame('7d8451f9', $messageList->items[1]->id);
        self::assertSame('https://rest.messagebird.com/messages/7d8451f9', $messageList->items[1]->href);

    }

    public function testReadMessage(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'messages/message_id',
            null,
            null
        );
        $this->client->messages->read("message_id");
    }

    public function testDeleteMessage(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "DELETE",
            'messages/message_id',
            null,
            null
        );
        $this->client->messages->delete("message_id");
    }

    public function testCreateMessageResponse(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([
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
                        "statusDatetime":"2015-07-03T07:55:31+00:00",
                        "statusReason":"successfully delivered",
                        "statusErrorCode":null,
                        "recipientCountry":"Netherlands",
                        "recipientCountryPrefix":31,
                        "recipientOperator":"KPN",
                        "mccmnc":"20408",
                        "mcc":"204",
                        "mnc":"08",
                        "messageLength":22,
                        "messagePartCount":1,
                        "price":{
                            "amount":0.075,
                            "currency":"EUR"
                        }
                      }
                    ]
                  },
                  "reportUrl":null
                }',
        ]);

        /** @var MessageResponse $messageResponse */
        $messageResponse = $this->client->messages->create($message);

        self::assertSame('e8077d803532c0b5937c639b60216938', $messageResponse->id);
        self::assertSame(
            'https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938',
            $messageResponse->href
        );
        self::assertSame('mt', $messageResponse->direction);
        self::assertSame('sms', $messageResponse->type);
        self::assertSame('YourName', $messageResponse->originator);
        self::assertSame('This is a test message', $messageResponse->body);
        self::assertNull($messageResponse->reference);
        self::assertNull($messageResponse->validity);
        self::assertNull($messageResponse->gateway);
        self::assertEmpty($messageResponse->typeDetails);
        self::assertSame('plain', $messageResponse->datacoding);
        self::assertSame(1, $messageResponse->mclass);
        self::assertNull($messageResponse->scheduledDatetime);
        self::assertSame('2015-07-03T07:55:31+00:00', $messageResponse->createdDatetime);
        self::assertSame(1, $messageResponse->recipients->totalCount);
        self::assertSame(1, $messageResponse->recipients->totalSentCount);
        self::assertSame(0, $messageResponse->recipients->totalDeliveredCount);
        self::assertSame(0, $messageResponse->recipients->totalDeliveryFailedCount);
        self::assertCount(1, $messageResponse->recipients->items);
        self::assertSame(31612345678, $messageResponse->recipients->items[0]->recipient);
        self::assertSame('sent', $messageResponse->recipients->items[0]->status);
        self::assertSame('2015-07-03T07:55:31+00:00', $messageResponse->recipients->items[0]->statusDatetime);
        self::assertSame('successfully delivered', $messageResponse->recipients->items[0]->statusReason);
        self::assertSame(null, $messageResponse->recipients->items[0]->statusErrorCode);
        self::assertSame('Netherlands', $messageResponse->recipients->items[0]->recipientCountry);
        self::assertSame(31, $messageResponse->recipients->items[0]->recipientCountryPrefix);
        self::assertSame('KPN', $messageResponse->recipients->items[0]->recipientOperator);
        self::assertSame('20408', $messageResponse->recipients->items[0]->mccmnc);
        self::assertSame('204', $messageResponse->recipients->items[0]->mcc);
        self::assertSame('08', $messageResponse->recipients->items[0]->mnc);
        self::assertSame(22, $messageResponse->recipients->items[0]->messageLength);
        self::assertSame(1, $messageResponse->recipients->items[0]->messagePartCount);           
    }
}
