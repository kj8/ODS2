<?php

// example: 
// $ods = new ODS2();
// $odsData = array(
// 	'firstname' => $_POST['firstname'],
// 	'lastname' => $_POST['lastname'],
// 	'email' => $_POST['email'],
// 	'zgoda_info_handlowe' => $_POST['zgoda_info_handlowe'],
// );
// $ods->setActivity('test_drive', $odsData);

return array(
	'test_drive' => array(// = formName
		'save_to_ods_flag' => true, // true/false
		//
		'WSDL_ADDRESS' => 'http://ods.xxxxxxxxxxx.pl/wsdl', // dev
//		'WSDL_ADDRESS' => 'http://esb.xxxxxxxxxxx.pl/wsdl', // prod
		'APP_ID' => 'xxxxxxxxxxx',
		'APP_KEY' => 'xxxxxxxxxxx',
		'activity_code' => 'xxxxxxxxxxx',
		//
		'activity_datas_map' => array(
			// lewa-ods => prawa-nazwa pola formularza
			'name' => 'name',
			'email' => 'email',
			'phoneNo' => 'phone',
			'source' => 'source',
		),
		'giodo_map' => array(
			// lewa-ods => prawa-nazwa pola formularza
			'giodo-test-drive-2' => 'giodo-test-drive-2', // Administratorem Państwa danych osobowych podanych w powyższym formularzu jest ...
			'giodo-marketing-1' => 'checkbox1', // Wyrażam zgodę na przetwarzanie moich danych osobowych przez ...
			'giodo-email' => 'checkbox2', // Wyrażam zgodę na otrzymywanie informacji handlowych od ...
		),
	),
);
