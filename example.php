<?php

require_once 'ODS2Autoloader.php';
ODS2Autoloader::register();

$UTMTags = UTMTags::getUTMString(true);

$ods = new ODS2($configInstance, $loggerInstance);
$odsData = array(
	'name' => @$_POST['name'],
	'email' => @$_POST['email'],
	'phone' => @$_POST['phone'],
	'giodo-test-drive-2' => 1,
	'checkbox1' => @$_POST['checkbox1'],
	'checkbox2' => @$_POST['checkbox2'],
	'source' => $UTMTags,
);

$activityCode = 'test_drive';

$ODSResult = $ods->setActivity($activityCode, $odsData);

if ($ODSResult && is_array($ODSResult)) {
	$ODSSessionId = $ODSResult['SessionId'];
	$ODSCustomerActivityId = reset($ODSResult['CustomerActivityIds']);
}
