<?php

namespace Isbn;

class Translate {
    
    private $checkDigit;
    
    public function __construct(CheckDigit $checkDigit) {
        $this->checkDigit = $checkDigit;
    }

    public function to10($isbn)
    {
        if (strlen($isbn) > 13)
            $isbn = substr($isbn, 4, -1);
        else
            $isbn = substr($isbn, 3, -1);
        return $isbn . $this->checkDigit->make($isbn);
    }

    public function to13($isbn)
    {
        $isbn = substr($isbn, 0, -1);
        if (strlen($isbn) > 9)
            $isbn = "978-" . $isbn;
        else
            $isbn = "978" . $isbn;
        return $isbn . $this->checkDigit->make($isbn);
    }

}
