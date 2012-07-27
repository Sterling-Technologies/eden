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
class Eden_Google_Plus_People extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_userId		= Eden_Google_Plus::DEFAULT_USERID;
	protected $_queryString	= NULL;
	protected $_pageToken	= NULL;
	protected $_activityId	= NULL;
	protected $_collection	= Eden_Google_Plus::DEFAULT_USER_COLLECTION;
	
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
	 * Returns user info
	 *
	 * @param string|null
	 * @return array
	 */
	public function get($userId = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		if($userId) {
			$this->_userId = $userId;
		}
		
		return $this->_getResponse(sprintf(Eden_Google_Plus::URL_GET_USER,$this->_userId));
	}
	
	/**
	 * List all of the people in the specified 
	 * collection for a particular activity
	 *
	 * @param string|null
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function listByActivity($activityId = NULL, $collection = NULL, $pageToken = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null')
			->argument(3, 'string', 'null');
		
		if($activityId) {
			$this->_activityId = $activityId;
		}
		
		if($collection) {
			$this->_collection = $collection;
		}
		
		if($pageToken) {
			$this->_pageToken = $pageToken;
		}
		
		$url = sprintf(Eden_Google_Plus::URL_LIST_BY_ACTIVITY, $this->_activityId, $this->_collection);
		$query = array();
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		
		return $this->_getResponse($url, $query);
	}
		
	/**
	 * Returns people that matches the queryString
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function search($queryString = NULL, $pageToken = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($queryString) {
			$this->_queryString = $queryString;
		}
		
		if($pageToken) {
			$this->_pageToken = $pageToken;
		}
		
		$url = Eden_Google_Plus::URL_PEOPLE;
		$query = array();
		$query[Eden_Google_Plus::QUERY] = urlencode($this->_queryString);
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		
		return $this->_getResponse($url, $query);
	}
	
	/**
	 * set activity id
	 *
	 * @param string|null
	 * @return this
	 */
	public function setActivityId($activityId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $activityId;
		
		return $this;
	}
	
	/**
	 * set activity id
	 *
	 * @param string|null
	 * @return this
	 */
	public function setCollection($collection) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_collection = $collection;
		
		return $this;
	}
	
	/**
	 * set page token
	 *
	 * @param string|null
	 * @return this
	 */
	public function setPageToken($token) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_pageToken = $token;
		
		return $this;
	}
	
	/**
	 * set query string for search
	 *
	 * @param string|null
	 * @return this
	 */
	public function setQuery($query) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_queryString = $query;
		
		return $this;
	}
	
	/**
	 * set useId
	 *
	 * @param string|null
	 * @return this
	 */
	public function setUserId($userId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}