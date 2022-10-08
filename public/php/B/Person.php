<?php

namespace A\B;
use A\B\Person as PersonA;
use Info;

const LARAVEL = 'Laravel B ';

function hello() {
    echo 'Hello B ';
}

class Person extends PersonA {

    use Info;

    const MALE = 'm';
    const FEMALE = 'F';

    public static $country;

    public $name;
    protected $gender;
    private $age;

    public function __construct() {
        echo __CLASS__;
    }

    public static function setCountry($country) {
        self::$country = $country;
    }
}


