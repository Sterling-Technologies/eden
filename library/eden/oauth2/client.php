<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Oauth2 client class
 *
 * @package    Eden
 * @category   client
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Oauth2_Client extends Eden_Oauth2_Abstract {
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
	/**
	 * Returns website login url
	 *
	 * @param string*
	 * @param string*
	 * @param string|null
	 * @return url
	 */
	public function getLoginUrl($url, $redirect, $scope = NULL) {
		//argument testing
		Eden_Oauth2_Error::i()
		  ->argument(1, 'string')					//argument 1 must be a string
		  ->argument(2, 'string')					//argument 2 must be a string
		  ->argument(3, 'string', 'array', 'null');	//argument 3 must be a string, array or null
	
		//populate fields
		$query = array(
		  self::REDIRECT_URL    => $redirect,
		  self::RESPONSE_TYPE   => self::TOKEN,
		  self::APPROVAL		=> self::AUTO,
		  self::CLIENT_ID     	=> $this->_client);
	
		return $this->_getLoginUrl($url, $query, $scope = NULL);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
