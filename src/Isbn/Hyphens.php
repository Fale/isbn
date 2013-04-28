<?php

namespace Isbn;

class Hyphens
{

    public static function removeHyphens($isbn)
    {
        $isbn = str_replace(" ","",$isbn);
        $isbn = str_replace("-","",$isbn);
        return $isbn;
    }

}
