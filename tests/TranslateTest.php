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

    public function testTo13WithHyphens()
    {
        $this->assertEquals('978-7-111-19626-6', Isbn\Translate::to13('7-111-19626-0'));
    }

    public function testTo10WithHyphens()
    {
        $this->assertEquals('7-111-19626-0', Isbn\Translate::to10('978-7-111-19626-6'));
    }
}
