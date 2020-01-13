<?php
class LookupTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testReadLookup()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678', null, null);
        $this->client->lookup->read(31612345678);
    }

    public function testReadLookupWithEmptyNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->lookup->read(null);
    }

    public function testReadLookupWithCountryCode()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $params = array("countryCode" => "NL");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678', $params, null);
        $this->client->lookup->read(612345678, $params["countryCode"]);
    }

    public function testCreateLookupHlr()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 31612345678;
        $Hlr->reference  = 'Yoloswag3007';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'lookup/'.$Hlr->msisdn.'/hlr', null, json_encode($Hlr));

        $this->client->lookupHlr->create($Hlr);
    }

    public function testCreateLookupHlrWithEmptyNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = null;
        $this->client->lookupHlr->create($Hlr);
    }

    public function testCreateLookupHlrWithCountryCode()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 612345678;
        $Hlr->reference  = "CoolReference";

        $params = array("countryCode" => "NL");

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'lookup/'.$Hlr->msisdn.'/hlr', $params, json_encode($Hlr));

        $this->client->lookupHlr->create($Hlr, $params["countryCode"]);
    }

    public function testReadLookupHlr()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678/hlr', null, null);
        $this->client->lookupHlr->read(31612345678);
    }

    public function testReadLookupHlrWithEmptyNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->lookupHlr->read(null);
    }

    public function testReadLookupHlrWithCountryCode()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $params = array("countryCode" => "NL");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678/hlr', $params, null);
        $this->client->lookupHlr->read(612345678, $params["countryCode"]);
    }

}
