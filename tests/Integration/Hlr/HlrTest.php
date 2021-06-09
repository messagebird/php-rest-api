<?php

namespace Tests\Integration\Hlr;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Hlr;
use Tests\Integration\BaseTest;

class HlrTest extends BaseTest
{
    public function testCreateHlr()
    {
        $this->expectException(ServerException::class);
        $hlr = new Hlr();
        $hlr->msisdn = 'MessageBird';
        $hlr->reference = "yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "POST",
            'hlr',
            null,
            '{"msisdn":"MessageBird","network":null,"details":[],"reference":"yoloswag3000","status":null}'
        );
        $this->client->hlr->create($hlr);
    }


    public function testReadHlr()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'hlr/message_id',
            null,
            null
        );
        $this->client->hlr->read("message_id");
    }
}
