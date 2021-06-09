<?php

namespace Tests\Integration\Lookup;

use InvalidArgumentException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Hlr;
use Tests\Integration\BaseTest;

class LookupTest extends BaseTest
{
    public function testReadLookup()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678', null,
            null);
        $this->client->lookup->read(31612345678);
    }

    public function testReadLookupWithEmptyNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->lookup->read(null);
    }

    public function testReadLookupWithCountryCode()
    {
        $this->expectException(ServerException::class);
        $params = ["countryCode" => "NL"];
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678',
            $params, null);
        $this->client->lookup->read(612345678, $params["countryCode"]);
    }

    public function testCreateLookupHlr()
    {
        $this->expectException(ServerException::class);
        $hlr = new Hlr();
        $hlr->msisdn = 31612345678;
        $hlr->reference = 'Yoloswag3007';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST",
            'lookup/' . $hlr->msisdn . '/hlr', null, json_encode($hlr));

        $this->client->lookupHlr->create($hlr);
    }

    public function testCreateLookupHlrWithEmptyNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        $hlr = new Hlr();
        $hlr->msisdn = null;
        $this->client->lookupHlr->create($hlr);
    }

    public function testCreateLookupHlrWithCountryCode()
    {
        $this->expectException(ServerException::class);
        $hlr = new Hlr();
        $hlr->msisdn = 612345678;
        $hlr->reference = "CoolReference";

        $params = ["countryCode" => "NL"];

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST",
            'lookup/' . $hlr->msisdn . '/hlr', $params, json_encode($hlr));

        $this->client->lookupHlr->create($hlr, $params["countryCode"]);
    }

    public function testReadLookupHlr()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678/hlr',
            null, null);
        $this->client->lookupHlr->read(31612345678);
    }

    public function testReadLookupHlrWithEmptyNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->client->lookupHlr->read(null);
    }

    public function testReadLookupHlrWithCountryCode()
    {
        $this->expectException(ServerException::class);
        $params = ["countryCode" => "NL"];
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678/hlr',
            $params, null);
        $this->client->lookupHlr->read(612345678, $params["countryCode"]);
    }
}
