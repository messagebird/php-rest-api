<?php

namespace Tests\Integration\Voice;

use GuzzleHttp\Psr7\Response;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Voice\Call;
use MessageBird\Objects\Voice\CallFlow;
use MessageBird\Objects\Voice\Calls;
use MessageBird\Objects\Voice\Webhook;
use Tests\Integration\BaseTest;

class VoiceTest extends BaseTest
{
    /**
     * @throws \JsonMapper_Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListVoiceCall(): void
    {
        $this->mockClient->expects(self::once())->method('request')
            ->with('GET', 'calls?offset=0&limit=30')
            ->willReturn(new Response(200, [], $this->loadResponseStub('listCallsResponse')));

        $list = $this->client->voiceCalls->list(['offset' => 0, 'limit' => 30]);

        self::assertInstanceOf(Calls::class, $list);
        self::assertCount(1, $list->_links);
        self::assertEquals('/calls?page=1', $list->_links['self']);
        self::assertCount(4, $list->pagination);
        self::assertEquals(2, $list->pagination['totalCount']);
        self::assertEquals(1, $list->pagination['pageCount']);
        self::assertEquals(1, $list->pagination['currentPage']);
        self::assertEquals(10, $list->pagination['perPage']);
        self::assertCount(2, $list->data);
        self::assertInstanceOf(Call::class, $list->data[0]);

        self::assertEquals('f1aa71c0-8f2a-4fe8-b5ef-9a330454ef58', $list->data[0]->id);
        self::assertEquals('ended', $list->data[0]->status);
        self::assertEquals('31644556677', $list->data[0]->source);
        self::assertEquals('31612345678', $list->data[0]->destination);
        self::assertEquals('2017-02-16T10:52:00Z', $list->data[0]->createdAt);
        self::assertEquals('2017-02-16T10:59:04Z', $list->data[0]->updatedAt);
        self::assertEquals('2017-02-16T10:59:04Z', $list->data[0]->endedAt);
        self::assertCount(1, $list->data[0]->_links);
        self::assertEquals('/calls/f1aa71c0-8f2a-4fe8-b5ef-9a330454ef58', $list->data[0]->_links['self']);

        self::assertEquals('ac07a602-dbc1-11e6-bf26-cec0c932ce01', $list->data[1]->id);
        self::assertEquals('ended', $list->data[1]->status);
        self::assertEquals('31644556677', $list->data[1]->source);
        self::assertEquals('31612345678', $list->data[1]->destination);
        self::assertEquals('2017-01-16T07:51:56Z', $list->data[1]->createdAt);
        self::assertEquals('2017-01-16T07:55:56Z', $list->data[1]->updatedAt);
        self::assertEquals('2017-01-16T07:55:56Z', $list->data[1]->endedAt);
        self::assertCount(1, $list->data[1]->_links);
        self::assertEquals('/calls/ac07a602-dbc1-11e6-bf26-cec0c932ce01', $list->data[1]->_links['self']);
    }

    public function testReadVoiceCall(): void
    {
        $this->mockClient->expects(self::once())->method('request')
            ->with('GET', 'calls/ac07a602-dbc1-11e6-bf26-cec0c932ce01')
            ->willReturn(new Response(200, [], $this->loadResponseStub('viewCallResponse')));

        $call = $this->client->voiceCalls->read('ac07a602-dbc1-11e6-bf26-cec0c932ce01');

        self::assertInstanceOf(Call::class, $call);

        self::assertEquals('f1aa71c0-8f2a-4fe8-b5ef-9a330454ef58', $call->id);
        self::assertEquals('ended', $call->status);
        self::assertEquals('31644556677', $call->source);
        self::assertEquals('31612345678', $call->destination);
        self::assertEquals('2017-02-16T10:52:00Z', $call->createdAt);
        self::assertEquals('2017-02-16T10:59:04Z', $call->updatedAt);
        self::assertEquals('2017-02-16T10:59:04', $call->endedAt);
    }

    public function testCreateVoiceCall(): void
    {
        $voiceCall = new Call();
        $voiceCall->source = '31612354678';
        $voiceCall->destination = '31611223344';
        $voiceCall->callFlow = [
            'title' => 'Foobar',
            'steps' => [
                [
                    'action' => 'hangup',
                ],
            ],
        ];
        $voiceCall->webhook = [
            'url' => 'https://example.com',
            'token' => 'token_to_sign_the_call_events_with',
        ];

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                'POST',
                'calls',
                [
                    'body' => [
                        'source' => '31612354678',
                        'destination' => '31611223344',
                        'callFlow' => [
                            'title' => 'Foobar',
                            'steps' => [
                                ['action' => 'hangup'],
                            ],
                        ],
                        'webhook' => [
                            'url' => 'https://example.com',
                            'token' => 'token_to_sign_the_call_events_with',
                        ],
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createCallResponse')));

        $call = $this->client->voiceCalls->create($voiceCall);

        self::assertInstanceOf(Call::class, $call);

        self::assertEquals('21025ed1-cc1d-4554-ac05-043fa6c84e00', $call->id);
        self::assertEquals('queued', $call->status);
        self::assertEquals('31644556677', $call->source);
        self::assertEquals('31612345678', $call->destination);
        self::assertEquals('2017-08-30T07:35:37Z', $call->createdAt);
        self::assertEquals('2017-08-30T07:35:37Z', $call->updatedAt);
        self::assertNull($call->endedAt);
    }

    public function testUpdateVoiceCall(): void
    {
        $voiceCall = new Call();
        $voiceCall->source = '31612354678';
        $voiceCall->destination = '31611223344';
        $voiceCall->callFlow = [
            'title' => 'Foobar',
            'steps' => [
                [
                    'action' => 'hangup',
                ],
            ],
        ];
        $voiceCall->webhook = [
            'url' => 'https://example.com',
            'token' => 'token_to_sign_the_call_events_with',
        ];

        $this->mockClient->expects(self::once())->method('request')
            ->with(
                'POST',
                'calls',
                [
                    'body' => [
                        'source' => '31612354678',
                        'destination' => '31611223344',
                        'callFlow' => [
                            'title' => 'Foobar',
                            'steps' => [
                                ['action' => 'hangup'],
                            ],
                        ],
                        'webhook' => [
                            'url' => 'https://example.com',
                            'token' => 'token_to_sign_the_call_events_with',
                        ],
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createCallResponse')));

        $call = $this->client->voiceCalls->create($voiceCall);

        self::assertInstanceOf(Call::class, $call);

        self::assertEquals('21025ed1-cc1d-4554-ac05-043fa6c84e00', $call->id);
        self::assertEquals('queued', $call->status);
        self::assertEquals('31644556677', $call->source);
        self::assertEquals('31612345678', $call->destination);
        self::assertEquals('2017-08-30T07:35:37Z', $call->createdAt);
        self::assertEquals('2017-08-30T07:35:37Z', $call->updatedAt);
        self::assertNull($call->endedAt);
    }

    public function testListVoiceLegs(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with("GET", 'calls/foobar/legs', [
            'offset' => 100,
            'limit' => 30,
        ], null);
        $this->client->voiceLegs->getList('foobar', ['offset' => 100, 'limit' => 30]);
    }

    public function testReadVoiceLeg(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar',
            null,
            null
        );
        $this->client->voiceLegs->read('foo', 'bar');
    }

    public function testListVoiceRecordings(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings',
            [
                'offset' => 100,
                'limit' => 30,
            ],
            null
        );
        $this->client->voiceRecordings->getList('foo', 'bar', ['offset' => 100, 'limit' => 30]);
    }

    public function testReadVoiceRecording(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings/baz',
            null,
            null
        );
        $this->client->voiceRecordings->read('foo', 'bar', 'baz');
    }

    public function testDeleteVoiceRecording(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([204, '', null]);
        $this->client->voiceRecordings->delete('foo', 'bar', 'baz');
    }


    public function testDownloadVoiceRecording(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings/baz.wav',
            null,
            null
        );
        $this->client->voiceRecordings->download('foo', 'bar', 'baz');
    }

    public function testCreateVoiceTranscription(): void
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            201,
            '',
            '{
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
}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'calls/foo/legs/bar/recordings/baz/transcriptions',
            null,
            null
        );
        $this->client->voiceTranscriptions->create('foo', 'bar', 'baz');
    }

    public function testListVoiceTranscriptions(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings/baz/transcriptions',
            [
                'offset' => 100,
                'limit' => 30,
            ],
            null
        );
        $this->client->voiceTranscriptions->getList('foo', 'bar', 'baz', ['offset' => 100, 'limit' => 30]);
    }

    public function testReadVoiceTranscription(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings/baz/transcriptions/bups',
            null,
            null
        );
        $this->client->voiceTranscriptions->read('foo', 'bar', 'baz', 'bups');
    }

    public function testDownloadVoiceTranscription(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'calls/foo/legs/bar/recordings/baz/transcriptions/bups.txt',
            null,
            null
        );
        $this->client->voiceTranscriptions->download('foo', 'bar', 'baz', 'bups');
    }

    public function testListVoiceWebhooks(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with("GET", 'webhooks', [
            'offset' => 100,
            'limit' => 30,
        ], null);
        $this->client->voiceWebhooks->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadVoiceWebhook(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'webhooks/foobar',
            null,
            null
        );
        $this->client->voiceWebhooks->read('foobar');
    }

    public function testCreateVoiceWebhook(): void
    {
        $webhook = new Webhook();
        $webhook->url = 'https://example.com/';
        $webhook->token = 'foobar';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            201,
            '',
            '{
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
}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'webhooks',
            null,
            '{"url":"https:\/\/example.com\/","token":"foobar"}'
        );
        $this->client->voiceWebhooks->create($webhook);
    }

    public function testUpdateVoiceWebhook(): void
    {
        $webhook = new Webhook();
        $webhook->url = 'https://example.com/foo';
        $webhook->token = 'foobar';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{
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
}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "PUT",
            'webhooks/foobar123',
            null,
            '{"url":"https:\/\/example.com\/foo","token":"foobar"}'
        );
        $this->client->voiceWebhooks->updateBasic($webhook, 'foobar123');
    }

    public function testDeleteVoiceWebhook(): void
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([204, '', null]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "DELETE",
            'webhooks/foobar123',
            null,
            ''
        );
        $this->client->voiceWebhooks->delete('foobar123');
    }


    public function testListVoiceCallFlows(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with("GET", 'call-flows', [
            'offset' => 100,
            'limit' => 30,
        ], null);
        $this->client->voiceCallFlows->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testReadVoiceCallFlow(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "GET",
            'call-flows/foobar',
            null,
            null
        );
        $this->client->voiceCallFlows->read('foobar');
    }

    public function testCreateVoiceCallFlow(): void
    {
        $callFlow = new CallFlow();
        $callFlow->steps = [
            [
                'action' => 'transfer',
                'options' => [
                    'destination' => '31612345678',
                ],
            ],
        ];

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            201,
            '',
            '{
  "data": [
    {
      "id": "de3ed163-d5fc-45f4-b8c4-7eea7458c635",
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
}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "POST",
            'call-flows',
            null,
            '{"steps":[{"action":"transfer","options":{"destination":"31612345678"}}]}'
        );
        $this->client->voiceCallFlows->create($callFlow);
    }

    public function testUpdateVoiceCallFlow(): void
    {
        $webhook = new Webhook();
        $webhook->title = 'Updated call flow';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{
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
}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "PUT",
            'call-flows/foobar123',
            null,
            '{"title":"Updated call flow"}'
        );
        $this->client->voiceCallFlows->updateBasic($webhook, 'foobar123');
    }

    public function testDeleteVoiceCallFlow(): void
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([204, '', null]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            "DELETE",
            'call-flows/foobar123',
            null,
            ''
        );
        $this->client->voiceCallFlows->delete('foobar123');
    }
}
