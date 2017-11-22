<?php
class ContactTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    public function testCreateContact()
    {
        $Contact             = new \MessageBird\Objects\Contact();
        $Contact->firstName  = "John";
        $Contact->lastName   = "Doe";
        $Contact->msisdn     = "31612345678";
        $Contact->custom1 = "Customfield1";
        $Contact->custom2 = "Customfield2";
        $Contact->custom3 = "Customfield3";
        $Contact->custom4 = "Customfield4";


        $this->mockClient->expects($this->once())->method('performHttpRequest')->willReturn(array(200, '', '{
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
        }'));
        $this->client->contacts->create($Contact);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testListContacts()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'contacts', array ('offset' => 100, 'limit' => 30), null);
        $this->client->contacts->getList(array ('offset' => 100, 'limit' => 30));
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testViewContact()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'contacts/contact_id', null, null);
        $this->client->contacts->read("contact_id");
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
     */
    public function testDeleteContact()
    {
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("DELETE", 'contacts/contact_id', null, null);
        $this->client->contacts->delete("contact_id");
    }

    public function testContactGetGroups()
    {
        $this->mockClient->method('performHttpRequest')
            ->with(
                $this->equalTo(MessageBird\Common\HttpClient::REQUEST_GET), $this->equalTo('contacts/contact_id/groups'), $this->anything(), $this->anything()
            )
            ->willReturn(array(
                200,
                '',
                '{"offset":0,"limit":20,"count":1,"totalCount":1,"links":{"first":"","previous":null,"next":null,"last":""},"items":[{"id":"contact_id","href":"","name":"GroupName","contacts":{"totalCount":1,"href":""},"createdDatetime":"","updatedDatetime":""}]}'
            ));

        $ResultingGroupList = $this->client->contacts->getGroups("contact_id");

        $GroupList = new \MessageBird\Objects\BaseList();
        $GroupList->limit = 20;
        $GroupList->offset = 0;
        $GroupList->count = 1;
        $GroupList->totalCount = 1;
        $GroupList->links = (object) array(
            'first' => '',
            'previous' => null,
            'next' => null,
            'last' => ''
        );
        $GroupList->items = array(
            (object) array(
                'id' => 'contact_id',
                'href' => '',
                'name' => 'GroupName',
                'contacts' => (object) array(
                    'totalCount' => 1,
                    'href' => ''
                ),
                'createdDatetime' => '',
                'updatedDatetime' => ''
            )
        );

        $this->assertEquals($GroupList, $ResultingGroupList);
    }

    public function testContactGetMessages()
    {
        $this->mockClient->method('performHttpRequest')
            ->with(
                $this->equalTo(MessageBird\Common\HttpClient::REQUEST_GET), $this->equalTo('contacts/contact_id/messages'), $this->anything(), $this->anything()
            )
            ->willReturn(array(
                200,
                '',
                '{"offset":0,"limit":20,"count":1,"totalCount":1,"links":{"first":"","previous":null,"next":null,"last":""},"items":[{"id":"contact_id","href":"","direction":"mt","type":"sms","originator":"MsgBird","body":"MessageBody","reference":null,"validity":null,"gateway":0,"typeDetails":{},"datacoding":"plain","mclass":1,"scheduledDatetime":null,"createdDatetime":"","recipients":{"totalCount":1,"totalSentCount":1,"totalDeliveredCount":1,"totalDeliveryFailedCount":0,"items":[{"recipient":12345678912,"status":"delivered","statusDatetime":""}]}}]}'
            ));

        $Messages = $this->client->contacts->getMessages("contact_id");
        foreach($Messages->items as $Message) {
            $this->assertInstanceOf('\MessageBird\Objects\Message', $Message);
        }
    }
}
