<?php

namespace Tests\Integration\Balance;

use MessageBird\Exceptions\ServerException;
use Tests\Integration\BaseTest;

class BalanceTest extends BaseTest
{
    public function testReadBalance(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with("GET", 'balance', null, null);
        $this->client->balance->read();
    }
}
