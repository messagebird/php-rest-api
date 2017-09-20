<?php
class MmsTest extends BaseTest
{
    /**
     * @expectedException \MessageBird\Exceptions\RequestException
     */
    public function testCreateMmsFail()
    {
        $MmsMessage = new \MessageBird\Objects\MmsMessage();

        $this->mockClient->expects($this->once())
            ->method('performHttpRequest')
            ->with('POST', 'mms', null, json_encode($MmsMessage))
            ->willReturn(array(422, '', '{"errors":[{"code":9,"description":"no (correct) recipients found","parameter":"recipients"}]}'));

        $this->client->mmsMessages->create($MmsMessage);
    }

    public function testCreateMmsSuccess()
    {
        $MmsMessage = $this->generateDummyMessage();
        $dummyMessageId = 'message_id';

        $this->mockClient->expects($this->once())
            ->method('performHttpRequest')
            ->with('POST', 'mms', null, json_encode($MmsMessage))
            ->willReturn(array(200, '', $this->generateMmsServerResponse($MmsMessage, $dummyMessageId)));

        $ResultMmsMessage = $this->client->mmsMessages->create($MmsMessage);

        $this->assertMessagesAreEqual($MmsMessage, $ResultMmsMessage, $dummyMessageId);
    }

    public function testListMms()
    {
        $dummyMessage = $this->generateDummyMessage();

        $this->mockClient->expects($this->once())
            ->method('performHttpRequest')
            ->with('GET', 'mms', array('offset' => '100', 'limit' => '30'), null)
            ->willReturn(array(200, '',
                '{ 
                    "offset": 0, "limit": 20, "count": 1, "totalCount": 1,
                    "links": {
                        "first": "https://rest.messagebird.com/mms/?offset=0&type=mms",
                        "previous": null,
                        "next": null,
                        "last": "https://rest.messagebird.com/mms/?offset=0&type=mms"
                    },
                    "items": [ ' . $this->generateMmsServerResponse($dummyMessage, 'message_id') . ',
                               ' . $this->generateMmsServerResponse($dummyMessage, 'message_id_2') . ']
                }'
            ));

        $ResultMessages = $this->client->mmsMessages->getList(array('offset' => 100, 'limit' => 30));

        $this->assertEquals(2, count($ResultMessages->items));
        $this->assertMessagesAreEqual($dummyMessage, $ResultMessages->items[0], 'message_id');
        $this->assertMessagesAreEqual($dummyMessage, $ResultMessages->items[1], 'message_id_2');

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
        $dummyMessage = $this->generateDummyMessage();

        $this->mockClient->expects($this->exactly(2))
            ->method('performHttpRequest')
            ->with('GET', $this->logicalOr('mms/message_id', 'mms/unknown_message_id'), null, null)
            ->will($this->onConsecutiveCalls(
                array('200', '', $this->generateMmsServerResponse($dummyMessage, 'message_id')),
                array('404', '', '{"errors":[{"code":20,"description":"message not found","parameter":null}]}')
            ));

        $ResultMmsMessage = $this->client->mmsMessages->read('message_id');
        $this->assertMessagesAreEqual($dummyMessage, $ResultMmsMessage, 'message_id');

        $this->setExpectedException('\MessageBird\Exceptions\RequestException');
        $this->client->mmsMessages->read('unknown_message_id');
    }

    /**
     * @return \MessageBird\Objects\MmsMessage
     */
    private function generateDummyMessage()
    {
        $MmsMessage = new \MessageBird\Objects\MmsMessage();
        $MmsMessage->originator = "MessageBird";
        $MmsMessage->direction = 'ot';
        $MmsMessage->recipients = array(31621938645);
        $MmsMessage->body = 'Have you seen this logo?';
        $MmsMessage->mediaUrls = array('https://www.messagebird.com/assets/images/og/messagebird.gif');
        return $MmsMessage;
    }

    private function assertMessagesAreEqual(\MessageBird\Objects\MmsMessage $MmsMessage, \MessageBird\Objects\MmsMessage $ResultMmsMessage, $expectedId)
    {
        $this->assertAttributeEquals($expectedId, 'id', $ResultMmsMessage);
        $this->assertAttributeEquals("https://rest.messagebird.com/mms/{$expectedId}", 'href', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->direction, 'direction', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->originator, 'originator', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->subject, 'subject', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->body, 'body', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->mediaUrls, 'mediaUrls', $ResultMmsMessage);
        $this->assertAttributeEquals($MmsMessage->reference, 'reference', $ResultMmsMessage);

        foreach($ResultMmsMessage->recipients->items as $item) {
            $this->assertArraySubset(array($item->recipient), $MmsMessage->recipients);
        }
    }

    /**
     * @return string JSON string containing the generated server response.
     */
    private function generateMmsServerResponse(\MessageBird\Objects\MmsMessage $MmsMessage, $messageId)
    {
        return '{
            "id": "' . $messageId . '",
            "href": "https://rest.messagebird.com/mms/' . $messageId . '",
            "direction": ' . json_encode($MmsMessage->direction) . ',
            "originator": ' . json_encode($MmsMessage->originator) . ',
            "subject": ' . json_encode($MmsMessage->subject) . ',
            "body": ' . json_encode($MmsMessage->body) . ',
            "mediaUrls": ' . json_encode($MmsMessage->mediaUrls) . ',
            "reference": ' . json_encode($MmsMessage->reference) . ',
            "scheduledDatetime": ' . json_encode($MmsMessage->scheduledDatetime) . ',
            "createdDatetime": "2017-09-19T15:08:46+00:00",
            "recipients": {
                "totalCount": 1,
                "totalSentCount": 1,
                "totalDeliveredCount": 0,
                "totalDeliveryFailedCount": 0,
                "items": [
                    {
                        "recipient": ' . json_encode($MmsMessage->recipients[0]) . ',
                        "status": "sent",
                        "statusDatetime": "2017-09-19T15:08:46+00:00"
                    }
                ]
            }
        }';
    }
}
