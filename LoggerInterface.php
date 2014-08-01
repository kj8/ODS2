<?php

interface LoggerInterface {

	public function log($prefix, $data, $logType = 'info');
}
