<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus comment
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Plus_Comment extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_COMMENTS_LIST	= 'https://www.googleapis.com/plus/v1/activities/%s/comments';
	const URL_COMMENTS_GET	= 'https://www.googleapis.com/plus/v1/comments/%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_pageToken	= NULL;
	protected $_maxResults	= NULL;
	protected $_sortOrder 	= NULL;
	
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
	 * Sort newest comments first.
	 *
	 * @param string
	 * @return array
	 */
	public function descendingOrder() {
		$this->_query[self::SORT] = 'descending';
		
		return $this;
	}
	
	/**
	 * List all of the comments for an activity.
	 *
	 * @param string
	 * @return array
	 */
	public function getList($activityId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_COMMENTS_LIST, $activityId), $this->_query);
	}
	
	/**
	 * Get a comment
	 *
	 * @param string
	 * @return array
	 */
	public function getSpecific($commentId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_COMMENTS_GET, $commentId));
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}