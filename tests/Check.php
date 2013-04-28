<?php

class Check extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $this->assertTrue(Isbn\Check::isbn10('8881837188'));
        $this->assertFalse(Isbn\Check::isbn10('8881837187'));
    }

    public function testIsbn13()
    {
        $this->assertTrue(Isbn\Check::isbn13('9788889527191'));
        $this->assertFalse(Isbn\Check::isbn13('9788889527190'));
    }

    public function testIsbn()
    {
        $this->assertTrue(Isbn\Check::isbn('8881837188'));
        $this->assertFalse(Isbn\Check::isbn('8881837187'));
        $this->assertTrue(Isbn\Check::isbn('9788889527191'));
        $this->assertFalse(Isbn\Check::isbn('9788889527190'));
    }

}
