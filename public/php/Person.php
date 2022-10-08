<?php

class Person {
    protected static $container = 'person';

    public static function __callStatic($name, $arguments)
    {
        $sc = new ServiceContainer();
        $person = $sc->make(self::$container);
        $person->$name(...$arguments);
    }

}





