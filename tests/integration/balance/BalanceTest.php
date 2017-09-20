<?php
class BalanceTest extends BaseTest
{
    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadBalance()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'balance', null, null);
        $this->client->balance->read();
    }
}
