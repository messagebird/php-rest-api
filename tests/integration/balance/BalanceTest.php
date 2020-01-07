<?php
class BalanceTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadBalance()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'balance', null, null);
        $this->client->balance->read();
    }
}
