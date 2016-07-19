<?php
class HlrTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testCreateHlr()
    {
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 'MessageBird';
        $Hlr->reference  = "yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'hlr', null, '{"msisdn":"MessageBird","network":null,"details":[],"reference":"yoloswag3000","status":null}');
        $this->client->hlr->create($Hlr);
    }


    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadHlr()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'hlr/message_id', null, null);
        $this->client->hlr->read("message_id");
    }
}
