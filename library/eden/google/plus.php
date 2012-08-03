<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Plus extends Eden_Google_Base {
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
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Factory method for Eden_Google_Plus_Activity Class
	 *
	 * @return Eden_Google_Plus_Activity
	 */
	public function activity() {
		
		return Eden_Google_Plus_Activity::i($this->_token);
	}
	
	/**
	 * Factory method for Eden_Google_Plus_Activity Class
	 *
	 * @return Eden_Google_Plus_Activity
	 */
	public function comment() {
		
		return Eden_Google_Plus_Comment::i($this->_token);
	}
	
	/**
	 * Factory method for Eden_Google_Plus_People Class
	 *
	 * @return Eden_Google_Plus_People
	 */
	public function people() {
		
		return Eden_Google_Plus_People::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}