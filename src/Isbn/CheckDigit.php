<?php

namespace Isbn;

class CheckDigit {

    private $hyphens;
    
    public function __construct(Hyphens $hyphens) {
        $this->hyphens = $hyphens;
    }

    public function make($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) == 12 OR strlen($isbn) == 13)
            return $this->make13($isbn);
        if (strlen($isbn) == 9 OR strlen($isbn) == 10)
            return $this->make10($isbn);
        return false;
    }

    public function make10($isbn)
    {
        if (strlen($isbn) < 9 OR strlen($isbn) > 10)
            return false;
        $check = 0;
        for ($i = 0; $i < 9; $i++)
            if ($isbn[$i] == "X")
                $check += 10 * intval(10 - $i);
            else
                $check += intval($isbn[$i]) * intval(10 - $i);
        $check = 11 - $check % 11;
        if ($check == 10)
            return 'X';
        elseif ($check == 11)
            return 0;
        else
            return $check;
    }

    public function make13($isbn)
    {
        if (strlen($isbn) < 12 OR strlen($isbn) > 13)
            return false;
        $check = 0;
        for ($i = 0; $i < 12; $i+=2)
            $check += substr($isbn, $i, 1);
        for ($i = 1; $i < 12; $i+=2)
            $check += 3 * substr($isbn, $i, 1);
        $check = 10 - $check % 10;
        if ($check == 10)
            return 0;
        else
            return $check;
    }
}
