<?php

class TranslateTest extends PHPUnit_Framework_TestCase
{

    public function testTo13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('9789880038273', $isbn->translate->to13('9880038274'));
    }

    public function testTo10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('9880038274', $isbn->translate->to10('9789880038273'));
    }

    public function testTo13WithHyphens()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('978-7-111-19626-6', $isbn->translate->to13('7-111-19626-0'));
    }

    public function testTo10WithHyphens()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('7-111-19626-0', $isbn->translate->to10('978-7-111-19626-6'));
    }
}
