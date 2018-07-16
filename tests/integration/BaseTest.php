<?php
// Starting from PHPUnit 6, PHPUnit classes are namespaced. This alias ensures our tests still run
// with PHPUnit >=6. See: https://github.com/sebastianbergmann/phpunit/wiki/Release-Announcement-for-PHPUnit-6.0.0
if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
}

class BaseTest extends PHPUnit_Framework_TestCase
{
    /** @var \MessageBird\Client */
    protected $client;

    /** @var PHPUnit_Framework_MockObject_MockObject */
    protected $mockClient;

    public function setUp()
    {
        $this->mockClient = $this->getMockBuilder("\MessageBird\Common\HttpClient")->setConstructorArgs(array("fake.messagebird.dev"))->getMock();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * Prevents a test that performs no assertions from being considered risky.
     * The doesNotPerformAssertions annotation is not available in earlier PHPUnit
     * versions, and hence can not be used.
     */
    protected function doAssertionToNotBeConsideredRiskyTest()
    {
        static::assertTrue(true);
    }

    public function testClientConstructor()
    {
        $MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');
        $this->assertInstanceOf('MessageBird\Resources\Balance', $MessageBird->balance);
        $this->assertInstanceOf('MessageBird\Resources\Hlr', $MessageBird->hlr);
        $this->assertInstanceOf('MessageBird\Resources\Messages', $MessageBird->messages);
        $this->assertInstanceOf('MessageBird\Resources\Contacts', $MessageBird->contacts);
        $this->assertInstanceOf('MessageBird\Resources\Groups', $MessageBird->groups);
        $this->assertInstanceOf('MessageBird\Resources\VoiceMessage', $MessageBird->voicemessages);
        $this->assertInstanceOf('MessageBird\Resources\Verify', $MessageBird->verify);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Message', $MessageBird->chatMessages);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Platform', $MessageBird->chatPlatforms);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Channel', $MessageBird->chatChannels);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Contact', $MessageBird->chatContacts);

    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('addUserAgentString');
        new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }
}
