<?php
class HlrTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateHlr()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $Hlr             = new \MessageBird\Objects\Hlr();
        $Hlr->msisdn     = 'MessageBird';
        $Hlr->reference  = "yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'hlr', null, '{"msisdn":"MessageBird","network":null,"details":[],"reference":"yoloswag3000","status":null}');
        $this->client->hlr->create($Hlr);
    }


    public function testReadHlr()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'hlr/message_id', null, null);
        $this->client->hlr->read("message_id");
    }
}
