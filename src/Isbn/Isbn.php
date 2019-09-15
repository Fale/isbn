<?php
/**
 * ISBN.
 *
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @author Daniel Mejta <daniel@mejta.net>
 *
 * @version 2.0.0
 */

namespace Isbn;

/**
 * ISBN.
 */
class Isbn
{
    /**
     * Check Instance.
     *
     * @var Check
     */
    public $check;

    /**
     * Check Digit Instance.
     *
     * @var CheckDigit
     */
    public $checkDigit;

    /**
     * Hyphens Instance.
     *
     * @var Hyphens
     */
    public $hyphens;

    /**
     * Translate Instance.
     *
     * @var Translate
     */
    public $translate;

    /**
     * Validation Instance.
     *
     * @var Validation
     */
    public $validation;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->hyphens    = new Hyphens();
        $this->check      = new Check($this->hyphens);
        $this->checkDigit = new CheckDigit($this->hyphens);
        $this->translate  = new Translate($this->checkDigit);
        $this->validation = new Validation($this->check, $this->hyphens);
    }
}
