<?php

namespace Tests\Integration\PartnerAccount;

use MessageBird\Objects\PartnerAccount\Account;
use Tests\Integration\BaseTest;

class AccountTest extends BaseTest
{
    public function testCreateSubAccount(): void
    {
        $account = new Account();
        $account->name = 'MessageBird';

        $this->mockClient
            ->expects($this->atLeastOnce())
            ->method('performHttpRequest')
            ->willReturn([
                200,
                '',
                '{
                  "id": 6249799,
                  "name": "Partner Account Sub 1",
                  "accessKeys": [
                    {
                      "id": "6912036c-dd42-489b-8588-8c430aec37ef",
                      "key": "Hb85uQhmgvXXlHK9h3SHaAC4V",
                      "mode": "live"
                    },
                    {
                      "id": "cc620896-33fb-415c-9af1-909123937321",
                      "key": "idG2gFSMayEiFRftcStmBxc71",
                      "mode": "test"
                    }
                  ],
                  "signingKey": "7qxJg4lsDKLAEBXAdxyarcwwvDn7YB00"
                }',
            ]);
        $this->mockClient
            ->expects($this->once())
            ->method('performHttpRequest')
            ->with(
                'POST',
                'child-accounts',
                null,
                '{"name":"MessageBird"}'
            );

        $response = $this->client->partnerAccounts->create($account);

        self::assertNotEmpty($response->id);
        self::assertNotEmpty($response->name);
        self::assertNotEmpty($response->accessKeys);
        self::assertNotEmpty($response->signingKey);
    }

    public function testListSubAccount(): void
    {
        $this->mockClient
            ->expects($this->atLeastOnce())
            ->method('performHttpRequest')
            ->willReturn([
                200,
                '',
                '[
                  {
                    "id": 6249623,
                    "name": "Partner Account 1 Sub 1",
                    "email": "subaccount1@messagebird.com"
                  },
                  {
                    "id": 6249654,
                    "name": "Partner Account 1 Sub 2",
                    "email": "subaccount2@messagebird.com"
                  },
                  {
                    "id": 62496654,
                    "name": "Partner Account 1 Sub 3",
                    "email": "subaccount3@messagebird.com"
                  }
                ]',
            ]);
        $this->mockClient
            ->expects($this->once())
            ->method('performHttpRequest')
            ->with(
                'GET',
                'child-accounts'
            );

        $response = $this->client->partnerAccounts->getList();
        self::assertCount(3, $response);
        foreach ($response as $item) {
            self::assertNotEmpty($item->id);
            self::assertNotEmpty($item->name);
            self::assertNotEmpty($item->email);
        }
    }

    public function testReadSubAccount(): void
    {
        $this->mockClient
            ->expects($this->atLeastOnce())
            ->method('performHttpRequest')
            ->willReturn([
                200,
                '',
                '{
                  "id": 6249609,
                  "name": "Partner Account 1 Sub 1",
                  "email": "subaccount1@messagebird.com"
                }',
            ]);
        $this->mockClient
            ->expects($this->once())
            ->method('performHttpRequest')
            ->with(
                'GET',
                'child-accounts/1'
            );

        $response = $this->client->partnerAccounts->read(1);

        self::assertNotEmpty($response->id);
        self::assertNotEmpty($response->name);
        self::assertNotEmpty($response->email);
    }

    public function testDeleteSubAccount(): void
    {
        $this->mockClient
            ->expects($this->once())
            ->method('performHttpRequest')
            ->with(
                'DELETE',
                'child-accounts/1'
            )
            ->willReturn([
                204,
                '',
                '',
            ]);

        $response = $this->client->partnerAccounts->delete(1);

        $this->assertTrue($response);
    }

    public function testEditSubAccount(): void
    {
        $account = new Account();
        $account->name = 'MessageBird';

        $this->mockClient
            ->expects($this->once())
            ->method('performHttpRequest')
            ->with(
                'PATCH',
                'child-accounts/1',
                null,
                '{"name":"MessageBird"}'
            )
            ->willReturn([
                204,
                '',
                '{
                  "id": 6249799,
                  "name": "Partner Account Sub 1"
                }',
            ]);

        $this->client->partnerAccounts->update($account, 1);
    }
}
