<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use MessageBird\Resources\Chat\Contact;
use MessageBird\Resources\Chat\Channel;
use MessageBird\Resources\Chat\Platform;
use MessageBird\Resources\Chat\Message;
use MessageBird\Resources\Verify;
use MessageBird\Resources\VoiceMessage;
use MessageBird\Resources\Groups;
use MessageBird\Resources\Contacts;
use MessageBird\Resources\Messages;
use MessageBird\Resources\Hlr;
use MessageBird\Resources\Balance;
use MessageBird\Common\HttpClient;

class BaseTest extends TestCase
{
    /** @var \MessageBird\Client */
    protected $client;

    /** @var \PHPUnit\Framework\MockObject\MockObject */
    protected $mockClient;

    protected function setUp()
    {
        parent::setUp();

        $this->mockClient = $this->getMockBuilder(HttpClient::class)->setConstructorArgs(["fake.messagebird.dev"])->getMock();
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
        $this->assertInstanceOf(Balance::class, $messageBird->balance);
        $this->assertInstanceOf(Hlr::class, $messageBird->hlr);
        $this->assertInstanceOf(Messages::class, $messageBird->messages);
        $this->assertInstanceOf(Contacts::class, $messageBird->contacts);
        $this->assertInstanceOf(Groups::class, $messageBird->groups);
        $this->assertInstanceOf(VoiceMessage::class, $messageBird->voicemessages);
        $this->assertInstanceOf(Verify::class, $messageBird->verify);
        $this->assertInstanceOf(Message::class, $messageBird->chatMessages);
        $this->assertInstanceOf(Platform::class, $messageBird->chatPlatforms);
        $this->assertInstanceOf(Channel::class, $messageBird->chatChannels);
        $this->assertInstanceOf(Contact::class, $messageBird->chatContacts);
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('addUserAgentString');
        new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }
}
