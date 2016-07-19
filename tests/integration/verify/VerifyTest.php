<?php
class VerifyTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testGenerateOtp()
    {
        $Verify             = new \MessageBird\Objects\Verify();
        $Verify->recipient  = 31612345678;
        $Verify->reference  = "Yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'verify', null, '{"recipient":31612345678,"reference":"Yoloswag3000"}');

        $this->client->verify->create($Verify);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testVerifyOtp()
    {
        $Verify            = new \MessageBird\Objects\Verify();
        $Verify->recipient = 31612345678;
        $Verify->reference = 'Yoloswag3000';

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'verify/onofao3f82f7u2fb2uf', array('token' => '123456'));

        $this->client->verify->verify('onofao3f82f7u2fb2uf', 123456);
    }
}
