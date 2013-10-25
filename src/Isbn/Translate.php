<?php

namespace Isbn;

class Translate {

    public static function to10($isbn)
    {
        if (strlen($isbn) > 13)
            $isbn = substr($isbn, 4, -1);
        else
            $isbn = substr($isbn, 3, -1);
        return $isbn . CheckDigit::make($isbn);
    }

    public static function to13($isbn)
    {
        $isbn = substr($isbn, 0, -1);
        if (strlen($isbn) > 9)
            $isbn = "978-" . $isbn;
        else
            $isbn = "978" . $isbn;
        return $isbn . CheckDigit::make($isbn);
    }

}
