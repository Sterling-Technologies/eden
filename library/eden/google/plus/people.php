<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus people
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Plus_People extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_USER			= 'https://www.googleapis.com/plus/v1/people/%s';
	const URL_PEOPLE_SEARCH		= 'https://www.googleapis.com/plus/v1/people';
	const URL_PEOPLE_ACTIVITY	= 'https://www.googleapis.com/plus/v1/activities/%s/people/%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_userId		= 'me';
	protected $_queryString	= NULL;
	protected $_maxResults	= NULL;
	protected $_pageToken	= NULL;
	protected $_activityId	= NULL;
	protected $_collection	= NULL;
	
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
	 * Set query string for search
	 *
	 * @param string
	 * @return this
	 */
	public function setQuery($query) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_queryString = $query;
		
		return $this;
	}
	
	/**
	 * The continuation token, used to page through large result sets. 
	 * To get the next page of results, set this parameter to the 
	 * value of "nextPageToken" from the previous response. 
	 *
	 * @param string
	 * @return this
	 */
	public function setPageToken($pageToken) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_pageToken = $pageToken;
		
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
	 * Set useId
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
	 * The ID of the activity to get the list of people for.
	 *
	 * @param string
	 * @return this
	 */
	public function setActivityId($activityId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $activityId;
		
		return $this;
	}
	
	
	/**
	 * The collection of people to list.  
	 * Acceptable values are:
	 * "plusoners" - List all people who have +1'd this activity.
	 * "resharers" - List all people who have reshared this activity.
	 *
	 * @param string|null
	 * @return this
	 */
	public function setCollection($collection) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_collection = $collection;
		
		return $this;
	}
	
	/**
	 * Returns user info
	 *
	 * @return array
	 */
	public function get() {
		
		return $this->_getResponse(sprintf(self::URL_GET_USER,$this->_userId));
	}
	
	/**
	 * Returns people that matches the queryString
	 *
	 * @return array
	 */
	public function search() {
		//populate fields
		$query = array(
			'query'			=> $this->_queryString,
			'pageToken'		=> $this->_pageToken,
			'maxResults'	=> $this->_maxResults);
		
		return $this->_getResponse(self::URL_PEOPLE_SEARCH, $query);
	}
	
	/**
	 * List all of the people in the specified 
	 * collection for a particular activity
	 *
	 * @return array
	 */
	public function getActivityList() {
		//populate fields
		$query = array(
			'activityId'	=> $this->_activityId,
			'collection'	=> $this->_collection,
			'maxResults'	=> $this->_maXResults,
			'pageToken'		=> $this->_pageToken);
		
		return $this->_getResponse(sprintf(self::URL_PEOPLE_ACTIVITY, $this->_activityId, $this->_collection), $query);
	}	

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}