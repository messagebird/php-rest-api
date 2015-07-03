<?php
class MessageTest extends BaseTest
{

	public function setUp(){
		parent::setup();
		$this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
	}
	public function testCreateMessage()
	{
		$Message             = new \MessageBird\Objects\Message();
		$Message->originator = 'MessageBird';
		$Message->recipients = array(31612345678);
		$Message->body = 'This is a test message.';

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
				  }
				}'));
		$this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'messages', null, '{"direction":"mt","type":"sms","originator":"MessageBird","body":"This is a test message.","reference":null,"validity":null,"gateway":null,"typeDetails":[],"datacoding":"plain","mclass":1,"scheduledDatetime":null,"recipients":[31612345678]}');
		$this->client->messages->create($Message);
	}

	/**
     * @expectedException     MessageBird\Exceptions\ServerException
   	*/
	public function testListMessage()
	{
		$this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'messages', array ('offset' => 100, 'limit' => 30), null);
		$MessageList = $this->client->messages->getList(array ('offset' => 100, 'limit' => 30));
	}
}
