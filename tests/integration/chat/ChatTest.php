<?php
class ChatTest extends BaseTest
{
    public function setUp()
    {
        parent::setup();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateChatMessage()
    {
        $ChatMessage             = new \MessageBird\Objects\ChatMessage();
        $ChatMessage->contactId = '9d754dac577e3ff103cdf4n29856560';
        $ChatMessage->payload = 'This is a test message to test the Chat API';
        $ChatMessage->type = 'text';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{"type":"text","payload":"This is a test message to test the Chat API","contactId":"9d754dac577e3ff103cdf4n29856560","endpoint":null}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"type":"text","payload":"This is a test message to test the Chat API","contactId":"9d754dac577e3ff103cdf4n29856560","endpoint":null}');
        $this->client->chatmessages->create($ChatMessage);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListChatMessage()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages', array ('offset' => 100, 'limit' => 30), null);
        $ChatMessageList = $this->client->chatmessages->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadChatMessage()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages/id', null, null);
        $ChatMessageList = $this->client->chatmessages->read("id");
    }


    public function testCreateChatChannel()
    {
        $ChatChannel = new \MessageBird\Objects\ChatChannel();
        $ChatChannel->name = 'Test Channel Telegram';
        $ChatChannel->platform_id = 'e84f332c5649a5f911e569n69330697';

        $ChatChannel->channelDetails =
            array(
                'botName' => 'testBot',
                'token' => '1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA'
            );

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{"name":"Test Channel Telegram","platform_id":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null,"endpoint":null}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'channels', null, '{"name":"Test Channel Telegram","platform_id":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null,"endpoint":null}');
        $this->client->chatchannels->create($ChatChannel);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListChatChannels()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'channels', array ('offset' => 100, 'limit' => 30), null);
        $ChannelList = $this->client->chatchannels->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadChatChannel()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'channels/id', null, null);
        $Channel = $this->client->chatchannels->read("id");
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testDeleteChannel()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'channels/id', null, null);
        $Channel = $this->client->chatchannels->delete("id");
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListChatPlatforms()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'platforms', array ('offset' => 100, 'limit' => 30), null);
        $ChannelList = $this->client->chatplatforms->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadChatPlatform()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'platforms/id', null, null);
        $Channel = $this->client->chatplatforms->read("id");
    }
}
