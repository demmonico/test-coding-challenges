<?php
/**
 * Test script OOP late static bindings
 *
 * @use `php oop_class_late_static_bindings.php`
 *
 * @author demmonico@gmail.com
 */

class A
{
    public static function getInstance()
    {
        return new static;
    }

    public function f1()
    {
        echo get_called_class().PHP_EOL;
        return $this;
    }

    public function f2()
    {
        echo __CLASS__.PHP_EOL;
        return $this;
    }

    public function f3()
    {
        echo get_class().PHP_EOL;
        return $this;
    }

}

class B extends A {}



$a = A::getInstance();
$b = B::getInstance();

if($a instanceof A){
    echo '1';
}

if($b instanceof B){
    echo '2';
}

if(get_class($a) == get_class($b)){
    echo '3';
}

$b->f1()->f2()->f3();


/**
 * returns
 * 12B A A
 */
