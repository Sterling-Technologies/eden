<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Oauth2 desktop class
 *
 * @package    Eden
 * @category   desktop
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Oauth2_Desktop extends Eden_Oauth2_Abstract {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_responseType 	= self::CODE;
	protected $_grantType		= 'authorization_code';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/  
  	/**
	 * Returns website login url
	 *
	 * @param string|null
	 * @param string|null
	 * @return url
	 */
	public function getLoginUrl($scope = NULL, $display = NULL) {
		//argument test
		Eden_Oauth2_Error::i()
			->argument(1, 'string', 'array', 'null')	//argument 1 must be a string, array or null
			->argument(2, 'string', 'array', 'null');	//argument 2 must be a string, array or null
		
		//if scope in not null
		if(!is_null($scope)) {
			//lets set the scope
			$this->setScope($scope);
		}
		//if display in not null
		if(!is_null($display)) {
			//lets set the display
			$this->setDisplay($display);
		}
		
		//populate fields
		$query = array(
		  self::RESPONSE_TYPE   => $this->_responseType,
		  self::CLIENT_ID     	=> $this->_client,
		  self::REDIRECT_URL    => $this->_redirect);
	
		return $this->_getLoginUrl($query);
		
	}
	
	/**
	 * Returns website login url
	 *
	 * @param string*
	 * @return array
	 */
	public function getAccess($code) {
		//argument 1 must be a string
		Eden_Oauth2_Error::i()->argument(1, 'string');	
	 	
		//populate fields
		$query = array(
			self::CLIENT_ID		=> $this->_client,
			self::CLIENT_SECRET	=> $this->_secret,
			self::REDIRECT_URL	=> $this->_redirect,
			self::GRANT_TYPE	=> $this->_grantType);
		
		return $this->_getAccess($query, $code);
	}
 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
