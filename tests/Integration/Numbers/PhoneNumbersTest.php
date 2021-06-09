<?php

namespace Tests\Integration\Numbers;

use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\Number;
use MessageBird\Objects\NumberPurchaseRequest;
use Tests\Integration\BaseTest;

class PhoneNumbersTest extends BaseTest
{
    public function testReadPhoneNumber()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            'GET',
            'phone-numbers/31612345678',
            null,
            null
        );
        $this->client->phoneNumbers->read(31612345678);
    }

    public function testListPhoneNumbers()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET', 'phone-numbers', [], null);
        $this->client->phoneNumbers->getList();
    }

    public function testUpdatePhoneNumber()
    {
        $number = new Number();
        $number->tags = ['tag1'];

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{"tags":["tag1"]}',
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            'PATCH',
            'phone-numbers/31612345678',
            null,
            '{"tags":["tag1"]}'
        );
        $this->client->phoneNumbers->update($number, '31612345678');
    }

    public function testPurchasePhoneNumber()
    {
        $numberPurchaseRequest = new NumberPurchaseRequest();
        $numberPurchaseRequest->number = '31612345678';
        $numberPurchaseRequest->countryCode = 'NL';
        $numberPurchaseRequest->billingIntervalMonths = 1;

        $numberJSON = '{"number":"31612345678","countryCode":"NL","billingIntervalMonths":1}';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([
            201,
            '',
            "[$numberJSON]",
        ]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            'POST',
            'phone-numbers',
            null,
            $numberJSON
        );
        $this->client->phoneNumbers->create($numberPurchaseRequest);
    }

    public function testCancelPhoneNumber()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([204, '', '']);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            'DELETE',
            'phone-numbers/31612345678',
            null,
            null
        );
        $this->client->phoneNumbers->delete('31612345678');
    }
}
