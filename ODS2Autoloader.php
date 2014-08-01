<?php

class ODS2Autoloader {

	public static function register($prepend = false) {
		if (version_compare(phpversion(), '5.3.0', '>=')) {
			spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
		} else {
			spl_autoload_register(array(__CLASS__, 'autoload'));
		}
	}

	public static function autoload($className) {
		$className = ltrim($className, '\\');
		$fileName = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

		$fileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $fileName;

		if (is_file($fileName)) {
			require_once $fileName;
		}
	}

}
