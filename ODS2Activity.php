<?php

class ODS2Activity {

	/**
	 *
	 * @var string
	 */
	public $Code;

	/**
	 *
	 * @var int
	 */
	public $CcConfiguration = null;

	/**
	 *
	 * @var boolean
	 */
	public $IdentifyByExternalId = false;

	/**
	 *
	 * @var string
	 */
	public $Param = null;

	/**
	 *
	 * @var string
	 */
	public $Value = null;

	/**
	 *
	 * @var ODS2ActivityData[]
	 */
	public $Data = null;

	/**
	 *

	 * @var ODS2GiodoStatement[]
	 */
	public $GiodoStatements = array();

}
