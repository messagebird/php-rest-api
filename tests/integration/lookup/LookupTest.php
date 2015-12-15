<?php
class LookupTest extends BaseTest
{
    public function setUp()
    {
        parent::setup();
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
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testCreateLookupHLR()
    {
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 31612345678;
        $Hlr->reference  = 'Yoloswag3007';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'lookup/'.$Hlr->msisdn.'/hlr', null, json_encode($Hlr));

        $this->client->lookupHLR->create($Hlr);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testReadLookupHLR()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'lookup/31612345678/hlr', null, null);
        $this->client->lookupHLR->read(31612345678);
    }

}
