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
	protected $_activityId	= NULL;
	protected $_pageToken	= NULL;
	protected $_maxResults	= NULL;
	protected $_commentId 	= NULL;
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
	 * Set activity Id
	 *
	 * @param string
	 * @return array
	 */
	public function setActivityId($activityId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $activityId;
		
		return $this;
	}
	
	/** 
	 * Set comment Id
	 *
	 * @param string
	 * @return array
	 */
	public function setCommentId($commentId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_commentId = $commentId;
		
		return $this;
	}
	
	/** 
	 * Sort newest comments first.
	 *
	 * @param string
	 * @return array
	 */
	public function descendingOrder() {
		$this->_sortOrder = 'descending';
		
		return $this;
	}
	
	/**
	 * List all of the comments for an activity.
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query = array(
			self::MAX_RESULTS	=> $this->_maxResults,
			self::PAGE_TOKEN	=> $this->_pageToken,
			self::SORT			=> $this->_sortOrder);
		
		return $this->_getResponse(sprintf(self::URL_COMMENTS_LIST, $this->_activityId), $query);
	}
	
	/**
	 * Get a comment
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_COMMENTS_GET));
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}