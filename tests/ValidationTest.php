<?php

class ValidationTest extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $this->assertTrue(Isbn\Validation::isbn10('8881837188'));
        $this->assertFalse(Isbn\Validation::isbn10('8881837187'));
    }

    public function testIsbn13()
    {
        $this->assertTrue(Isbn\Validation::isbn13('9788889527191'));
        $this->assertFalse(Isbn\Validation::isbn13('9788889527190'));
    }

    public function testIsbn()
    {
        $this->assertTrue(Isbn\Validation::isbn('8881837188'));
        $this->assertFalse(Isbn\Validation::isbn('8881837187'));
        $this->assertTrue(Isbn\Validation::isbn('9788889527191'));
        $this->assertFalse(Isbn\Validation::isbn('9788889527190'));
        $this->assertFalse(Isbn\Validation::isbn('97888895271910'));
        $this->assertFalse(Isbn\Validation::isbn('biopsychology'));
    }

}
