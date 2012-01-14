<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Tumblr_User extends Eden_Tumblr_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.tumblr.com/v2/user/info';
	const URL_GET_USER		= 'http://api.tumblr.com/v2/user/dashboard';
	const URL_GET_LIKES		= 'http://api.tumblr.com/v2/user/likes';
	const URL_GET_FOLLOWING	= 'http://api.tumblr.com/v2/user/following';
	const URL_FOLLOW		= 'http://api.tumblr.com/v2/user/follow';
	const URL_UNFOLLOW		= 'http://api.tumblr.com/v2/user/unfollow';
	const URL_LIKE			= 'http://api.tumblr.com/v2/user/like';
	const URL_UNLIKE		= 'http://api.tumblr.com/v2/user/unlike';
	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Use this method to retrieve the user's account information 
	 * that matches the OAuth credentials submitted with the request.
	 *
	 * @return $this
	 */
	 public function getList() {
		$url = sprintf(self::URL_GET_LIST);
		return $this->_post($url);
	 }
	/**
	 * Use this method to retrieve the dashboard that matches 
	 * the OAuth credentials submitted with the request.
	 *
	 * @param limit is integer
	 * @param offset is integer
	 * @param type is string
	 * @param since is integer
	 * @param reblog is boolean
	 * @param notes is boolean
	 * @return $this
	 */
	 public function getUser($limit = NULL, $offset = NULL, $type = NULL, $since = NULL, $reblog = NULL, $notes = NULL) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')				//Argument 1 must be a integer
			->argument(2, 'integer')				//Argument 2 must be a integer
			->argument(3, 'string')					//Argument 3 must be a string
			->argument(4, 'integer')				//Argument 4 must be a integer
			->argument(5, 'boolean')				//Argument 5 must be a boolean
			->argument(6, 'boolean');				//Argument 6 must be a boolean
			
		$query = array();
		//if it is not empty
		if(!is_null($limit)) {
			//lets put it in the query
			$query['limit'] = $limit;
		}
		//if it is not empty
		if(!is_null($offset)) {
			//lets put it in the query
			$query['offset'] = $offset;
		}
		//if it is not empty
		if(!is_null($type)) {
			//lets put it in the query
			$query['type'] = $type;
		}
		//if it is not empty
		if(!is_null($since)) {
			//lets put it in the query
			$query['since_id'] = $since;
		}
		//if it is reblog
		if($reblog) {
			$query['reblog_info'] = 0;
		}
		//if it is notes
		if($notes) {
			$query['notes_info'] = 0;
		}
		
		return $this->_getResponse(self::URL_GET_USER);
	 }
	/**
	 * Use this method to retrieve the liked posts that 
	 * match the OAuth credentials submitted with the request.
	 *
	 * @param limit is integer
	 * @param offset is integer
	 * @return $this
	 */
	 public function getLikes($limit = NULL, $offset = NULL) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')				//Argument 1 must be a integer
			->argument(2, 'integer');				//Argument 2 must be a integer
			
		$query = array();
		//if it is not empty
		if(!is_null($limit)) {
			//lets put it in the query
			$query['limit'] = $limit;
		}
		//if it is not empty
		if(!is_null($offset)) {
			//lets put it in the query
			$query['offset'] = $offset;
		}
		
		return $this->_getResponse(self::URL_GET_LIKES);
	 }
	/**
	 * Use this method to retrieve the blogs followed by the user 
	 * whose OAuth credentials are submitted with the request.
	 *
	 * @param limit is integer
	 * @param offset is integer
	 * @return $this
	 */
	 public function getFollowing($limit = NULL, $offset = NULL) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')				//Argument 1 must be a integer
			->argument(2, 'integer');				//Argument 2 must be a integer
			
		$query = array();
		//if it is not empty
		if(!is_null($limit)) {
			//lets put it in the query
			$query['limit'] = $limit;
		}
		//if it is not empty
		if(!is_null($offset)) {
			//lets put it in the query
			$query['offset'] = $offset;
		}
		
		return $this->_getResponse(self::URL_GET_FOLLOWING);
	 }
	/**
	 * Follow a blog 
	 *
	 * @param url is string
	 * @return $this
	 */
	 public function follow($url) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string');			//Argument 1 must be a string
			
		$query = array('url' => $url);
		
		$url = sprintf(self::URL_FOLLOW, $url);
		return $this->_post($url,$query);
	 }
	 /**
	 * Unfollow a blog 
	 *
	 * @param url is string
	 * @return $this
	 */
	 public function unfollow($url) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string');			//Argument 1 must be a string
			
		$query = array('url' => $url);
		
		$url = sprintf(self::URL_UNFOLLOW, $url);
		return $this->_post($url,$query);
	 }
	 /**
	 * Like a post 
	 *
	 * @param id is integer
	 * @param reblog is string
	 * @return $this
	 */
	 public function like($id, $reblog) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')		//Argument 1 must be a integer
			->argument(2, 'string');		//Argument 2 must be a string
			
		$query = array('url' => $url, 'reblog_key' => $reblog);
		
		$url = sprintf(self::URL_LIKE, $url);
		return $this->_post($url,$query);
	 }
	 /**
	 * Unlike a post 
	 *
	 * @param id is integer
	 * @param reblog is string
	 * @return $this
	 */
	 public function unlike($id, $reblog) {
		//Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')		//Argument 1 must be a integer
			->argument(2, 'string');		//Argument 2 must be a string
			
		$query = array('url' => $url, 'reblog_key' => $reblog);
		
		$url = sprintf(self::URL_UNLIKE, $url);
		return $this->_post($url,$query);
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 /* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}