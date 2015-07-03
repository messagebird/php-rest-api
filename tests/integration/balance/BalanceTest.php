<?php
class BalanceTest extends BaseTest
{
    public function setUp()
    {
        parent::setup();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadBalance()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'balance', null, null);
        $Hlr = $this->client->balance->read();
    }
}
