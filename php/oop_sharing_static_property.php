<?php
/**
 * Test script OOP sharing static property
 *
 * @use `php oop_sharing_static_property.php`
 *
 * @author demmonico@gmail.com
 */

class A
{
    protected static $test;

    public static function getStaticTest()
    {
        return static::$test;
    }

    public static function getSelfTest()
    {
        return self::$test;
    }
}

class B extends A
{
    public function __construct()
    {
        if (is_null(static::$test)) {
            static::$test = get_called_class();
        }
    }
}

class C extends A
{
    public function __construct()
    {
        if (is_null(static::$test)) {
            static::$test = get_called_class();
        }
    }
}



// all return null
var_dump(B::getStaticTest());
var_dump(B::getSelfTest());
var_dump(C::getStaticTest());
var_dump(C::getSelfTest());


$b = new B;
// all return B
var_dump(B::getStaticTest());
var_dump(B::getSelfTest());
var_dump(C::getStaticTest());
var_dump(C::getSelfTest());
var_dump($b::getStaticTest());
var_dump($b::getSelfTest());


$c = new C;
// all return B again
var_dump(B::getStaticTest());
var_dump(B::getSelfTest());
var_dump(C::getStaticTest());
var_dump(C::getSelfTest());
var_dump($b::getStaticTest());
var_dump($b::getSelfTest());
var_dump($c::getStaticTest());
var_dump($c::getSelfTest());
