<?php

namespace Tests\Integration\Contacts;

use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\BaseList;
use MessageBird\Objects\Contact;
use MessageBird\Objects\Message;
use Tests\Integration\BaseTest;

class ContactTest extends BaseTest
{
    public function testCreateContact()
    {
        $contact = new Contact();
        $contact->firstName = "John";
        $contact->lastName = "Doe";
        $contact->msisdn = "31612345678";
        $contact->custom1 = "Customfield1";
        $contact->custom2 = "Customfield2";
        $contact->custom3 = "Customfield3";
        $contact->custom4 = "Customfield4";


        $this->mockClient->expects($this->once())->method('performHttpRequest')->willReturn([
            200,
            '',
            '{
            "id": "61afc0531573b08ddbe36e1c85602827",
            "href": "https://rest.messagebird.com/contacts/61afc0531573b08ddbe36e1c85602827",
            "msisdn": 31612345678,
            "firstName": "John",
            "lastName": "Doe",
            "customDetails": {
              "custom1": "Customfield1",
              "custom2": "Customfield2",
              "custom3": "Customfield3",
              "custom4": "Customfield4"
            },
            "groups": {
              "totalCount": 0,
              "href": "https://rest.messagebird.com/contacts/61afc0531573b08ddbe36e1c85602827/groups"
            },
            "messages": {
              "totalCount": 0,
              "href": "https://rest.messagebird.com/contacts/61afc0531573b08ddbe36e1c85602827/messages"
            },
            "createdDatetime": "2016-04-29T09:42:26+00:00",
            "updatedDatetime": "2016-04-29T09:42:26+00:00"
        }'
        ]);
        $this->client->contacts->create($contact);
    }

    public function testListContacts()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'contacts',
            ['offset' => 100, 'limit' => 30],
            null
        );
        $this->client->contacts->getList(['offset' => 100, 'limit' => 30]);
    }

    public function testViewContact()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "GET",
            'contacts/contact_id',
            null,
            null
        );
        $this->client->contacts->read("contact_id");
    }

    public function testDeleteContact()
    {
        $this->expectException(ServerException::class);
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with(
            "DELETE",
            'contacts/contact_id',
            null,
            null
        );
        $this->client->contacts->delete("contact_id");
    }

    public function testContactGetGroups()
    {
        $this->mockClient->method('performHttpRequest')
            ->with(
                $this->equalTo(HttpClient::REQUEST_GET),
                $this->equalTo('contacts/contact_id/groups'),
                $this->anything(),
                $this->anything()
            )
            ->willReturn([
                200,
                '',
                '{"offset":0,"limit":20,"count":1,"totalCount":1,"links":{"first":"","previous":null,"next":null,"last":""},"items":[{"id":"contact_id","href":"","name":"GroupName","contacts":{"totalCount":1,"href":""},"createdDatetime":"","updatedDatetime":""}]}'
            ]);

        $resultingGroupList = $this->client->contacts->getGroups("contact_id");

        $groupList = new BaseList();
        $groupList->limit = 20;
        $groupList->offset = 0;
        $groupList->count = 1;
        $groupList->totalCount = 1;
        $groupList->links = (object)[
            'first' => '',
            'previous' => null,
            'next' => null,
            'last' => ''
        ];
        $groupList->items = [
            (object)[
                'id' => 'contact_id',
                'href' => '',
                'name' => 'GroupName',
                'contacts' => (object)[
                    'totalCount' => 1,
                    'href' => ''
                ],
                'createdDatetime' => '',
                'updatedDatetime' => ''
            ]
        ];

        $this->assertEquals($groupList, $resultingGroupList);
    }

    public function testContactGetMessages()
    {
        $this->mockClient->method('performHttpRequest')
            ->with(
                $this->equalTo(HttpClient::REQUEST_GET),
                $this->equalTo('contacts/contact_id/messages'),
                $this->anything(),
                $this->anything()
            )
            ->willReturn([
                200,
                '',
                '{"offset":0,"limit":20,"count":1,"totalCount":1,"links":{"first":"","previous":null,"next":null,"last":""},"items":[{"id":"contact_id","href":"","direction":"mt","type":"sms","originator":"MsgBird","body":"MessageBody","reference":null,"validity":null,"gateway":0,"typeDetails":{},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"createdDatetime":"","recipients":{"totalCount":1,"totalSentCount":1,"totalDeliveredCount":1,"totalDeliveryFailedCount":0,"items":[{"recipient":12345678912,"status":"delivered","statusDatetime":""}]}}]}'
            ]);

        $messages = $this->client->contacts->getMessages("contact_id");

        foreach ($messages->items as $message) {
            $this->assertInstanceOf(Message::class, $message);
        }
    }
}
