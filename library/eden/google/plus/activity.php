<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus activity
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Plus_Activity extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_ACTIVITY_LIST		= 'https://www.googleapis.com/plus/v1/people/%s/activities/%s';
	const URL_ACTIVITY_GET		= 'https://www.googleapis.com/plus/v1/activities/%s';
	const URL_ACTIVITY_SEARCH	= 'https://www.googleapis.com/plus/v1/activities';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_userId			= 'me';
	protected $_queryString		= NULL;
	protected $_pageToken		= NULL;
	protected $_maxResults		= NULL;
	protected $_activityId		= NULL;
	protected $_collection		= NULL;
	
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
	 * Collection of all public activities
	 * of the user
	 *
	 * @return this
	 */
	public function setCollectionToPublic() {
		$this->_collection = 'public';
		
		return $this;
	}
	
	/**
	 * Set page token
	 *
	 * @param string
	 * @return array
	 */
	public function setPageToken($pageToken) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_pageToken = $pageToken;
		
		return $this;
	}
	
	/**
	 * Set Activity Id
	 *
	 * @param string
	 * @return array
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * The maximum number of people to include in the response, 
	 * used for paging.
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_maxResults = $maxResults;
		
		return $this;
	}
	
	/**
	 * Set Activity Id
	 *
	 * @param string
	 * @return array
	 */
	public function setActivityId($id) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $id;
		
		return $this;
	}
	
	/**
	 * Set query string
	 *
	 * @param string
	 * @return array
	 */
	public function setQueryString($queryString) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_queryString = $queryString;
		
		return $this;
	}
	
	/**
	 * Sort activities by relevance to the user, most relevant first.
	 *
	 * @return this
	 */
	public function orderByBest() {
		$this->_orderBy = 'best';
		
		return $this;
	}
	
	/**
	 * Sort activities by published date, most recent first.
	 *
	 * @return this
	 */
	public function orderByRecent() {
		$this->_orderBy = 'recent';
		
		return $this;
	}
	
	/**
	 * Get activity list of user
	 *
	 * @return array
	 */
	 public function getList() {
		//populate fields
		$query = array(
			self::COLLECTION	=> $this->_collection,
			self::USER_ID		=> $this->_userId,
			self::MAX_RESULTS	=> $this->_maxResults,
			SELF::PAGE_TOKEN	=> $this->_pageToken);
		
		return $this->_getResponse(sprintf(self::URL_ACTIVITY_LIST, $this->_userId, $this->_collection) , $query);
	 }
	
	/**
	 * Get an activity
	 *
	 * @return array
	 */
	 public function getSpecific() {
		 
		 return $this->_getResponse(sprintf(self::URL_ACTIVITY_GET, $this->_activityId));
	 } 
	 
	/**
	 * Search public activities
	 *
	 * @return array
	 */
	public function search() {
		//populate fields
		$query = array(
			self::QUERY_STRING	=> $this->_queryString,
			self::PAGE_TOKEN	=> $this->_pageToken,
			self::MAX_RESULTS	=> $this->_maxResults,
			self::ORDER			=> $this->_orderBy);
		
		return $this->_getResponse(self::URL_ACTIVITY_SEARCH, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}