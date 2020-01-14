<?php
class VoiceMessagesTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testVoiceMessageCreate()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $Message             = new \MessageBird\Objects\VoiceMessage();
        $Message->originator = 'MessageBird';
        $Message->recipients = array(31612345678);
        $Message->body       = 'This is a test message.';
        $Message->language   = "nl";
        $Message->voice      = "male";
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'voicemessages', null, '{"originator":"MessageBird","body":"This is a test message.","reference":null,"language":"nl","voice":"male","repeat":1,"ifMachine":"continue","machineTimeout":7000,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->voicemessages->create($Message);
    }

    public function testListMessage()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'voicemessages', array ('offset' => 100, 'limit' => 30), null);
        $this->client->voicemessages->getList(array ('offset' => 100, 'limit' => 30));
    }

    public function testReadMessage()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'voicemessages/message_id', null, null);
        $this->client->voicemessages->read("message_id");
    }

    public function testDeleteMessage()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'voicemessages/message_id', null, null);
        $this->client->voicemessages->delete("message_id");
    }
}
