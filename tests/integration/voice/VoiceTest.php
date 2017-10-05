<?php

class VoiceTest extends BaseTest
{
    /** @var \MessageBird\Client client */
    public $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceCall()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceCalls->getList(array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceCall()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foobar', null, null);
        $this->client->voiceCalls->read('foobar');
    }

    public function testCreateVoiceCall()
    {
        $voiceCall = new \MessageBird\Objects\Voice\Call();
        $voiceCall->source = '31612354678';
        $voiceCall->destination = '31611223344';
        $voiceCall->callFlow = array(
            'title' => 'Foobar',
            'steps' => array(
                array(
                    'action' => 'hangup',
                ),
            ),
        );

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(201, '', '{
  "data": [
    {
      "id": "21025ed1-cc1d-4554-ac05-043fa6c84e00",
      "status": "starting",
      "source": "31644556677",
      "destination": "31612345678",
      "createdAt": "2017-08-30T07:35:37Z",
      "updatedAt": "2017-08-30T07:35:37Z",
      "endedAt": null
    }
  ],
  "_links": {
    "self": "/calls/21025ed1-cc1d-4554-ac05-043fa6c84e00"
  }
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'calls', null, '{"source":"31612354678","destination":"31611223344","callFlow":{"title":"Foobar","steps":[{"action":"hangup"}]}}');
        $this->client->voiceCalls->create($voiceCall);
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceLegs()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foobar/legs', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceLegs->getList('foobar', array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceLeg()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar', null, null);
        $this->client->voiceLegs->read('foo', 'bar');
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceRecordings()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceRecordings->getList('foo', 'bar', array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceRecording()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings/baz', null, null);
        $this->client->voiceRecordings->read('foo', 'bar', 'baz');
    }


    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testDownloadVoiceRecording()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings/baz.wav', null, null);
        $this->client->voiceRecordings->download('foo', 'bar', 'baz');
    }

    public function testCreateVoiceTranscription()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(201, '', '{
  "data": [
     {
       "id": "87c377ce-1629-48b6-ad01-4b4fd069c53c",
       "recordingID": "baz",
       "error": null,
       "createdAt": "2017-06-20T10:03:14Z",
       "updatedAt": "2017-06-20T10:03:14Z",
       "_links": {
         "self": "/calls/foo/legs/bar/recordings/baz/transcriptions/87c377ce-1629-48b6-ad01-4b4fd069c53c",
         "file": "/calls/foo/legs/bar/recordings/baz/transcriptions/87c377ce-1629-48b6-ad01-4b4fd069c53c.txt"
       }
     }
  ]
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'calls/foo/legs/bar/recordings/baz/transcriptions', null, null);
        $this->client->voiceTranscriptions->create('foo', 'bar', 'baz');
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceTranscriptions()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings/baz/transcriptions', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceTranscriptions->getList('foo', 'bar', 'baz', array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceTranscription()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings/baz/transcriptions/bups', null, null);
        $this->client->voiceTranscriptions->read('foo', 'bar', 'baz', 'bups');
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testDownloadVoiceTranscription()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'calls/foo/legs/bar/recordings/baz/transcriptions/bups.txt', null, null);
        $this->client->voiceTranscriptions->download('foo', 'bar', 'baz', 'bups');
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceWebhooks()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'webhooks', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceWebhooks->getList(array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceWebhook()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'webhooks/foobar', null, null);
        $this->client->voiceWebhooks->read('foobar');
    }

    public function testCreateVoiceWebhook()
    {
        $webhook = new \MessageBird\Objects\Voice\Webhook();
        $webhook->url = 'https://example.com/';
        $webhook->token = 'foobar';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(201, '', '{
  "data": [
    {
      "id": "534e1848-235f-482d-983d-e3e11a04f58a",
      "url": "https://example.com/",
      "token": "foobar",
      "createdAt": "2017-03-15T13:28:32Z",
      "updatedAt": "2017-03-15T13:28:32Z",
      "_links": {
        "self": "/webhooks/534e1848-235f-482d-983d-e3e11a04f58a"
      }
    }
  ],
  "_links": {
    "self": "/webhooks?page=1"
  },
  "pagination": {
    "totalCount": 1,
    "pageCount": 1,
    "currentPage": 1,
    "perPage": 10
  }
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'webhooks', null, '{"url":"https:\/\/example.com\/","token":"foobar"}');
        $this->client->voiceWebhooks->create($webhook);
    }

    public function testUpdateVoiceWebhook()
    {
        $webhook = new \MessageBird\Objects\Voice\Webhook();
        $webhook->url = 'https://example.com/foo';
        $webhook->token = 'foobar';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{
  "data": [
    {
      "id": "foobar123",
      "url": "https://example.com/baz",
      "token": "foobar",
      "createdAt": "2017-03-15T13:27:02Z",
      "updatedAt": "2017-03-15T13:28:01Z"
    }
  ],
  "_links": {
    "self": "/webhooks/534e1848-235f-482d-983d-e3e11a04f58a"
  }
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("PUT", 'webhooks/foobar123', null, '{"url":"https:\/\/example.com\/foo","token":"foobar"}');
        $this->client->voiceWebhooks->update($webhook, 'foobar123');
    }

    public function testDeleteVoiceWebhook()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(204, '', null));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'webhooks/foobar123', null, '');
        $this->client->voiceWebhooks->delete('foobar123');
    }


    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testListVoiceCallFlows()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'call-flows', array(
            'offset' => 100,
            'limit' => 30,
        ), null);
        $this->client->voiceCallFlows->getList(array('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException MessageBird\Exceptions\ServerException
     */
    public function testReadVoiceCallFlow()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'call-flows/foobar', null, null);
        $this->client->voiceCallFlows->read('foobar');
    }

    public function testCreateVoiceCallFlow()
    {
        $callFlow = new \MessageBird\Objects\Voice\CallFlow();
        $callFlow->title = 'Foobar';
        $callFlow->steps = array(
           array(
               'action' => 'transfer',
               'options' => array(
                   'destination' => '31612345678',
               ),
           ) ,
        );

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(201, '', '{
  "data": [
    {
      "id": "de3ed163-d5fc-45f4-b8c4-7eea7458c635",
      "title": "Forward call to 31612345678",
      "steps": [
        {
          "id": "3538a6b8-5a2e-4537-8745-f72def6bd393",
          "action": "transfer",
          "options": {
            "destination": "31612345678"
          }
        }
      ],
      "createdAt": "2017-03-06T13:34:14Z",
      "updatedAt": "2017-03-06T13:34:14Z",
      "_links": {
        "self": "/call-flows/de3ed163-d5fc-45f4-b8c4-7eea7458c635"
      }
    }
  ],
  "_links": {
    "self": "/call-flows?page=1"
  },
  "pagination": {
    "totalCount": 1,
    "pageCount": 1,
    "currentPage": 1,
    "perPage": 10
  }
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'call-flows', null, '{"title":"Foobar","steps":[{"action":"transfer","options":{"destination":"31612345678"}}]}');
        $this->client->voiceCallFlows->create($callFlow);
    }

    public function testUpdateVoiceCallFlow()
    {
        $webhook = new \MessageBird\Objects\Voice\Webhook();
        $webhook->title = 'Updated call flow';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(200, '', '{
  "data": [
    {
      "id": "de3ed163-d5fc-45f4-b8c4-7eea7458c635",
      "title": "Updated call flow",
      "steps": [
        {
          "id": "3538a6b8-5a2e-4537-8745-f72def6bd393",
          "action": "transfer",
          "options": {
            "destination": "31611223344"
          }
        }
      ],
      "createdAt": "2017-03-06T13:34:14Z",
      "updatedAt": "2017-03-06T15:02:38Z"
    }
  ],
  "_links": {
    "self": "/call-flows/de3ed163-d5fc-45f4-b8c4-7eea7458c635"
  }
}'));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("PUT", 'call-flows/foobar123', null, '{"title":"Updated call flow"}');
        $this->client->voiceCallFlows->update($webhook, 'foobar123');
    }

    public function testDeleteVoiceCallFlow()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn(array(204, '', null));
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'call-flows/foobar123', null, '');
        $this->client->voiceCallFlows->delete('foobar123');
    }
}
