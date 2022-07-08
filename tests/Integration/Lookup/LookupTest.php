<?php

namespace Tests\Integration\Lookup;

use GuzzleHttp\Psr7\Response;
use MessageBird\Objects\Hlr;
use MessageBird\Objects\Lookup;
use Tests\Integration\BaseTest;

/**
 *
 */
class LookupTest extends BaseTest
{
    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testReadLookup(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', 'lookup/31612345678')
            ->willReturn(new Response(200, [], $this->loadResponseStub('createLookupResponse')));

        $lookup = $this->client->lookup->read('31612345678');

        self::assertInstanceOf(Lookup::class, $lookup);
        self::assertEquals('https://rest.messagebird.com/lookup/31612345678', $lookup->href);
        self::assertEquals('NL', $lookup->countryCode);
        self::assertEquals(31, $lookup->countryPrefix);
        self::assertEquals(31612345678, $lookup->phoneNumber);
        self::assertEquals('mobile', $lookup->type);
        self::assertEquals('+31612345678', $lookup->formats['e164']);
        self::assertEquals('+31 6 12345678', $lookup->formats['international']);
        self::assertEquals('06 12345678', $lookup->formats['national']);
        self::assertEquals('tel:+31-6-12345678', $lookup->formats['rfc3966']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testReadLookupWithCountryCode(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with("GET", 'lookup/612345678?countryCode=NL')
            ->willReturn(new Response(200, [], $this->loadResponseStub('createLookupResponse')));

        $lookup = $this->client->lookup->read('612345678', 'NL');

        self::assertInstanceOf(Lookup::class, $lookup);
        self::assertEquals('https://rest.messagebird.com/lookup/31612345678', $lookup->href);
        self::assertEquals('NL', $lookup->countryCode);
        self::assertEquals(31, $lookup->countryPrefix);
        self::assertEquals(31612345678, $lookup->phoneNumber);
        self::assertEquals('mobile', $lookup->type);
        self::assertEquals('+31612345678', $lookup->formats['e164']);
        self::assertEquals('+31 6 12345678', $lookup->formats['international']);
        self::assertEquals('06 12345678', $lookup->formats['national']);
        self::assertEquals('tel:+31-6-12345678', $lookup->formats['rfc3966']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testCreateLookupHlr(): void
    {
        $phoneNumber = '31612345678';
        $reference = 'example.org';

        $this->mockClient->expects($this->once())->method('request')
            ->with(
                "POST",
                "lookup/$phoneNumber/hlr",
                ['body' => ['reference' => $reference]],
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createLookupHLRResponse')));

        $hlr = $this->client->lookupHlr->create($phoneNumber, $reference);

        self::assertInstanceOf(Hlr::class, $hlr);
        self::assertEquals('0da180b035398662ceb3c42h04904985', $hlr->id);
        self::assertEquals('https://rest.messagebird.com/hlr/0da180b035398662ceb3c42h04904985', $hlr->href);
        self::assertEquals(31612345678, $hlr->msisdn);
        self::assertNull($hlr->network);
        self::assertEmpty($hlr->details);
        self::assertEquals('example.org', $hlr->reference);
        self::assertEquals('sent', $hlr->status);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->createdDatetime);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->statusDatetime);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testCreateLookupHlrWithCountryCode(): void
    {
        $phoneNumber = '31612345678';
        $countryCode = 'UA';

        $this->mockClient->expects($this->once())->method('request')
            ->with(
                "POST",
                "lookup/$phoneNumber/hlr",
                ['body' => ['countryCode' => $countryCode]],
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createLookupHLRResponse')));

        $hlr = $this->client->lookupHlr->create($phoneNumber, null, $countryCode);

        self::assertInstanceOf(Hlr::class, $hlr);
        self::assertEquals('0da180b035398662ceb3c42h04904985', $hlr->id);
        self::assertEquals('https://rest.messagebird.com/hlr/0da180b035398662ceb3c42h04904985', $hlr->href);
        self::assertEquals(31612345678, $hlr->msisdn);
        self::assertNull($hlr->network);
        self::assertEmpty($hlr->details);
        self::assertEquals('example.org', $hlr->reference);
        self::assertEquals('sent', $hlr->status);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->createdDatetime);
        self::assertEquals('2016-05-04T07:32:46+00:00', $hlr->statusDatetime);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testReadLookupHlr(): void
    {
        $phoneNumber = '31612345678';

        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', "lookup/$phoneNumber/hlr")
            ->willReturn(new Response(200, [], $this->loadResponseStub('viewLookupHLRResponse')));

        $hlr = $this->client->lookupHlr->read('31612345678');

        self::assertInstanceOf(Hlr::class, $hlr);
        self::assertEquals('0da180b035398662ceb3c42h04904985', $hlr->id);
        self::assertEquals('https://rest.messagebird.com/hlr/0da180b035398662ceb3c42h04904985', $hlr->href);
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

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testReadLookupHlrWithCountryCode(): void
    {
        $phoneNumber = '31612345678';
        $countryCode = 'UA';

        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', "lookup/$phoneNumber/hlr?countryCode=$countryCode")
            ->willReturn(new Response(200, [], $this->loadResponseStub('viewLookupHLRResponse')));

        $hlr = $this->client->lookupHlr->read('31612345678', $countryCode);

        self::assertInstanceOf(Hlr::class, $hlr);
        self::assertEquals('0da180b035398662ceb3c42h04904985', $hlr->id);
        self::assertEquals('https://rest.messagebird.com/hlr/0da180b035398662ceb3c42h04904985', $hlr->href);
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
