<?php

namespace Tests\Integration\Verify;

use GuzzleHttp\Psr7\Response;
use MessageBird\Objects\DeleteResponse;
use MessageBird\Objects\Verify;
use Tests\Integration\BaseTest;

/**
 *
 */
class VerifyTest extends BaseTest
{
    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testCreate(): void
    {
        $verify = new Verify();
        $verify->recipient = '31612345678';
        $verify->reference = "Yoloswag3000";

        $this->mockClient->expects($this->once())->method('request')
            ->with(
                "POST",
                'verify',
                [
                    'body' => [
                        'recipient' => '31612345678',
                        'reference' => 'Yoloswag3000',
                        'id' => null,
                        'href' => null,
                        'messages' => null,
                        'status' => null,
                        'createdDatetime' => null,
                        'validUntilDatetime' => null,
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createVerifyResponse')));

        $resp = $this->client->verify->create($verify);

        self::assertInstanceOf(Verify::class, $resp);
        self::assertEquals('4e213b01155d1e35a9d9571v00162985', $resp->id);
        self::assertEquals('https://rest.messagebird.com/verify/4e213b01155d1e35a9d9571v00162985', $resp->href);
        self::assertEquals(31612345678, $resp->recipient);
        self::assertNull($resp->reference);
        self::assertEquals('https://rest.messagebird.com/messages/31bce2a1155d1f7c1db9df6b32167259', $resp->messages['href']);
        self::assertEquals('sent', $resp->status);
        self::assertEquals('2016-05-03T14:26:57+00:00', $resp->createdDatetime);
        self::assertEquals('2016-05-03T14:27:27+00:00', $resp->validUntilDatetime);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testCreateEmail(): void
    {
        $verify = new Verify();
        $verify->recipient = 'Client Name <client-email@example.com>';

        $options = [
            'type' => 'email',
            // This email domain needs to be set up as an email channel in your account at https://dashboard.messagebird.com/en/channels/
            'originator' => 'Email Verification <verify@company.com>',
            'timeout' => 60,
        ];

        $this->mockClient->expects($this->once())->method('request')
            ->with(
                "POST",
                'verify',
                [
                    'body' => [
                        'recipient' => 'Client Name <client-email@example.com>',
                        'reference' => null,
                        'id' => null,
                        'href' => null,
                        'messages' => null,
                        'status' => null,
                        'createdDatetime' => null,
                        'validUntilDatetime' => null,
                        ...$options
                    ]
                ]
            )
            ->willReturn(new Response(200, [], $this->loadResponseStub('createVerifyResponse')));

        $resp = $this->client->verify->create($verify, $options);

        self::assertInstanceOf(Verify::class, $resp);
        self::assertEquals('4e213b01155d1e35a9d9571v00162985', $resp->id);
        self::assertEquals('https://rest.messagebird.com/verify/4e213b01155d1e35a9d9571v00162985', $resp->href);
        self::assertEquals(31612345678, $resp->recipient);
        self::assertNull($resp->reference);
        self::assertEquals('https://rest.messagebird.com/messages/31bce2a1155d1f7c1db9df6b32167259', $resp->messages['href']);
        self::assertEquals('sent', $resp->status);
        self::assertEquals('2016-05-03T14:26:57+00:00', $resp->createdDatetime);
        self::assertEquals('2016-05-03T14:27:27+00:00', $resp->validUntilDatetime);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function testVerify(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', 'verify/bebrave?token=ukraine')
            ->willReturn(new Response(200, [], $this->loadResponseStub('createVerifyResponse')));

        $resp = $this->client->verify->verify('bebrave', 'ukraine');

        self::assertInstanceOf(Verify::class, $resp);
        self::assertEquals('4e213b01155d1e35a9d9571v00162985', $resp->id);
        self::assertEquals('https://rest.messagebird.com/verify/4e213b01155d1e35a9d9571v00162985', $resp->href);
        self::assertEquals(31612345678, $resp->recipient);
        self::assertNull($resp->reference);
        self::assertEquals('https://rest.messagebird.com/messages/31bce2a1155d1f7c1db9df6b32167259', $resp->messages['href']);
        self::assertEquals('sent', $resp->status);
        self::assertEquals('2016-05-03T14:26:57+00:00', $resp->createdDatetime);
        self::assertEquals('2016-05-03T14:27:27+00:00', $resp->validUntilDatetime);
    }

    /**
     * @return void
     */
    public function testRead(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('GET', 'verify/4e213b01155d1e35a9d9571v00162985?')
            ->willReturn(new Response(200, [], $this->loadResponseStub('createVerifyResponse')));

        $resp = $this->client->verify->read('4e213b01155d1e35a9d9571v00162985');

        self::assertInstanceOf(Verify::class, $resp);
        self::assertEquals('4e213b01155d1e35a9d9571v00162985', $resp->id);
        self::assertEquals('https://rest.messagebird.com/verify/4e213b01155d1e35a9d9571v00162985', $resp->href);
        self::assertEquals(31612345678, $resp->recipient);
        self::assertNull($resp->reference);
        self::assertEquals('https://rest.messagebird.com/messages/31bce2a1155d1f7c1db9df6b32167259', $resp->messages['href']);
        self::assertEquals('sent', $resp->status);
        self::assertEquals('2016-05-03T14:26:57+00:00', $resp->createdDatetime);
        self::assertEquals('2016-05-03T14:27:27+00:00', $resp->validUntilDatetime);
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->mockClient->expects($this->once())->method('request')
            ->with('DELETE', 'verify/71v00162985e35a94e213b01155d1d95')
            ->willReturn(new Response(200, [], ''));

        $resp = $this->client->verify->delete('71v00162985e35a94e213b01155d1d95');

        self::assertInstanceOf(DeleteResponse::class, $resp);
    }
}
