<?php
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockClient = $this->getMockBuilder("\MessageBird\Common\HttpClient")->setConstructorArgs(array("fake.messagebird.dev"))->getMock();
    }

    public function testClientConstructor()
    {
        $MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');
        $this->assertInstanceOf('MessageBird\Resources\Balance', $MessageBird->balance);
        $this->assertInstanceOf('MessageBird\Resources\Hlr', $MessageBird->hlr);
        $this->assertInstanceOf('MessageBird\Resources\Messages', $MessageBird->messages);
        $this->assertInstanceOf('MessageBird\Resources\VoiceMessage', $MessageBird->voicemessages);
        $this->assertInstanceOf('MessageBird\Resources\Verify', $MessageBird->verify);
    }

    public function testHttpClientMock()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('addUserAgentString');
        $client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }
}
