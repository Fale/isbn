<?php

class TranslateTest extends PHPUnit_Framework_TestCase
{

    public function testTo13()
    {
        $this->assertEquals('9789880038273', Isbn\Translate::to13('9880038274'));
    }

    public function testTo10()
    {
        $this->assertEquals('9880038274', Isbn\Translate::to10('9789880038273'));
    }

}
