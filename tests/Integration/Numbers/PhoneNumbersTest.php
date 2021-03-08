<?php

namespace Tests\Integration\Numbers;

use Tests\Integration\BaseTest;

class PhoneNumbersTest extends BaseTest
{
    public function testReadPhoneNumber()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET', 'phone-numbers/31612345678', null, null);
        $this->client->phoneNumbers->read(31612345678);
    }

    public function testListPhoneNumbers()
    {
        $this->expectException(\MessageBird\Exceptions\ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('GET', 'phone-numbers',  [], null);
        $this->client->phoneNumbers->getList();
    }

    public function testUpdatePhoneNumber()
    {
        $Number = new \MessageBird\Objects\Number();
        $Number->tags = ['tag1'];

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([200, '', '{"tags":["tag1"]}']);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('PATCH', 'phone-numbers/31612345678', null, '{"tags":["tag1"]}');
        $this->client->phoneNumbers->update($Number, '31612345678');
    }

    public function testPurchasePhoneNumber()
    {
        $NumberPurchaseRequest                        = new \MessageBird\Objects\NumberPurchaseRequest();
        $NumberPurchaseRequest->number                = '31612345678';
        $NumberPurchaseRequest->countryCode           = 'NL';
        $NumberPurchaseRequest->billingIntervalMonths = 1;

        $NumberJSON = '{"number":"31612345678","countryCode":"NL","billingIntervalMonths":1}';

        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([201, '', "[$NumberJSON]"]);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('POST', 'phone-numbers', null, $NumberJSON);
        $this->client->phoneNumbers->create($NumberPurchaseRequest);
    }

    public function testCancelPhoneNumber()
    {
        $this->mockClient->expects($this->atLeastOnce())->method('performHttpRequest')->willReturn([204, '', '']);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with('DELETE', 'phone-numbers/31612345678', null, null);
        $this->client->phoneNumbers->delete('31612345678');
    }
}
