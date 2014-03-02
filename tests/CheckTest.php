<?php

class CheckTest extends PHPUnit_Framework_TestCase
{

    public function testIs10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->check->is10('8881837188'));
        $this->assertFalse($isbn->check->is10('888183718'));
    }

    public function testIs13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->check->is13('9788889527191'));
        $this->assertFalse($isbn->check->is13('978888952719'));
    }

    public function testIdentify()
    {
        $isbn = new Isbn\Isbn();
        $this->assertEquals('10', $isbn->check->identify('8881837188'));
        $this->assertFalse($isbn->check->identify('888183718'));
        $this->assertEquals('13', $isbn->check->identify('9788889527191'));
        $this->assertFalse($isbn->check->identify('978888952719'));
    }
}
