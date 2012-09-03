<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Analytics
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Google_Analytics extends Eden_Google_Base {
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
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Google analytics management
	 *
	 * @return Eden_Google_Analytics_Management
	 */
	public function management() {
		return Eden_Google_Analytics_Management::i($this->_token);
	}
	
	/**
	 * Returns Google analytics reporting
	 *
	 * @return Eden_Google_Analytics_Reporting
	 */
	public function reporting() {
		return Eden_Google_Analytics_Reporting::i($this->_token);
	}
	
	/**
	 * Returns Google analytics multichannel
	 *
	 * @return Eden_Google_Analytics_Multichannel
	 */
	public function multiChannel() {
		return Eden_Google_Analytics_Multichannel::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}