<?php

namespace Tests\Integration\VoiceMessages;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\VoiceMessage;
use Tests\Integration\BaseTest;

class VoiceMessagesTest extends BaseTest
{
    public function testVoiceMessageCreate()
    {
        $this->expectException(ServerException::class);
        $message = new VoiceMessage();
        $message->originator = 'MessageBird';
        $message->recipients = [31612345678];
        $message->body = 'This is a test message.';
        $message->language = "nl";
        $message->voice = "male";
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'voicemessages', null,
            '{"originator":"MessageBird","body":"This is a test message.","reference":null,"language":"nl","voice":"male","repeat":1,"ifMachine":"continue","machineTimeout":7000,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->voicemessages->create($message);
    }

    public function testListMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'voicemessages',
            ['offset' => 100, 'limit' => 30], null);
        $this->client->voicemessages->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'voicemessages/message_id',
            null, null);
        $this->client->voicemessages->read("message_id");
    }

    public function testDeleteMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE",
            'voicemessages/message_id', null, null);
        $this->client->voicemessages->delete("message_id");
    }
}
