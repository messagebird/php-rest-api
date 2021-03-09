<?php

namespace Tests\Integration\Numbers;

use Tests\Integration\BaseTest;

class AvailablePhoneNumbersTest extends BaseTest
{
    public function testListAvailablePhoneNumbers()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET', 'available-phone-numbers/nl', [], null);
        $this->client->availablePhoneNumbers->getList("nl", []);
    }
}
