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
class Eden_Google_Plus_Comment extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_activityId	= NULL;
	protected $_pageToken	= NULL;
	protected $_commentId 	= NULL;
	
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
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_activityId = $activityId;
		
		return $this;
	}
	
	/**
	 * Set activity Id
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
	 * Set comment Id
	 *
	 * @param string
	 * @return array
	 */
	public function setCommentId($commentId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_commentId = $commentId;
		
		return $this;
	}
	
	/**
	 * get comment list of activity
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function getList($activityId = NULL, $pageToken = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($activityId) {
			$this->_activityId = $activityId;
		}
		
		if($pageToken) {
			$this->_pageToken = $pageToken;
		}
		
		$url = sprintf(Eden_Google_Plus::URL_ACTIVITY, $this->_activityId);
		$query = array();
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		
		return $this->_getResponse($url, $query);
	}
	
	/**
	 * get comment
	 *
	 * @param string|null
	 * @return array
	 */
	public function get($commentId = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		if($commentId) {
			$this->_commentId = $commentId;
		}
		
		$url = sprintf(Eden_Google_Plus::URL_COMMENT, $this->_commentId);
		$query = array();
		$query[Eden_Google_Plus::PAGE_TOKEN] = ($this->_pageToken) ? $this->_pageToken : NULL;
		
		return $this->_getResponse($url, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}