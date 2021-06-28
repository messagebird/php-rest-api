<?php

namespace Tests\Unit\MessageBird\Objects;

use MessageBird\Objects\EmailMessage;
use PHPUnit\Framework\TestCase;

class EmailMessageTest extends TestCase
{
    /**
     * Load From Array
     *
     * @dataProvider loadFromArrayDataProvider()
     */
    public function testLoadFromArray($array, $expected): void
    {
        $message = new EmailMessage();

        $message->loadFromArray($array);

        self::assertSame($expected['id'], $message->getId());
        self::assertSame($expected['status'], $message->getStatus());
        self::assertSame($expected['failure_code'], $message->getFailureCode());
        self::assertSame($expected['failure_description'], $message->getFailureDescription());
    }

    public function loadFromArrayDataProvider(): array
    {
        return [
            'as array' => [
                'array' => [
                    'id' => '123456789',
                    'status' => 'sent',
                ],
                'expected' => [
                    'id' => '123456789',
                    'status' => 'sent',
                    'failure_code' => null,
                    'failure_description' => null,
                ],
            ],
            'as object' => [
                'array' => (object) [
                    'id' => 'aa12bb34cc56dd78ee90ff',
                    'status' => 'queued',
                ],
                'expected' => [
                    'id' => 'aa12bb34cc56dd78ee90ff',
                    'status' => 'queued',
                    'failure_code' => null,
                    'failure_description' => null,
                ],
            ],
            'failed as array' => [
                'array' => [
                    'id' => 'test_id',
                    'status' => 'failed',
                    'failure_code' => 20,
                    'failure_description' => 'channel not found',

                ],
                'expected' => [
                    'id' => 'test_id',
                    'status' => 'failed',
                    'failure_code' => 20,
                    'failure_description' => 'channel not found',
                ],
            ],
            'failed as object' => [
                'array' => json_decode(json_encode([
                    'id' => 'test_object_id',
                    'status' => 'failed',
                    'failure_code' => 10,
                    'failure_description' => 'test error',
                ])),
                'expected' => [
                    'id' => 'test_object_id',
                    'status' => 'failed',
                    'failure_code' => 10,
                    'failure_description' => 'test error',
                ],
            ],
        ];
    }
}
