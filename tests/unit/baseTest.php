<?php
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testClientConstructor()
    {
        $MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');
        $this->assertInstanceOf('MessageBird\Resources\Balance', $MessageBird->balance);
        $this->assertInstanceOf('MessageBird\Resources\Hlr', $MessageBird->hlr);
        $this->assertInstanceOf('MessageBird\Resources\Messages', $MessageBird->messages);
        $this->assertInstanceOf('MessageBird\Resources\VoiceMessage', $MessageBird->voicemessages);
        $this->assertInstanceOf('MessageBird\Resources\Otp', $MessageBird->otp);
    }
}
