<?php
class MmsTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateMms()
    {
        $MmsMessage = new \MessageBird\Objects\MmsMessage();
        $MmsMessage->originator = 'MessageBird';
        $MmsMessage->recipients = array(31612345678);
        $MmsMessage->subject = 'Check out this cool MMS';
        $MmsMessage->body = 'Have you seen this logo?';
        $MmsMessage->mediaUrls = ['https://www.messagebird.com/assets/images/og/messagebird.gif'];

        $this->mockClient->method('performHttpRequest')->willReturn(array(200, '', '
            {
                "id": "3d4ab432f259491da662c5de0f0c8dae",
                "href": "https://rest.messagebird.com/mms/3d4ab432f259491da662c5de0f0c8dae",
                "direction": "mt",
                "originator": "MessageBird",
                "subject": "Check out this cool MMS",
                "body": "Have you seen this logo?",
                "mediaUrls": [
                    "https://www.messagebird.com/assets/images/og/messagebird.gif"
                ],
                "reference": null,
                "scheduledDatetime": null,
                "createdDatetime": "2017-09-19T15:08:46+00:00",
                "recipients": {
                    "totalCount": 1,
                    "totalSentCount": 1,
                    "totalDeliveredCount": 0,
                    "totalDeliveryFailedCount": 0,
                    "items": [
                        {
                            "recipient": 31612345678,
                            "status": "sent",
                            "statusDatetime": "2017-09-19T15:08:46+00:00"
                        }
                    ]
                }
            }
        '));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'mms', null, '{"direction":"mt","originator":"MessageBird","recipients":[31612345678],"subject":"Check out this cool MMS","body":"Have you seen this logo?","mediaUrls":["https:\/\/www.messagebird.com\/assets\/images\/og\/messagebird.gif"],"reference":null,"scheduledDatetime":null,"createdDatetime":null}');
        $this->client->mmsMessages->create($MmsMessage);
    }

    /**
     * @expectedException   MessageBird\Exceptions\ServerException
     */
    public function testListMms()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'mms', array('offset' => 100, 'limit' => 30), null);
        $this->client->mmsMessages->getList(array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException   MessageBird\Exceptions\ServerException
     */
    public function testDeleteMms()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'mms/message_id', null, null);
        $this->client->mmsMessages->delete('message_id');
    }

    /**
     * @expectedException   MessageBird\Exceptions\ServerException
     */
    public function testReadMms()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'mms/message_id', null, null);
        $this->client->mmsMessages->read('message_id');
    }
}