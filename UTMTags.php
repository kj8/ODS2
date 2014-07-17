<?php

class UTMTags {

	const SESSION_KEY = '_utm_params_';

	public static function saveToSession() {
		if (empty($_SESSION[self::SESSION_KEY])) {
			$_SESSION[self::SESSION_KEY] = array();
		}

		if (isset($_GET['utm_source'])) {
			$_SESSION[self::SESSION_KEY]['utm_source'] = $_GET['utm_source'];
		}
		if (isset($_GET['utm_medium'])) {
			$_SESSION[self::SESSION_KEY]['utm_medium'] = $_GET['utm_medium'];
		}
		if (isset($_GET['utm_campaign'])) {
			$_SESSION[self::SESSION_KEY]['utm_campaign'] = $_GET['utm_campaign'];
		}
	}

	public static function getFromSession($clearSession = false) {
		if (empty($_SESSION[self::SESSION_KEY])) {
			$_SESSION[self::SESSION_KEY] = array();
		}

		$result = array(
			'utm_source' => isset($_SESSION[self::SESSION_KEY]['utm_source']) ? $_SESSION[self::SESSION_KEY]['utm_source'] : '',
			'utm_medium' => isset($_SESSION[self::SESSION_KEY]['utm_medium']) ? $_SESSION[self::SESSION_KEY]['utm_medium'] : '',
			'utm_campaign' => isset($_SESSION[self::SESSION_KEY]['utm_campaign']) ? $_SESSION[self::SESSION_KEY]['utm_campaign'] : '',
		);

		if ($clearSession) {
			$_SESSION[self::SESSION_KEY] = array();
		}

		return $result;
	}

	public static function getUTMString($clearSession = false) {
		$tags = self::getFromSession($clearSession);
		$string = $tags['utm_source'] . '+' . $tags['utm_medium'] . '+' . $tags['utm_campaign'];
		$string = trim($string, '+');

		return $string;
	}

}
