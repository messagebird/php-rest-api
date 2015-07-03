<?php
class OtpTest extends BaseTest
{
    public function setUp()
    {
        parent::setup();
        $this->client = new \MessageBird\Client('YOUR_ACCESS_KEY', $this->mockClient);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testGenerateOtp()
    {
        $Otp             = new \MessageBird\Objects\Otp();
        $Otp->originator = 'MessageBird';
        $Otp->recipient  = 31612345678;
        $Otp->reference  = "Yoloswag3000";

        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("POST", 'otp/generate', null, '{"token":null,"recipient":31612345678,"reference":"Yoloswag3000","originator":"MessageBird","type":"sms","template":null,"language":"en-gb","voice":"female"}');

        $this->client->otp->generate($Otp);
    }

    /**
     * @expectedException     MessageBird\Exceptions\ServerException
       */
    public function testVerifyOtp()
    {
        $Otp            = new \MessageBird\Objects\Otp();
        $Otp->reference = 'Yoloswag3000';
        $Otp->recipient = 31612345678;
        $this->mockClient->expects($this->once())->method('performHttpRequest')->with("GET", 'otp/verify', json_decode('{"token":null,"recipient":31612345678,"reference":"Yoloswag3000","originator":null,"type":"sms","template":null,"language":"en-gb","voice":"female"}', true), null);

        $this->client->otp->verify($Otp);
    }
}
