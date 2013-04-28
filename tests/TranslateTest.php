<?php

class TranslateTest extends PHPUnit_Framework_TestCase
{

    public function testTo13()
    {
        $this->assertEquals('9788889527191', Isbn\Translate::to13('8889527191'));
    }

    public function testTo10()
    {
        $this->assertEquals('6028328227', Isbn\Translate::to10('9786028328227'));
    }

}
