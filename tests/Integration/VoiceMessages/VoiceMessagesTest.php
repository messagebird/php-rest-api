<?php

namespace Tests\Integration\VoiceMessages;

use GuzzleHttp\Psr7\Response;
use MessageBird\Objects\DeleteResponse;
use MessageBird\Objects\Recipient;
use MessageBird\Objects\Recipients;
use MessageBird\Objects\VoiceMessage;
use Tests\Integration\BaseTest;

/**
 *
 */
class VoiceMessagesTest extends BaseTest
{
    /**
     * @return void
     */
    public function testVoiceMessageCreate(): void
    {
        $message = new VoiceMessage();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->language = "nl";
        $message->voice = "male";

        $this->mockClient->expects($this->once())->method('request')->with(
            "POST",
            'voicemessages',
            [
                'body' => [
                    'originator' => 'MessageBird',
                    'body' => 'This is a test message.',
                    'reference' => null,
                    'language' => 'nl',
                    'voice' => 'male',
                    'repeat' => 1,
                    'ifMachine' => 'continue',
                    'machineTimeout' => 7000,
                    'scheduledDatetime' => null,
                    'recipients' => [31612345678],
                    'reportUrl' => null,
                    'id' => null,
                    'href' => null,
                    'createdDatetime' => null,
                ]
            ],
        )
            ->willReturn(new Response(200, [], $this->loadResponseStub('sendVoiceMessageResponse')));

        $message = $this->client->voicemessages->create($message);

        self::assertEquals('e8077d803532c0b5937c639b60996938', $message->id);
    }

    /**
     * @return void
     */
    public function testListMessage(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with("GET", 'voicemessages?offset=0&limit=30')
            ->willReturn(new Response(200, [], $this->loadResponseStub('listVoiceMessageResponse')));

        $list = $this->client->voicemessages->list(['offset' => 0, 'limit' => 30]);

//        var_dump( $list->items[0]);exit;
        self::assertEquals(0, $list->offset);
        self::assertEquals(30, $list->limit);
        self::assertEquals(2, $list->count);
        self::assertEquals(2, $list->totalCount);
        self::assertEquals('https://rest.messagebird.com/voicemessages/?offset=0&limit=30&contact_id=65', $list->links['first']);
        self::assertEquals('https://rest.messagebird.com/voicemessages/?offset=0&limit=30&contact_id=65', $list->links['last']);
        self::assertNull($list->links['previous']);
        self::assertNull($list->links['next']);
        self::assertCount(1, $list->items);
        self::assertInstanceOf(VoiceMessage::class, $list->items[0]);
        self::assertEquals('e8077d803532c0b5937c639b60216938', $list->items[0]->id);
        self::assertEquals('https://rest.messagebird.com/voicemessages/e8077d803532c0b5937c639b60216938', $list->items[0]->href);
        self::assertEquals('The voice message to be sent', $list->items[0]->body);
        self::assertNull($list->items[0]->originator);
        self::assertNull($list->items[0]->scheduledDatetime);

        self::assertInstanceOf(Recipients::class, $list->items[0]->recipients);
        self::assertEquals(1, $list->items[0]->recipients->totalCount);
        self::assertEquals(1, $list->items[0]->recipients->totalSentCount);
        self::assertEquals(0, $list->items[0]->recipients->totalDeliveredCount);
        self::assertEquals(0, $list->items[0]->recipients->totalDeliveryFailedCount);

        self::assertCount(1, $list->items[0]->recipients->items);
        self::assertInstanceOf(Recipient::class, $list->items[0]->recipients->items[0]);
        self::assertEquals(31612345678, $list->items[0]->recipients->items[0]->recipient);
        self::assertEquals('calling', $list->items[0]->recipients->items[0]->status);
        self::assertEquals('2016-05-03T14:26:57+00:00', $list->items[0]->recipients->items[0]->statusDatetime);
    }

    /**
     * @return void
     */
    public function testReadMessage(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', 'voicemessages/e8077d803532c0b5937c639b60996938?')
            ->willReturn(new Response(200, [], $this->loadResponseStub('sendVoiceMessageResponse')));

        $message = $this->client->voicemessages->read('e8077d803532c0b5937c639b60996938');

        self::assertEquals('e8077d803532c0b5937c639b60996938', $message->id);
    }

    /**
     * @return void
     */
    public function testDeleteMessage(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('DELETE', 'voicemessages/e8077d803532c0b5937c639b60216938')
            ->willReturn(new Response(204, [], ''));

        $deleted = $this->client->voicemessages->delete("e8077d803532c0b5937c639b60216938");

        self::assertInstanceOf(DeleteResponse::class, $deleted);
    }
}
