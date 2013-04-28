# ISBN PHP library #
This library is develop to give all ISBN related tools needed by PHP developers.

## ISBN Validation ##
This class allows you to validate ISBN codes.
Examples:

    Isbn\Validation::isbn('8881837188'); // Will return true
    Isbn\Validation::isbn('8881837187'); // Will return false
    Isbn\Validation::isbn('9788889527191'); // Will return true
    Isbn\Validation::isbn('9788889527190'); // Will return false
    Isbn\Validation::isbn10('8881837188'); // Will return true
    Isbn\Validation::isbn10('8881837187'); // Will return false
    Isbn\Validation::isbn13('9788889527191'); // Will return true
    Isbn\Validation::isbn13('9788889527190'); // Will return false

