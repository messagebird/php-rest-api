<?php
class LookupTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testReadLookup()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678', null, null);
        $this->client->lookup->read(31612345678);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testReadLookupWithEmptyNumber()
    {
        $this->client->lookup->read(null);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testReadLookupWithCountryCode()
    {
        $params = array("countryCode" => "NL");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678', $params, null);
        $this->client->lookup->read(612345678, $params["countryCode"]);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testCreateLookupHlr()
    {
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 31612345678;
        $Hlr->reference  = 'Yoloswag3007';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'lookup/'.$Hlr->msisdn.'/hlr', null, json_encode($Hlr));

        $this->client->lookupHlr->create($Hlr);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateLookupHlrWithEmptyNumber()
    {
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = null;
        $this->client->lookupHlr->create($Hlr);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testCreateLookupHlrWithCountryCode()
    {
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 612345678;
        $Hlr->reference  = "CoolReference";

        $params = array("countryCode" => "NL");

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'lookup/'.$Hlr->msisdn.'/hlr', $params, json_encode($Hlr));

        $this->client->lookupHlr->create($Hlr, $params["countryCode"]);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testReadLookupHlr()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678/hlr', null, null);
        $this->client->lookupHlr->read(31612345678);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testReadLookupHlrWithEmptyNumber()
    {
        $this->client->lookupHlr->read(null);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testReadLookupHlrWithCountryCode()
    {
        $params = array("countryCode" => "NL");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/612345678/hlr', $params, null);
        $this->client->lookupHlr->read(612345678, $params["countryCode"]);
    }

}
