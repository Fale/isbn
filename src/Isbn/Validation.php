<?php

namespace Isbn;

class Validation {
    
    private $check;
    private $hyphens;

    public function __construct(Check $check, Hyphens $hyphens) {
        $this->check = $check;
        $this->hyphens = $hyphens;
    }

    public function isbn($isbn)
    {
        if ($this->check->is13($isbn))
            return $this->isbn13($isbn);
        if ($this->check->is10($isbn))
            return $this->isbn10($isbn);
        return false;
    }

    public function isbn10($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) != 10)
            return false;
        if (!preg_match("/\d{9}[0-9xX]/i",$isbn))
            return false;
        $check = 0;
        for ($i = 0; $i < 10; $i++)
            if ($isbn[$i] == "X")
                $check += 10 * intval(10 - $i);
            else
                $check += intval($isbn[$i]) * intval(10 - $i);
        return $check % 11 == 0;
    }

    public function isbn13($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) != 13)
            return false;
        if (!preg_match("/\d{13}/i",$isbn))
            return false;
        $check = 0;
        for ($i = 0; $i < 13; $i+=2)
            $check += substr($isbn, $i, 1);
        for ($i = 1; $i < 12; $i+=2)
            $check += 3 * substr($isbn, $i, 1);
        return $check % 10 == 0;
    }
}
