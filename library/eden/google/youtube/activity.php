<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube activity
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Activity extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_EVENT		= 'https://gdata.youtube.com/feeds/api/users/%s/events';
	const URL_YOUTUBE_SUBTIVITY	= 'https://gdata.youtube.com/feeds/api/users/%s/subtivity';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId		= 'default';
	protected $_version		= '2';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token 		= $token;
		$this->_developerId = $developerId; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * YouTube user ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * Retrieve all user's event
	 *
	 * @return array
	 */
	public function getEvent() {
		//populate fields
		$query  = array(
			self::RESPONSE	=> self::JSON_FORMAT,
			self::VERSION	=> $this->_version);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_EVENT, $this->_userId), $query);
	}
	
	/**
	 * Retrieve all user's subtivity
	 *
	 * @return array
	 */
	public function getSubtivity() {
		//populate fields
		$query  = array(
			self::RESPONSE	=> self::JSON_FORMAT,
			self::VERSION	=> $this->_version);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_SUBTIVITY, $this->_userId), $query);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}