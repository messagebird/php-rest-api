<?php
class AvailablePhoneNumbersTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testListAvailablePhoneNumbers()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET', 'available-phone-numbers/nl', array (), null);
        $this->client->availablePhoneNumbers->getList("nl", array());
    }
}
