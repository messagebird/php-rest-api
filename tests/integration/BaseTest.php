<?php
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
