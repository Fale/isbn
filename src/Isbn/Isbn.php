<?php
namespace Isbn;

class Isbn {
    public $check;
    public $checkDigit;
    public $hyphens;
    public $translate;
    public $validation;
    
    public function __construct() {
        $this->hyphens = new Hyphens();
        $this->check = new Check($this->hyphens);
        $this->checkDigit = new CheckDigit($this->hyphens);
        $this->translate = new Translate($this->checkDigit);
        $this->validation = new Validation($this->check, $this->hyphens);
    }
}
