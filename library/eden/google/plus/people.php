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
		$this->_query[self::PAGE_TOKEN] = $pageToken;
		
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
		$this->_query[self::MAX_RESULTS] = $maxResults;
		
		return $this;
	}
	
	/**
	 * Returns user info
	 *
	 * @param string
	 * @return array
	 */
	public function getUserInfo($userId = self::ME) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return $this->_getResponse(sprintf(self::URL_GET_USER,$userId));
	}
	
	/**
	 * Returns people that matches the queryString
	 *
	 * @param string|integer Full text search of public text in all profiles.
	 * @return array
	 */
	public function search($queryString) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		$this->_query[self::QUERY_STRING] = $queryString;
		
		return $this->_getResponse(self::URL_PEOPLE_SEARCH, $this->_query);
	}
	
	/**
	 * List all of the people in the specified 
	 * collection for a particular activity
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getActivityList($activityId, $collection) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
			
		//if the input value is not allowed
		if(!in_array($collection, array('plusoners', 'resharers'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_COLLECTION) 
				->addVariable($collection)
				->trigger();
		}
		
		$this->_query[self::ACTIVITY_ID]	= $activityId;
		$this->_query[self::COLLECTION]		= $collection;
		
		return $this->_getResponse(sprintf(self::URL_PEOPLE_ACTIVITY, $activityId, $collection), $this->_query);
	}	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}