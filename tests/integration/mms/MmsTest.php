<?php
class MmsTest extends BaseTest
{
    /** @group createMms */
    public function testCreateMms()
    {
        $MmsMessage = new \MessageBird\Objects\MmsMessage();
        $MmsMessage->originator = 'MessageBird';
        $MmsMessage->subject = 'Check out this cool MMS';
        $MmsMessage->body = 'Have you seen this logo?';
        $MmsMessage->recipients = array(31612345678);
        $MmsMessage->mediaUrls = array('https://www.messagebird.com/assets/images/og/messagebird.gif');

        $this->mockClient->expects($this->once())
            ->method('performHttpRequest')
            ->with('POST', 'mms', null, '{"direction":"mt","originator":"MessageBird","recipients":[31612345678],"subject":"Check out this cool MMS","body":"Have you seen this logo?","mediaUrls":["https:\/\/www.messagebird.com\/assets\/images\/og\/messagebird.gif"],"reference":null,"scheduledDatetime":null,"createdDatetime":null}')
            ->willReturn(array(200, '', '
                {
                    "id": "message_id",
                    "href": "https://rest.messagebird.com/mms/message_id",
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

        $MmsMessage = $this->client->mmsMessages->create($MmsMessage);

        $this->assertAttributeSame('message_id', 'id', $MmsMessage);
        $this->assertAttributeSame('https://rest.messagebird.com/mms/message_id', 'href', $MmsMessage);
        $this->assertAttributeSame('mt', 'direction', $MmsMessage);
    }

    public function testListMms()
    {
        $this->mockClient->expects($this->once())
            ->method('performHttpRequest')
            ->with('GET', 'mms', array('offset' => '100', 'limit' => '30'), null)
            ->willReturn(array(200, '',
                '{ "offset": 0, "limit": 20, "count": 1, "totalCount": 1,
                    "links": {
                        "first": "https://rest.messagebird.com/mms/?offset=0&type=mms",
                        "previous": null,
                        "next": null,
                        "last": "https://rest.messagebird.com/mms/?offset=0&type=mms"
                    },
                    "items": [ {
                            "id": "message_id",
                            "href": "https://rest.messagebird.com/mms/message_id",
                            "direction": "mt",
                            "type": "mms",
                            "originator": "MessageBird",
                            "body": "This is the body",
                            "reference": "This is the reference",
                            "validity": null,
                            "gateway": 9,
                            "typeDetails": { "mediaUrls": [ "https://www.messagebird.com/assets/images/og/messagebird.gif" ] },
                            "datacoding": "plain",
                            "mclass": 1,
                            "scheduledDatetime": null,
                            "createdDatetime": "2017-09-20T08:01:38+00:00",
                            "recipients": {
                                "totalCount": 1, "totalSentCount": 1, "totalDeliveredCount": 0, "totalDeliveryFailedCount": 0,
                                "items": [ { "recipient": 31612345678, "status": "sent", "statusDatetime": "2017-09-20T08:01:38+00:00" } ]
                            }
                        } ]
                }'
            ));

        $MmsMessagesList = $this->client->mmsMessages->getList(array('offset' => 100, 'limit' => 30));

        foreach($MmsMessagesList->items as $Item) {
            $this->assertInstanceOf('\MessageBird\Objects\MmsMessage', $Item);
        }
    }

    public function testDeleteMms()
    {
        $this->mockClient->expects($this->exactly(2))
            ->method('performHttpRequest')
            ->with('DELETE', 'mms/message_id', null, null)
            ->will($this->onConsecutiveCalls(
                array(204, '', ''),
                array(404, '', '{"errors":[{"code":20,"description":"message not found","parameter":null}]}')
            ));

        $this->client->mmsMessages->delete('message_id');

        $this->setExpectedException('\MessageBird\Exceptions\RequestException');
        $this->client->mmsMessages->delete('message_id');
    }

    public function testReadMms()
    {
        $this->mockClient->expects($this->exactly(2))
            ->method('performHttpRequest')
            ->with('GET', $this->logicalOr('mms/message_id', 'mms/unknown_message_id'), null, null)
            ->will($this->onConsecutiveCalls(
                array('200', '', '{"id":"message_id","href":"https://rest.messagebird.com/mms/message_id","direction":"mt","originator":"MessageBird","subject":null,"body":null,"mediaUrls":["https://www.messagebird.com/assets/images/og/messagebird.gif"],"reference":null,"scheduledDatetime":null,"createdDatetime":"2017-09-20T08:01:38+00:00","recipients":{"totalCount":1,"totalSentCount":1,"totalDeliveredCount":0,"totalDeliveryFailedCount":0,"items":[{"recipient":31612345678,"status":"sent","statusDatetime":"2017-09-20T08:01:38+00:00"}]}}'),
                array('404', '', '{"errors":[{"code":20,"description":"message not found","parameter":null}]}')
            ));

        $MmsMessage = $this->client->mmsMessages->read('message_id');
        $this->assertAttributeEquals('message_id', 'id', $MmsMessage);
        $this->assertAttributeEquals('https://rest.messagebird.com/mms/message_id', 'href', $MmsMessage);
        $this->assertAttributeEquals('mt', 'direction', $MmsMessage);
        $this->assertAttributeEquals('MessageBird', 'originator', $MmsMessage);

        foreach($MmsMessage->recipients->items as $Item) {
            $this->assertInstanceOf('\MessageBird\Objects\Recipient', $Item);
            $this->assertAttributeNotEmpty('recipient', $Item);
        }

        $this->setExpectedException('\MessageBird\Exceptions\RequestException');
        $this->client->mmsMessages->read('unknown_message_id');
    }
}
