<?php

namespace Tests\Integration\Balance;

use GuzzleHttp\Psr7\Response;
use Tests\Integration\BaseTest;

class BalanceTest extends BaseTest
{
    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testReadBalance(): void
    {
        $this->mockClient->expects(self::once())->method('request')
            ->with('GET', 'balance')
            ->willReturn(new Response(200, [], $this->loadResponseStub('balanceResponse')));

        $balance = $this->client->balance->read();

        self::assertEquals('prepaid', $balance->payment);
        self::assertEquals('euros', $balance->type);
        self::assertEquals(103.55, $balance->amount);
    }
}
