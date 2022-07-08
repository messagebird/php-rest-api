<?php

namespace Tests\Integration\Numbers;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Number;
use MessageBird\Objects\NumberPurchaseRequest;
use Tests\Integration\BaseTest;

class PhoneNumbersTest extends BaseTest
{
    public function testReadPhoneNumber(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            'GET',
            'phone-numbers/31612345678',
            null,
            null
        );
        $this->client->phoneNumbers->read(31612345678);
    }

    public function testListPhoneNumbers(): void
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with('GET', 'phone-numbers', [], null);
        $this->client->phoneNumbers->getList();
    }

    public function testUpdatePhoneNumber(): void
    {
        $number = new Number();
        $number->tags = ['tag1'];

        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{"tags":["tag1"]}',
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            'PATCH',
            'phone-numbers/31612345678',
            null,
            '{"tags":["tag1"]}'
        );
        $this->client->phoneNumbers->updateBasic($number, '31612345678');
    }

    public function testPurchasePhoneNumber(): void
    {
        $numberPurchaseRequest = new NumberPurchaseRequest();
        $numberPurchaseRequest->number = '31612345678';
        $numberPurchaseRequest->countryCode = 'NL';
        $numberPurchaseRequest->billingIntervalMonths = 1;

        $numberJSON = '{"number":"31612345678","countryCode":"NL","billingIntervalMonths":1}';

        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([
            201,
            '',
            "[$numberJSON]",
        ]);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            'POST',
            'phone-numbers',
            null,
            $numberJSON
        );
        $this->client->phoneNumbers->create($numberPurchaseRequest);
    }

    public function testCancelPhoneNumber(): void
    {
        $this->mockClient->expects(self::atLeastOnce())->method('performHttpRequest')->willReturn([204, '', '']);
        $this->mockClient->expects(self::once())->method('performHttpRequest')->with(
            'DELETE',
            'phone-numbers/31612345678',
            null,
            null
        );
        $this->client->phoneNumbers->delete('31612345678');
    }
}
