<?php

namespace Tests\Integration\Verify;

use Tests\Integration\BaseTest;

class VerifyTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testGenerateOtp()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $verify             = new \MessageBird\Objects\Verify();
        $verify->recipient  = 31612345678;
        $verify->reference  = "Yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'verify', null, '{"recipient":31612345678,"reference":"Yoloswag3000"}');

        $this->client->verify->create($verify);
    }

    public function testVerifyOtp()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $verify            = new \MessageBird\Objects\Verify();
        $verify->recipient = 31612345678;
        $verify->reference = 'Yoloswag3000';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'verify/onofao3f82f7u2fb2uf', ['token' => '123456']);

        $this->client->verify->verify('onofao3f82f7u2fb2uf', 123456);
    }
}
