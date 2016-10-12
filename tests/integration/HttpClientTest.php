<?php
use MessageBird\Client;
use MessageBird\Common\HttpClient;

class HttpClientTest extends PHPUnit_Framework_TestCase
{
    public function testHttpClient()
    {
        $client = new HttpClient(Client::ENDPOINT);

        $url = $client->getRequestUrl('a', null);
        $this->assertSame(Client::ENDPOINT.'/a', $url);

        $url = $client->getRequestUrl('a', array('b' => 1));
        $this->assertSame(Client::ENDPOINT.'/a?b=1', $url);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Timeout must be an int > 0, got "integer 0".$#
     */
    public function testHttpClientInvalidTimeout()
    {
        new HttpClient(Client::ENDPOINT, 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Connection timeout must be an int >= 0, got "stdClass".$#
     */
    public function testHttpClientInvalidConnectionTimeout()
    {
        new HttpClient(Client::ENDPOINT, 10, new \stdClass());
    }

    /**
     * Test that requests can only be made when there is an Authentication set
     *
     * @test
     * @expectedException \MessageBird\Exceptions\AuthenticateException
     * @expectedExceptionMessageRegExp #Can not perform API Request without Authentication#
     */
    public function testHttpClientWithoutAuthenticationException()
    {
        $client = new HttpClient(Client::ENDPOINT);
        $client->performHttpRequest('foo', 'bar');
    }
}
