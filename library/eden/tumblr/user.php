<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Tumblr user
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Tumblr_User extends Eden_Tumblr_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_INFO		= 'http://api.tumblr.com/v2/user/info';
	const URL_GET_DASHBOARD	= 'http://api.tumblr.com/v2/user/dashboard';
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
	 * Retrieve the user's account information that matches the 
	 * OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getInfo() {
		
		return $this->_getAuthResponse(self::URL_GET_INFO);
	}
	
	/**
	 * Retrieve the dashboard that matches 
	 * the OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getDashboard() {
		
		return $this->_getAuthResponse(self::URL_GET_DASHBOARD, $this->_query);
	}

	/**
	 * Retrieve the liked posts that 
	 * match the OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getLikes() {
		
		return $this->_getAuthResponse(self::URL_GET_LIKES, $this->_query);
	}
	
	/**
	 * Retrieve the blogs followed by the user 
	 * whose OAuth credentials are submitted with the request.
	 *
	 * @return array
	 */
	public function getFollowing() {
		
		return $this->_getAuthResponse(self::URL_GET_FOLLOWING, $this->_query);
	}
	
	/**
	 * Follow a blog 
	 *
	 * @param string
	 * @return array
	 */
	public function follow($url) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');			
			
		$this->_query['url'] = $url;
		
		return $this->_post(self::URL_FOLLOW, $this->_query);
	}
	
	/**
	 * Unfollow a blog 
	 *
	 * @param string
	 * @return array
	 */
	public function unfollow($url) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');			
		
		$this->_query['url'] = $url;
		
		return $this->_post(self::URL_UNFOLLOW, $this->_query);
	}
	
	/**
	 * Like a post 
	 *
	 * @param integer The ID of the post to like
	 * @param string The reblog key for the post id
	 * @return array
	 */
	public function like($postId, $reblogKey) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'integer')	//Argument 1 must be a integer
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_query['id'] 		= $postId;
		$this->_query['reblog_key'] = $reblogKey;
		
		return $this->_post(self::URL_LIKE, $this->_query);
	}
	
	/**
	 * Unlike a post 
	 *
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function unlike($postId, $reblogKey) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'integer')	//Argument 1 must be a integer
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_query['id'] 		= $postId;
		$this->_query['reblog_key'] = $reblogKey;
		
		return $this->_post(self::URL_UNLIKE, $this->_query);
	}
	
	/**
	 * The number of results to return: 1–20, inclusive
	 *
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * Indicates whether to return notes information 
	 * (specify true or false). Returns note count and note metadata.
	 *
	 * @param boolean
	 * @return this
	 */
	public function setNotesInfo($note) {
		//Argument 1 must be an boolean
		Eden_Tumblr_Error::i()->argument(1, 'bool');
		$this->_query['notes_info'] = $note;
		
		return $this;
	}
	
	/**
	 * Post number to start at
	 *
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['offset'] = $offset;
		
		return $this;
	}
	
	/**
	 * Indicates whether to return reblog information (specify true or false). 
	 * Returns the various reblogged_ fields.
	 *
	 * @param boolean
	 * @return this
	 */
	public function setReblogInfo($reblog) {
		//Argument 1 must be an boolean
		Eden_Tumblr_Error::i()->argument(1, 'bool');
		$this->_query['reblog_info'] = $reblog;
		
		return $this;
	}
	
	/**
	 * Return posts that have appeared after this ID
	 * Use this parameter to page through the results: 
	 * first get a set of posts, and then get posts 
	 * since the last ID of the previous set.
	 *
	 * @param integer
	 * @return this
	 */
	public function setSinceId($since) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $since;
		
		return $this;
	}
	
	/**
	 * The type of post to return. Specify one of the following:  
	 * text, photo, quote, link, chat, audio, video, answer
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['type'] = $type;
		
		return $this;
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}