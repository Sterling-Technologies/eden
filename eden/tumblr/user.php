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
	protected $_limit	= NULL;
	protected $_offset	= NULL;
	protected $_type	= NULL;
	protected $_since	= NULL;
	protected $_reblog	= true;
	protected $_notes	= true;
	
	
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
	 * Set limit
	 *
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_limit = $limit;
		return $this;
	}
	
	/**
	 * Set offset
	 *
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_offset = $offset;
		return $this;
	}
	
	/**
	 * Set type
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_type = $type;
		return $this;
	}
	
	/**
	 * Set since
	 *
	 * @param integer
	 * @return this
	 */
	public function setSince($since) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set reblog
	 *
	 * @return this
	 */
	public function setReblog() {
		$this->_reblog = false;
		return $this;
	}
	
	/**
	 * Set notes
	 *
	 * @return this
	 */
	public function setNotes() {
		$this->_notes = false;
		return $this;
	}
	
	/**
	 * Use this method to retrieve the user's account information 
	 * that matches the OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getInfo() {
		$url = self::URL_GET_INFO;
		return $this->_getResponse($url);
	}
	
	/**
	 * Use this method to retrieve the dashboard that matches 
	 * the OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getDashboard() {
		//populate fields	
		$query = array(
			'limit'			=> $this->_limit,
			'offset'		=> $this->_offset,
			'type'			=> $this->_type,
			'since_id'		=> $this->_since,
			'reblog_info'	=> $this->_reblog,
			'notes_info'	=> $this->_notes);
		
		return $this->_getResponse(self::URL_GET_DASHBOARD, $query);
	}
	
	/**
	 * Use this method to retrieve the liked posts that 
	 * match the OAuth credentials submitted with the request.
	 *
	 * @return array
	 */
	public function getLikes() {
		//populate fields	
		$query = array(
			'limit'			=> $this->_limit,
			'offset'		=> $this->_offset);
		
		return $this->_getResponse(self::URL_GET_LIKES, $query);
	}
	
	/**
	 * Use this method to retrieve the blogs followed by the user 
	 * whose OAuth credentials are submitted with the request.
	 *
	 * @return array
	 */
	public function getFollowing() {
		//populate fields	
		$query = array(
			'limit'			=> $this->_limit,
			'offset'		=> $this->_offset);
		
		return $this->_getResponse(self::URL_GET_FOLLOWING, $query);
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
			
		$query = array('url' => $url);
		
		$url = sprintf(self::URL_FOLLOW, $url);
		return $this->_post($url, $query);
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
			
		$query = array('url' => $url);
		
		$url = sprintf(self::URL_UNFOLLOW, $url);
		return $this->_post($url, $query);
	}
	
	/**
	 * Like a post 
	 *
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function like($id, $reblog) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'integer')	//Argument 1 must be a integer
			->argument(2, 'string');	//Argument 2 must be a string
			
		$query = array('url' => $url, 'reblog_key' => $reblog);
		
		$url = sprintf(self::URL_LIKE, $url);
		return $this->_post($url, $query);
	}
	
	/**
	 * Unlike a post 
	 *
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function unlike($id, $reblog) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'integer')	//Argument 1 must be a integer
			->argument(2, 'string');	//Argument 2 must be a string
			
		$query = array('url' => $url, 'reblog_key' => $reblog);
		
		$url = sprintf(self::URL_UNLIKE, $url);
		return $this->_post($url, $query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}