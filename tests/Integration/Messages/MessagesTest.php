<?php

namespace Tests\Integration\Messages;

use GuzzleHttp\Psr7\Response;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Messages\Message;
use Tests\Integration\BaseTest;

class MessagesTest extends BaseTest
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreateMessage(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                'POST',
                'messages',
                [
                    'body' => [
                        'direction' => 'mt',
                        'type' => 'sms',
                        'href' => null,
                        'originator' => 'MessageBird',
                        'body' => 'This is a test message.',
                        'reference' => null,
                        'validity' => null,
                        'gateway' => null,
                        'typeDetails' => [],
                        'datacoding' => 'plain',
                        'mclass' => 1,
                        'scheduledDatetime' => null,
                        'recipients' => [31612345678],
                        'reportUrl' => null,
                        'createdDatetime' => null,
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createMessageResponse')));

        $message = $this->client->messages->create($message);

        self::assertSame('e8077d803532c0b5937c639b60216938', $message->id);
        self::assertSame(
            'https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938',
            $message->href
        );
        self::assertSame('mt', $message->direction);
        self::assertSame('sms', $message->type);
        self::assertSame('YourName', $message->originator);
        self::assertSame('This is a test message', $message->body);
        self::assertNull($message->reference);
        self::assertNull($message->validity);
        self::assertNull($message->gateway);
        self::assertEmpty($message->typeDetails);
        self::assertSame('plain', $message->datacoding);
        self::assertSame(1, $message->mclass);
        self::assertNull($message->scheduledDatetime);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->createdDatetime);
        self::assertSame(1, $message->recipients->totalCount);
        self::assertSame(1, $message->recipients->totalSentCount);
        self::assertSame(0, $message->recipients->totalDeliveredCount);
        self::assertSame(0, $message->recipients->totalDeliveryFailedCount);
        self::assertCount(1, $message->recipients->items);
        self::assertSame(31612345678, $message->recipients->items[0]->recipient);
        self::assertSame('sent', $message->recipients->items[0]->status);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->recipients->items[0]->statusDatetime);
        self::assertSame('successfully delivered', $message->recipients->items[0]->statusReason);
        self::assertSame(null, $message->recipients->items[0]->statusErrorCode);
        self::assertSame('Netherlands', $message->recipients->items[0]->recipientCountry);
        self::assertSame(31, $message->recipients->items[0]->recipientCountryPrefix);
        self::assertSame('KPN', $message->recipients->items[0]->recipientOperator);
        self::assertSame('20408', $message->recipients->items[0]->mccmnc);
        self::assertSame('204', $message->recipients->items[0]->mcc);
        self::assertSame('08', $message->recipients->items[0]->mnc);
        self::assertSame(22, $message->recipients->items[0]->messageLength);
        self::assertSame(1, $message->recipients->items[0]->messagePartCount);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBinarySmsMessage(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->setBinarySms("HEADER", "test");

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                "POST",
                'messages',
                [
                    'body' => [
                        'direction' => 'mt',
                        'type' => 'binary',
                        'href' => null,
                        'originator' => 'MessageBird',
                        'body' => 'test',
                        'reference' => null,
                        'validity' => null,
                        'gateway' => null,
                        'typeDetails' => ["udh" => "HEADER"],
                        'datacoding' => 'plain',
                        'mclass' => 1,
                        'scheduledDatetime' => null,
                        'recipients' => [31612345678],
                        'reportUrl' => null,
                        'createdDatetime' => null,
                    ]
                ]
            )->willReturn(new Response(200, [], $this->loadResponseStub('createBinaryMessageResponse')));

        $message = $this->client->messages->create($message);

        self::assertSame('binary', $message->type);
        self::assertSame(["udh" => "HEADER"], $message->typeDetails);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFlashSmsMessage(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->setBinarySms("HEADER", "test");
        $message->setFlash(true);

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                "POST",
                'messages',
                [
                    'body' => [
                        'direction' => 'mt',
                        'type' => 'binary',
                        'href' => null,
                        'originator' => 'MessageBird',
                        'body' => 'test',
                        'reference' => null,
                        'validity' => null,
                        'gateway' => null,
                        'typeDetails' => ["udh" => "HEADER"],
                        'datacoding' => 'plain',
                        'mclass' => 0,
                        'scheduledDatetime' => null,
                        'recipients' => [31612345678],
                        'reportUrl' => null,
                        'createdDatetime' => null,
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createFlashMessageResponse')));

        $message = $this->client->messages->create($message);

        self::assertSame('binary', $message->type);
        self::assertSame(["udh" => "HEADER"], $message->typeDetails);
        self::assertSame(0, $message->mclass);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListMessage(): void
    {
        $this->mockClient->expects(self::once())
            ->method('request')
            ->with("GET", 'messages?offset=0&limit=20')
            ->willReturn(new Response(200, [], $this->loadResponseStub('listMessageResponse')));

        $messages = $this->client->messages->list(['offset' => 0, 'limit' => 20]);

        self::assertSame(20, $messages->limit);
        self::assertSame(0, $messages->offset);
        self::assertSame(2, $messages->count);
        self::assertSame(2, $messages->totalCount);
        self::assertCount(2, $messages->items);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ServerException
     * @throws \JsonMapper_Exception
     */
    public function testReadMessage(): void
    {
        $this->mockClient->expects(self::once())->method('request')
            ->with("GET", 'messages/6fe65f90999aa61536e6a88b88972670?')
            ->willReturn(new Response(200, [], $this->loadResponseStub('createMessageResponse')));

        $message = $this->client->messages->read("6fe65f90999aa61536e6a88b88972670");

        self::assertSame('e8077d803532c0b5937c639b60216938', $message->id);
        self::assertSame(
            'https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938',
            $message->href
        );
        self::assertSame('mt', $message->direction);
        self::assertSame('sms', $message->type);
        self::assertSame('YourName', $message->originator);
        self::assertSame('This is a test message', $message->body);
        self::assertNull($message->reference);
        self::assertNull($message->validity);
        self::assertNull($message->gateway);
        self::assertEmpty($message->typeDetails);
        self::assertSame('plain', $message->datacoding);
        self::assertSame(1, $message->mclass);
        self::assertNull($message->scheduledDatetime);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->createdDatetime);
        self::assertSame(1, $message->recipients->totalCount);
        self::assertSame(1, $message->recipients->totalSentCount);
        self::assertSame(0, $message->recipients->totalDeliveredCount);
        self::assertSame(0, $message->recipients->totalDeliveryFailedCount);
        self::assertCount(1, $message->recipients->items);
        self::assertSame(31612345678, $message->recipients->items[0]->recipient);
        self::assertSame('sent', $message->recipients->items[0]->status);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->recipients->items[0]->statusDatetime);
        self::assertSame('successfully delivered', $message->recipients->items[0]->statusReason);
        self::assertSame(null, $message->recipients->items[0]->statusErrorCode);
        self::assertSame('Netherlands', $message->recipients->items[0]->recipientCountry);
        self::assertSame(31, $message->recipients->items[0]->recipientCountryPrefix);
        self::assertSame('KPN', $message->recipients->items[0]->recipientOperator);
        self::assertSame('20408', $message->recipients->items[0]->mccmnc);
        self::assertSame('204', $message->recipients->items[0]->mcc);
        self::assertSame('08', $message->recipients->items[0]->mnc);
        self::assertSame(22, $message->recipients->items[0]->messageLength);
        self::assertSame(1, $message->recipients->items[0]->messagePartCount);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function testDeleteMessage(): void
    {
        $message = new Message();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';

        $this->mockClient->expects(self::once())->method('request')
            ->with('PUT', 'messages/6fe65f90999aa61536e6a88b88972670')
            ->willReturn(new Response(204, [], $this->loadResponseStub('createMessageResponse')));

        $message = $this->client->messages->update("6fe65f90999aa61536e6a88b88972670", $message);

        self::assertSame('mt', $message->direction);
        self::assertSame('sms', $message->type);
        self::assertSame('YourName', $message->originator);
        self::assertSame('This is a test message', $message->body);
        self::assertNull($message->reference);
        self::assertNull($message->validity);
        self::assertNull($message->gateway);
        self::assertEmpty($message->typeDetails);
        self::assertSame('plain', $message->datacoding);
        self::assertSame(1, $message->mclass);
        self::assertNull($message->scheduledDatetime);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->createdDatetime);
        self::assertSame(1, $message->recipients->totalCount);
        self::assertSame(1, $message->recipients->totalSentCount);
        self::assertSame(0, $message->recipients->totalDeliveredCount);
        self::assertSame(0, $message->recipients->totalDeliveryFailedCount);
        self::assertCount(1, $message->recipients->items);
        self::assertSame(31612345678, $message->recipients->items[0]->recipient);
        self::assertSame('sent', $message->recipients->items[0]->status);
        self::assertSame('2015-07-03T07:55:31+00:00', $message->recipients->items[0]->statusDatetime);
        self::assertSame('successfully delivered', $message->recipients->items[0]->statusReason);
        self::assertSame(null, $message->recipients->items[0]->statusErrorCode);
        self::assertSame('Netherlands', $message->recipients->items[0]->recipientCountry);
        self::assertSame(31, $message->recipients->items[0]->recipientCountryPrefix);
        self::assertSame('KPN', $message->recipients->items[0]->recipientOperator);
        self::assertSame('20408', $message->recipients->items[0]->mccmnc);
        self::assertSame('204', $message->recipients->items[0]->mcc);
        self::assertSame('08', $message->recipients->items[0]->mnc);
        self::assertSame(22, $message->recipients->items[0]->messageLength);
        self::assertSame(1, $message->recipients->items[0]->messagePartCount);
    }
}
