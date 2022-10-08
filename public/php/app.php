<?php

namespace A;

include __DIR__ . '/autoload.php';


$person2 = new \A\B\Person;
$person = new B\Person;

$person->setAge(20);

$person->name = 'Ibrahim';
$person2->name = 'Mohammed';

$person::$country = '   Palestine';
$person2::$country = 'Jordan';

var_dump($person, $person2);

echo B\Person::$country;
echo $person::MALE;
