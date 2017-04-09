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
}
