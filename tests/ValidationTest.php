<?php

class ValidationTest extends PHPUnit_Framework_TestCase
{

    public function testIsbn10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->validation->isbn10('8881837188'));
        $this->assertTrue($isbn->validation->isbn10('888 18 3 7 1-88'));
        $this->assertFalse($isbn->validation->isbn10('8881837187'));
        $this->assertFalse($isbn->validation->isbn10('888183718A'));
        $this->assertFalse($isbn->validation->isbn10('stringof10'));
    }

    public function testIsbn13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->validation->isbn13('9788889527191'));
        $this->assertTrue($isbn->validation->isbn13('978 888-9 527 191'));
        $this->assertFalse($isbn->validation->isbn13('9788889527190'));
    }

    public function testIsbn()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->validation->isbn('8881837188'));
        $this->assertFalse($isbn->validation->isbn('8881837187'));
        $this->assertTrue($isbn->validation->isbn('9788889527191'));
        $this->assertFalse($isbn->validation->isbn('9788889527190'));
        $this->assertFalse($isbn->validation->isbn('97888895271910'));
        $this->assertFalse($isbn->validation->isbn('biopsychology'));
    }

}
