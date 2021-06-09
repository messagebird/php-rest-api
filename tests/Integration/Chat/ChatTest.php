<?php

namespace Tests\Integration\Chat;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Chat\Channel;
use MessageBird\Objects\Chat\Message;
use Tests\Integration\BaseTest;

class ChatTest extends BaseTest
{
    public function testCreateChatMessage()
    {
        $chatMessage = new Message();
        $chatMessage->contactId = '9d754dac577e3ff103cdf4n29856560';
        $chatMessage->payload = 'This is a test message to test the Chat API';
        $chatMessage->type = 'text';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{"type":"text","payload":"This is a test message to test the Chat API","contactId":"9d754dac577e3ff103cdf4n29856560"}',
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'messages',
            null,
            '{"type":"text","payload":"This is a test message to test the Chat API","contactId":"9d754dac577e3ff103cdf4n29856560"}'
        );
        $this->client->chatMessages->create($chatMessage);
    }

    public function testListChatMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'messages',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $chatMessageList = $this->client->chatMessages->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadChatMessage()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages/id', null, null);
        $chatMessageList = $this->client->chatMessages->read("id");
    }


    public function testCreateChatChannel()
    {
        $chatChannel = new Channel();
        $chatChannel->name = 'Test Channel Telegram';
        $chatChannel->platformId = 'e84f332c5649a5f911e569n69330697';

        $chatChannel->channelDetails =
            [
                'botName' => 'testBot',
                'token' => '1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA',
            ];

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{"name":"Test Channel Telegram","platformId":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null}',
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'channels',
            null,
            '{"name":"Test Channel Telegram","platformId":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null}'
        );
        $this->client->chatChannels->create($chatChannel);
    }

    public function testListChatChannels()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'channels',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $channelList = $this->client->chatChannels->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadChatChannel()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'channels/id', null, null);
        $channel = $this->client->chatChannels->read("id");
    }

    public function testDeleteChannel()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "DELETE",
            'channels/id',
            null,
            null
        );
        $channel = $this->client->chatChannels->delete("id");
    }

    public function testUpdateChatChannel()
    {
        $chatChannel = new Channel();
        $chatChannel->name = '9d2345ac577e4f103cd3d4529856560';
        $chatChannel->callbackUrl = 'http://testurl.dev';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{"name":"9d2345ac577e4f103cd3d4529856560","callbackUrl":"http:\/\/testurl.dev"}',
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "PUT",
            'channels/234agfgADFH2974gaADFH3hudf9h',
            null,
            '{"name":"9d2345ac577e4f103cd3d4529856560","callbackUrl":"http:\/\/testurl.dev"}'
        );
        $this->client->chatChannels->update($chatChannel, '234agfgADFH2974gaADFH3hudf9h');
    }

    public function testListChatPlatforms()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'platforms',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $channelList = $this->client->chatPlatforms->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadChatPlatform()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'platforms/id',
            null,
            null
        );
        $channel = $this->client->chatPlatforms->read("id");
    }

    public function testListChatContacts()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'contacts',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $contactList = $this->client->chatContacts->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadChatContact()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'contacts/id', null, null);
        $contact = $this->client->chatContacts->read("id");
    }

    public function testDeleteContact()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "DELETE",
            'contacts/id',
            null,
            null
        );
        $contact = $this->client->chatContacts->delete("id");
    }
}
