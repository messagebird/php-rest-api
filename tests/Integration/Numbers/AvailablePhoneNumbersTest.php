<?php

namespace Tests\Integration\Numbers;

use MessageBird\Exceptions\ServerException;
use Tests\Integration\BaseTest;

class AvailablePhoneNumbersTest extends BaseTest
{
    public function testListAvailablePhoneNumbers()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET',
            'available-phone-numbers/nl', [], null);
        $this->client->availablePhoneNumbers->getList("nl", []);
    }
}
