<?php

namespace Tests\Integration\Hlr;

use GuzzleHttp\Psr7\Response;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Hlr;
use Tests\Integration\BaseTest;

class HlrTest extends BaseTest
{
    public function testCreateHlr(): void
    {
        $hlr = new Hlr();
        $hlr->msisdn = 'MessageBird';
        $hlr->reference = "example.org";

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                'POST',
                'hlr',
                [
                    'body' => [
                        'msisdn' => 'MessageBird',
                        'network' => null,
                        'details' => [],
                        'reference' => 'example.org',
                        'status' => null,
                        'id' => null,
                        'href' => null,
                        'createdDatetime' => null,
                        'statusDatetime' => null,
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createHLRResponse')));

        $response = $this->client->hlr->create($hlr);

        self::assertInstanceOf(Hlr::class, $response);
        self::assertEquals('0da180b035398662ceb3c42h04904985', $response->id);
        self::assertEquals('https://rest.messagebird.com/hlr/0da180b035398662ceb3c42h04904985', $response->href);
        self::assertEquals(31612345678, $response->msisdn);
        self::assertNull($response->network);
        self::assertEmpty($response->details);
        self::assertEquals('YourReference', $response->reference);
        self::assertEquals('sent', $response->status);
        self::assertEquals('2016-05-04T07:32:46+00:00', $response->createdDatetime);
        self::assertEquals('2016-05-04T07:32:46+00:00', $response->statusDatetime);
    }

    public function testReadHlr(): void
    {
        $this->mockClient->expects(self::once())->method('request')
            ->with("GET", 'hlr/3c42h049049850da180b035398662ceb?')
            ->willReturn(new Response(200, [], $this->loadResponseStub('viewHLRResponse')));

        $hlr = $this->client->hlr->read("3c42h049049850da180b035398662ceb");

        self::assertInstanceOf(Hlr::class, $hlr);
        self::assertEquals('3c42h049049850da180b035398662ceb', $hlr->id);
        self::assertEquals('https://rest.messagebird.com/hlr/3c42h049049850da180b035398662ceb', $hlr->href);
        self::assertEquals(31612345678, $hlr->msisdn);
        self::assertEquals(20406, $hlr->network);
        self::assertEquals('YourReference', $hlr->reference);
        self::assertEquals('active', $hlr->status);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->createdDatetime);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->statusDatetime);

        self::assertNull($hlr->details['status_desc']);
        self::assertEquals('204080010948431', $hlr->details['imsi']);
        self::assertEquals('NLD', $hlr->details['country_iso']);
        self::assertEquals('Netherlands', $hlr->details['country_name']);
        self::assertEquals('316530', $hlr->details['location_msc']);
        self::assertEquals('nl', $hlr->details['location_iso']);
        self::assertEquals(0, $hlr->details['ported']);
        self::assertEquals(0, $hlr->details['roaming']);
    }
}
