<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /** @var \MessageBird\Client */
    protected $client;

    /** @var \PHPUnit\Framework\MockObject\MockObject */
    protected $mockClient;

    protected function setUp()
    {
        $this->mockClient = $this->getMockBuilder("\MessageBird\Common\HttpClient")->setConstructorArgs(["fake.messagebird.dev"])->getMock();
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
        $messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');
        $this->assertInstanceOf('MessageBird\Resources\Balance', $messageBird->balance);
        $this->assertInstanceOf('MessageBird\Resources\Hlr', $messageBird->hlr);
        $this->assertInstanceOf('MessageBird\Resources\Messages', $messageBird->messages);
        $this->assertInstanceOf('MessageBird\Resources\Contacts', $messageBird->contacts);
        $this->assertInstanceOf('MessageBird\Resources\Groups', $messageBird->groups);
        $this->assertInstanceOf('MessageBird\Resources\VoiceMessage', $messageBird->voicemessages);
        $this->assertInstanceOf('MessageBird\Resources\Verify', $messageBird->verify);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Message', $messageBird->chatMessages);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Platform', $messageBird->chatPlatforms);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Channel', $messageBird->chatChannels);
        $this->assertInstanceOf('MessageBird\Resources\Chat\Contact', $messageBird->chatContacts);
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('addUserAgentString');
        new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }
}
