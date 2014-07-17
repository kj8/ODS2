<?php

class Autoloader {

    public static function register($prepend = false) {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
    }

    public static function autoload($class) {
        $file = dirname(__FILE__) . '/' . str_replace(array('_', "\0"), array('/', ''), $class) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }

}
