<?php

namespace Isbn;

class Check {
    
    private $hyphens;
    
    public function __construct(Hyphens $hyphens) {
        $this->hyphens = $hyphens;
    }

    public function identify($isbn)
    {
        if ($this->is10($isbn))
            return 10;
        if ($this->is13($isbn))
            return 13;
        return false;
    }

    public function is10($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) == 10)
            return true;
        return false;
    }

    public function is13($isbn)
    {
        $isbn = $this->hyphens->removeHyphens($isbn);
        if (strlen($isbn) == 13)
            return true;
        return false;
    }
}
