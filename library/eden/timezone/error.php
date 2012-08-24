<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
/**
 * Timezone Errors
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Timezone_Error extends Eden_Error {
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
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	protected function _isValid($type, $data) {
		$valid = Eden_Timezone_Validation::i();
		
		switch($type) {
			case 'location':
				return $valid->isLocation($data);
			case 'utc':
				return $valid->isUtc($data);
			case 'abbr':
				return $valid->isAbbr($data);
			default: break;
		}
		
		return parent::_isValid($type, $data);
	}
	
	/* Private Methods
	-------------------------------*/
}