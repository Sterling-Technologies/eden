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
class Eden_Google_Plus_Activity extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_queryString		= NULL;
	protected $_pageToken		= NULL;
	protected $_activityId		= NULL;
	protected $_userId			= Eden_Google_Plus::DEFAULT_USERID;
	protected $_collection		= Eden_Google_Plus::DEFAULT_ACTIVITY_COLLECTION;
	
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
	 * Set page token
	 *
	 * @param string|null
	 * @return array
	 */
	 public function get($activityId = NULL) {
		 Eden_Google_Error::i()->argument(1, 'string', 'null');
		 if($activityId) {
			$this->_activityId = $activityId;
		 }
		 
		 $url = sprintf(Eden_Google_Plus::URL_ACTIVITY, $this->_activityId);
		 
		 return $this->_getResponse($url);
	 }
	 
	/**
	 * Get activity list of user
	 *
	 * @param string|null
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	 public function getList($userId = NULL, $collection = NULL, $pageToken = NULL) {
		 Eden_Google_Error::i()
		 	->argument(1, 'string', 'null')
			->argument(2, 'string', 'null')
			->argument(3, 'string', 'null');
		
		if($userId) {
			$this->_userId = $userId;
		}
		
		if($collection) {
			$this->_collection = $collection;
		}
		
		if($pageToken) {
			$this->_pageToken = $pageToken;
		}
		
		$url = sprintf(Eden_Google_Plus::URL_LIST_ACTIVITY, $this->_userId, $this->_collection);
		$query = array();
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		return $this->_getResponse($url, $query);
	 }
	
	/**
	 * Returns activity that matches the queryString
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
		
		$url = Eden_Google_Plus::URL_ACTIVITY;
		$query = array();
		$query[Eden_Google_Plus::QUERY] = urlencode($this->_queryString);
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		
		return $this->_getResponse($url, $query);
	}
	
	/**
	 * Set Activity Id
	 *
	 * @param string
	 * @return array
	 */
	public function setActivityId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $id;
		
		return $this;
	}
	
	/**
	 * Set Activity Id
	 *
	 * @param string
	 * @return array
	 */
	public function setCollection($collection) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_collection = $collection;
		
		return $this;
	}
	
	/**
	 * Set page token
	 *
	 * @param string
	 * @return array
	 */
	public function setPageToken($pageToken) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_pageToken = $pageToken;
		
		return $this;
	}
	
	/**
	 * Set query string
	 *
	 * @param string
	 * @return array
	 */
	public function setQueryString($queryString) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_queryString = $queryString;
		
		return $this;
	}
	
	/**
	 * Set Activity Id
	 *
	 * @param string
	 * @return array
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