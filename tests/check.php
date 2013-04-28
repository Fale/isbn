<?php

class Check extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $this->assertTrue(Isbn\Check::isbn10('8881837188'));
    }

    public function testIsbn13()
    {
        $this->assertTrue(Isbn\Check::isbn13('9788889527191'));
    }
}
