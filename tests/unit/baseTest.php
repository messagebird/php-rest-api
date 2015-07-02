<?php
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testClientConstructor()
    {
        $MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY');
        
    }
}
