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
class Eden_Google_Plus extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_PEOPLE					= 'https://www.googleapis.com/plus/v1/people';
	const URL_ACTIVITY					= 'https://www.googleapis.com/plus/v1/activities';
	const URL_ACTIVITY_LIST				= 'https://www.googleapis.com/plus/v1/people/%s/activities/%s';
	const URL_LIST_BY_ACTIVITY			= 'https://www.googleapis.com/plus/v1/activities/%s/people/%s';
	const URL_COMMENT					= 'https://www.googleapis.com/plus/v1/comments/%s';
	const URL_GET_USER					= 'https://www.googleapis.com/plus/v1/people/%s';
	const URL_GET_ACTIVITY				= 'https://www.googleapis.com/plus/v1/activities/%s';
	const URL_GET_COMMENTS				= 'https://www.googleapis.com/plus/v1/activities/%s/comments';
	
	const DEFAULT_USERID 				= 'me';
	const DEFAULT_ACTIVITY_COLLECTION	= 'public';
	const DEFAULT_USER_COLLECTION		= 'plusoners';
	
	const QUERY							= 'query';
	const PAGE_TOKEN					= 'pageToken';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_userId = NULL;
	
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
	 * Factory method for Eden_Google_Plus_Activity Class
	 *
	 * @return Eden_Google_Plus_Activity
	 */
	public function activity() {
		return Eden_Google_Plus_Activity::i($this->_token);
	}
	
	/**
	 * Factory method for Eden_Google_Plus_Activity Class
	 *
	 * @return Eden_Google_Plus_Activity
	 */
	public function comment() {
		return Eden_Google_Plus_Comment::i($this->_token);
	}
	
	/**
	 * Factory method for Eden_Google_Plus_People Class
	 *
	 * @return Eden_Google_Plus_People
	 */
	public function people() {
		return Eden_Google_Plus_People::i($this->_token);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}