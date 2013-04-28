<?php

namespace Isbn;

class Translate {

    public static function to10($isbn)
    {
        $isbn = substr($isbn, 3, -1);
        return $isbn . CheckDigit::make($isbn);
    }

    public static function to13($isbn)
    {
        $isbn = substr($isbn, 0, -1);
        $isbn = "978" . $isbn;
        return $isbn . CheckDigit::make($isbn);
    }

}
