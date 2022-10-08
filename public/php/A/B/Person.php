<?php

namespace A;
use Info;

const LARAVEL = 'Laravel A ';

function hello() {
    echo 'Hello A ';
}

class Person {
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


