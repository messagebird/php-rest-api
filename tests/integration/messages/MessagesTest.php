<?php
class MessageTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateMessage()
    {
        $Message             = new \MessageBird\Objects\Message();
        $Message->originator = 'MessageBird';
        $Message->recipients = array(31612345678);
        $Message->body       = 'This is a test message.';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{
                  "id":"e8077d803532c0b5937c639b60216938",
                  "href":"https://rest.messagebird.com/messages/e8077d803532c0b5937c639b60216938",
                  "direction":"mt",
                  "type":"sms",
                  "originator":"YourName",
                  "body":"This is a test message",
                  "reference":null,
                  "validity":null,
                  "gateway":null,
                  "typeDetails":{

                  },
                  "datacoding":"plain",
                  "mclass":1,
                  "scheduledDatetime":null,
                  "createdDatetime":"2015-07-03T07:55:31+00:00",
                  "recipients":{
                    "totalCount":1,
                    "totalSentCount":1,
                    "totalDeliveredCount":0,
                    "totalDeliveryFailedCount":0,
                    "items":[
                      {
                        "recipient":31612345678,
                        "status":"sent",
                        "statusDatetime":"2015-07-03T07:55:31+00:00"
                      }
                    ]
                  },
                  "reportUrl":null
                }'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"direction":"mt","type":"sms","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":[],"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->messages->create($Message);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testPremiumSmsMessage()
    {
        $Message             = new \MessageBird\Objects\Message();
        $Message->originator = 'MessageBird';
        $Message->recipients = array(31612345678);
        $Message->body       = 'This is a test message.';
        $Message->setPremiumSms(2002, 'mb', 1, 2);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"direction":"mt","type":"premium","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":{"shortcode":2002,"keyword":"mb","tariff":1,"mid":2},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->messages->create($Message);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testBinarySmsMessage()
    {
        $Message             = new \MessageBird\Objects\Message();
        $Message->originator = 'MessageBird';
        $Message->recipients = array(31612345678);
        $Message->body       = 'This is a test message.';
        $Message->setBinarySms("HEADER", "test");
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->messages->create($Message);
    }


    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testFlashSmsMessage()
    {
        $Message             = new \MessageBird\Objects\Message();
        $Message->originator = 'MessageBird';
        $Message->recipients = array(31612345678);
        $Message->body       = 'This is a test message.';
        $Message->setBinarySms("HEADER", "test");
        $Message->setFlash(true);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"direction":"mt","type":"binary","originator":"MessageBird","body":"test","reference":null,"validity":null,"gateway":null,"typeDetails":{"udh":"HEADER"},"datacoding":"plain","mclass":0,"scheduledDatetime":null,"recipients":[31612345678],"reportUrl":null}');
        $this->client->messages->create($Message);
    }


    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListMessage()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages', array ('offset' => 100, 'limit' => 30), null);
        $this->client->messages->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testReadMessage()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages/message_id', null, null);
        $this->client->messages->read("message_id");
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testDeleteMessage()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'messages/message_id', null, null);
        $this->client->messages->delete("message_id");
    }
}
