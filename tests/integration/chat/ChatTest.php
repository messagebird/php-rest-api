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
        $ChatMessage             = new \MessageBird\Objects\Chat\Message();
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
        $ChatChannel = new \MessageBird\Objects\Chat\Channel();
        $ChatChannel->name = 'Test Channel Telegram';
        $ChatChannel->platformId = 'e84f332c5649a5f911e569n69330697';

        $ChatChannel->channelDetails =
            array(
                'botName' => 'testBot',
                'token' => '1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA'
            );

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{"name":"Test Channel Telegram","platformId":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null,"endpoint":null}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'channels', null, '{"name":"Test Channel Telegram","platformId":"e84f332c5649a5f911e569n69330697","channelDetails":{"botName":"testBot","token":"1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA"},"callbackUrl":null,"endpoint":null}');
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

    public function testUpdateChatChannel()
    {
        $ChatChannel             = new \MessageBird\Objects\Chat\Channel();
        $ChatChannel->name = '9d2345ac577e4f103cd3d4529856560';
        $ChatChannel->callbackUrl = 'http://testurl.dev';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{"name":"9d2345ac577e4f103cd3d4529856560","callbackUrl":"http:\/\/testurl.dev"}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("PUT", 'channels/234agfgADFH2974gaADFH3hudf9h', null, '{"name":"9d2345ac577e4f103cd3d4529856560","callbackUrl":"http:\/\/testurl.dev"}');
        $this->client->chatchannels->update($ChatChannel,'234agfgADFH2974gaADFH3hudf9h');
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

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListChatContacts()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'contacts', array ('offset' => 100, 'limit' => 30), null);
        $ContactList = $this->client->chatcontacts->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadChatContact()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'contacts/id', null, null);
        $Contact = $this->client->chatcontacts->read("id");
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testDeleteContact()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'contacts/id', null, null);
        $contact = $this->client->chatcontacts->delete("id");
    }
}
