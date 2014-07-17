<?php

class ODS2 {

	protected $config;
	protected $logger;

	public function __construct(ODS2ConfigInterface $config, ODS2LoggerInterface $logger) {
		$this->config = $config;
		$this->logger = $logger;
	}

	private function _setActivity($configFormName, array $formData) {

		$cfg = $this->config->get('ODS2');
		$configForm = $cfg[$configFormName];

		$client = new SoapClient($configForm['WSDL_ADDRESS'], array(
			'cache_wsdl' => WSDL_CACHE_BOTH,
			'soap_version' => SOAP_1_1,
			'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
		));

		$now = new DateTime('now');

		$app = new ODS2App();
		$app->Id = $configForm['APP_ID'];
		$app->Ip = $_SERVER['HTTP_HOST'];
		$app->Key = $configForm['APP_KEY'];
		$app->UserAgent = $_SERVER['HTTP_USER_AGENT'];
		$app->InvokeTime = $now->format('c');

		$activity = new ODS2Activity();
		$activity->Code = $configForm['activity_code'];
		$activity->Data = array();

		$ODSData = array();

		if (isset($configForm['giodo_map']) && is_array($configForm['giodo_map'])) {
			foreach ($configForm['giodo_map'] as $key => $value) {
				$gs = new ODS2GiodoStatement();
				$gs->Code = $key;
				$gs->Accept = ($formData[$value]) ? true : false;
				$activity->GiodoStatements[] = $gs;

				$ODSData[$key] = ($formData[$value]) ? true : false;
			}
		}

		if (isset($configForm['activity_datas_map']) && is_array($configForm['activity_datas_map'])) {
			foreach ($configForm['activity_datas_map'] as $key => $value) {
				$activityData = new ODS2ActivityData();
				$activityData->Name = $key;
				$activityData->Value = $formData[$value];
				$activity->Data[] = $activityData;

				$ODSData[$key] = $formData[$value];
			}
		}

		$setActivity = new ODS2SetActivity();
		$setActivity->App = $app;
		$setActivity->Activities = array();
		$setActivity->Activities[] = $activity;

		$result = false;
		$logUniqueID = time() . md5(uniqid(TRUE) . time() . serialize($formData));

		$this->logger->log('[' . $configFormName . '][' . $configForm['activity_code'] . '][' . $logUniqueID . '] Form data serialized: ' . serialize($formData));
		$this->logger->log('[' . $configFormName . '][' . $configForm['activity_code'] . '][' . $logUniqueID . '] ODS data serialized: ' . serialize($ODSData));

		try {
			$clientResponse = $client->SetActivity($setActivity);

			$this->logger->log('[' . $configFormName . '][' . $configForm['activity_code'] . '][' . $logUniqueID . '] ODS response serialized: ' . serialize($clientResponse));

			if (isset($clientResponse->ResponseStatus->Status) && $clientResponse->ResponseStatus->Status == 1) {

				$result = array(
					'SessionId' => isset($clientResponse->ResponseStatus->SessionId) ? $clientResponse->ResponseStatus->SessionId : '',
					'CustomerActivityIds' => isset($clientResponse->CustomerActivityIds) ? $clientResponse->CustomerActivityIds : array(),
				);
			}
		} catch (Exception $e) {
			$this->logger->log('[' . $configFormName . '][' . $configForm['activity_code'] . '][' . $logUniqueID . '] ODS error response serialized: ' . serialize($e->getMessage()));
		}

		return $result;
	}

	public function setActivity($configFormName, array $formData) {

		$cfg = $this->config->get('ODS2');
		$configForm = $cfg[$configFormName];

		if (!$configForm['save_to_ods_flag']) { // don't save to ods
			return true;
		}

		$result = $this->_setActivity($configFormName, $formData);

		return $result;
	}

}

//ODS response: stdClass Object
//(
//    [ResponseStatus] => stdClass Object
//        (
//            [Status] => 1
//            [Created] => 2014-05-12T00:00:00+02:00
//            [SessionId] => 43cb948ec7b5968b1a1ce4a00cfe806b063f1ca95b9ee1cb7063d0473d68a7af
//            [Brands] => Array
//                (
//                    [0] => stdClass Object
//                        (
//                            [Name] => Abc
//                            [Code] => C
//                            [Description] => 
//                        )
//
//                )
//
//        )
//
//    [CustomerActivityIds] => Array
//        (
//            [0] => 5027228
//        )
//
//)