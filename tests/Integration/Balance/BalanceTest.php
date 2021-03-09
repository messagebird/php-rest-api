<?php

namespace Tests\Integration\Balance;

use Tests\Integration\BaseTest;

class BalanceTest extends BaseTest
{
    public function testReadBalance()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'balance', null, null);
        $this->client->balance->read();
    }
}
