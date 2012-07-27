<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
/**
 * Timezone Validation
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Timezone_Validation extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
    /* Public Methods
	-------------------------------*/
	public function isAbbr($value) {
		return preg_match('/^[A-Z]{1,5}$/', $value); 
	}
	
	public function isLocation($value) {
		return in_array($value, DateTimeZone::listIdentifiers());
	}
	
	public function isUtc($value) {
		return preg_match('/^(GMT|UTC){0,1}(\-|\+)[0-9]{1,2}(\:{0,1}[0-9]{2}){0,1}$/', $value); 
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}