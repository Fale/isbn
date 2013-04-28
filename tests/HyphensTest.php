<?php

class HyphensTest extends PHPUnit_Framework_TestCase
{

    public function testRemoveHyphens()
    {
        // ISBN10
        $this->assertEquals('9992158107', Isbn\Hyphens::removeHyphens('99921-58-10-7'));
        $this->assertEquals('9992158107', Isbn\Hyphens::removeHyphens('99921 58 10 7'));
        $this->assertEquals('9971502100', Isbn\Hyphens::removeHyphens('9971-5-0210-0'));
        $this->assertEquals('9971502100', Isbn\Hyphens::removeHyphens('9971 5 0210 0'));
        $this->assertEquals('080442957X', Isbn\Hyphens::removeHyphens('0-8044-2957-X'));
        $this->assertEquals('080442957X', Isbn\Hyphens::removeHyphens('0 8044 2957 X'));
        $this->assertEquals('8535902775', Isbn\Hyphens::removeHyphens('85-359-0277-5'));
        $this->assertEquals('8535902775', Isbn\Hyphens::removeHyphens('85 359 0277 5'));
        $this->assertEquals('0943396042', Isbn\Hyphens::removeHyphens('0-943396-04-2'));
        $this->assertEquals('0943396042', Isbn\Hyphens::removeHyphens('0 943396 04 2'));

        // ISBN13
        $this->assertEquals('9786001191251', Isbn\Hyphens::removeHyphens('978-600-119-125-1'));
        $this->assertEquals('9786001191251', Isbn\Hyphens::removeHyphens('978 600 119 125 1'));
        $this->assertEquals('9786017151133', Isbn\Hyphens::removeHyphens('978-601-7151-13-3'));
        $this->assertEquals('9786017151133', Isbn\Hyphens::removeHyphens('978 601 7151 13 3'));
        $this->assertEquals('9786028328227', Isbn\Hyphens::removeHyphens('978-602-8328-22-7'));
        $this->assertEquals('9786028328227', Isbn\Hyphens::removeHyphens('978 602 8328 22 7'));
        $this->assertEquals('9789880038273', Isbn\Hyphens::removeHyphens('978-988-00-3827-3'));
        $this->assertEquals('9789880038273', Isbn\Hyphens::removeHyphens('978 988 00 3827 3'));
        $this->assertEquals('9791090636071', Isbn\Hyphens::removeHyphens('979-10-90636-07-1'));
        $this->assertEquals('9791090636071', Isbn\Hyphens::removeHyphens('979 10 90636 07 1'));
    }

    public function testAddHyphens()
    {
        $hyphens = new Isbn\Hyphens('9791090636071');
        $this->assertEquals('979-10-90636-07-1', $hyphens->addHyphens());
        unset ($hyphens);

        $hyphens = new Isbn\Hyphens('9992158107');
        $this->assertEquals('99921-58-10-7', $hyphens->addHyphens());
        unset ($hyphens);
        
        $hyphens = new Isbn\Hyphens('9789880038273');
        $this->assertEquals('978-988-00-3827-3', $hyphens->addHyphens());
        unset ($hyphens);

        $hyphens = new Isbn\Hyphens('080442957X');
        $this->assertEquals('0-8044-2957-X', $hyphens->addHyphens());
        unset ($hyphens);
    }
}
