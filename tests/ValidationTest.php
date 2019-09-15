<?php
/**
 * Validation Test.
 *
 * @author Fabio Alessandro Locati <fabiolocati@gmail.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */
class ValidationTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test ISBN-10 Validation.
     */
    public function testIsbn10()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->validation->isbn10('8881837188'));
        $this->assertTrue($isbn->validation->isbn10('888 18 3 7 1-88'));
        $this->assertTrue($isbn->validation->isbn10('2-7605-1028-X'));
        $this->assertFalse($isbn->validation->isbn10('8881837187'));
        $this->assertFalse($isbn->validation->isbn10('888183718A'));
        $this->assertFalse($isbn->validation->isbn10('stringof10'));
    }

    /**
     * Test ISBN-13 Validation.
     */
    public function testIsbn13()
    {
        $isbn = new Isbn\Isbn();
        $this->assertTrue($isbn->validation->isbn13('9788889527191'));
        $this->assertTrue($isbn->validation->isbn13('978 888-9 527 191'));
        $this->assertFalse($isbn->validation->isbn13('9788889527190'));
    }

    /**
     * Test ISBN Validation.
     */
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
