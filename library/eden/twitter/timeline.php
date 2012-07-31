<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter timelines
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Timeline extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_TIMELINE		= 'https://api.twitter.com/1/statuses/home_timeline.json';
	const URL_MENTION 		= 'https://api.twitter.com/1/statuses/mentions.json';
	const URL_PUBLIC 		= 'https://api.twitter.com/1/statuses/public_timeline.json';
	const URL_BY_ME 		= 'https://api.twitter.com/1/statuses/retweeted_by_me.json';
	const URL_TO_ME 		= 'https://api.twitter.com/1/statuses/retweeted_to_me.json';
	const URL_OF_ME 		= 'https://api.twitter.com/1/statuses/retweets_of_me.json';
	const URL_USER 			= 'https://api.twitter.com/1/statuses/user_timeline.json';
	const URL_TO_USER 		= 'https://api.twitter.com/1/statuses/retweeted_to_user.json';
	const URL_BY_USER 		= 'https://api.twitter.com/1/statuses/retweeted_by_user.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_count		= NULL;
	protected $_since		= NULL;
	protected $_max			= NULL;
	protected $_page		= NULL;
	protected $_id			= NULL;
	protected $_name		= NULL;
	protected $_trim		= NULL;
	protected $_include		= NULL;
	protected $_entities	= NULL;
	protected $_replies		= NULL;
	protected $_detail		= NULL;
	
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
	 * Returns the 20 most recent retweets posted 
	 * by the authenticating user.
	 *
	 * @return array
	 */
	public function getBy() {
		//populate fields
		$query = array(
			'count'				=> $this->_count,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'page'				=> $this->_page,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_BY_ME, $query);
	}
	
	/**
	 * Returns the 20 most recent retweets posted by 
	 * the specified user. The user is specified using 
	 * the user_id or screen_name parameters  
	 *
	 * @return array
	 */
	public function getByUser() {
		//populate fields	
		$query = array(
			'user_id'			=> $this->_id,
			'screen_name'		=> $this->_name,
			'since_id'			=> $this->_id,
			'count'				=> $this->_count,
			'max_id'			=> $this->_max,
			'page'				=> $this->_page,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_BY_USER, $query);
	}
	
	/**
	 * Returns the 20 most recent statuses posted by the 
	 * authenticating user. It is also possible to request  
	 * another user's timeline by using the screen_name 
	 * or user_id parameter
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields	
		$query = array(
			'user_id'				=> $this->_id,
			'screen_name'			=> $this->_name,
			'since_id'				=> $this->_since,
			'count'					=> $this->_count,
			'max_id'				=> $this->_max,
			'page'					=> $this->_page,
			'trim_user'				=> $this->_trim,
			'include_rts'			=> $this->_include,
			'include_entities'		=> $this->_entities,
			'exclude_replies'		=> $this->_replies,
			'contributor_details'	=> $this->_detail);
		
		return $this->_getResponse(self::URL_USER, $query);
	}
	 
	/**
	 * Returns the 20 most recent mentions (status containing @username)
	 * for the authenticating user 
	 *
	 * @return array
	 */
	public function getMention() {
		//populate fields	
		$query = array(
			'count'					=> $this->_count,
			'since_id'				=> $this->_since,
			'max_id'				=> $this->_max,
			'page'					=> $this->_page,
			'trim_user'				=> $this->_trim,
			'include_rts'			=> $this->_include,
			'include_entities'		=> $this->_entities,
			'contributor_details'	=> $this->_detail);
		
		return $this->_getResponse(self::URL_MENTION, $query);
	}
	
	/**
	 * Returns the 20 most recent tweets of the authenticated 
	 * user that have been retweeted by others.
	 *
	 * @return array
	 */
	public function getOf() {
		//populate fields
		$query = array(
			'count'				=> $this->_count,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'page'				=> $this->_page,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_OF_ME, $query);
	}
	 
	/**
	 * Returns the 20 most recent statuses, including  
	 * retweets if they exist.
	 *
	 * @return array
	 */
	public function getPublic() {
		//populate fields	
		$query = array(
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_PUBLIC, $query);
	}
	
	/**
	 * Returns the 20 most recent statuses, including retweets 
	 * if they exist, posted by the authenticating user and 
	 * the user's they follow. This is the same timeline seen
	 * by a user when they login to twitter.com.
	 *
	 * @return array
	 */
	public function getTimeline() {
		//populate fields
		$query = array(
			'count'					=> $this->_count,
			'since_id'				=> $this->_since,
			'max_id'				=> $this->_max,
			'page'					=> $this->_page,
			'trim_user'				=> $this->_trim,
			'include_rts'			=> $this->_include,
			'include_entities'		=> $this->_entities,
			'exclude_replies'		=> $this->_replies,
			'contributor_details'	=> $this->_detail);
		
		return $this->_getResponse(self::URL_TIMELINE, $query);
	}
	
	/**
	 * Returns the 20 most recent retweets posted by 
	 * users the authenticating user follow
	 *
	 * @return array
	 */
	public function getTo() {
		//populate fields
		$query = array(
			'count'				=> $this->_count,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'page'				=> $this->_page,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_TO_ME, $query);
	}
	
	/**
	 * Returns the 20 most recent retweets posted 
	 * by users the specified user follows.  
	 *
	 * @return array
	 */
	public function getToUser() {
		//populate fields	
		$query = array(
			'user_id'			=> $this->_id,
			'screen_name'		=> $this->_name,
			'since_id'			=> $this->_id,
			'count'				=> $this->_count,
			'max_id'			=> $this->_max,
			'page'				=> $this->_page,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_TO_USER, $query);
	}
	
	/**
	 * Set count
	 *
	 * @param integer
	 * @return array
	 */
	public function setCount($count) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_count = $count;
		return $this;
	}
	
	/**
	 * Set contributors details
	 *
	 * @return array
	 */
	public function setDetail() {
		$this->_detail = true;
		return $this;
	}
	
	/**
	 * Set inclde entities
	 *
	 * @return array
	 */
	public function setEntities() {
		$this->_entities = true;
		return $this;
	}
	
	/**
	 * Set user id
	 *
	 * @param integer
	 * @return array
	 */
	public function setId($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Set include rts
	 *
	 * @return array
	 */
	public function setInclude() {
		$this->_include = true;
		return $this;
	}
	
	/**
	 * Set max id
	 *
	 * @param integer
	 * @return array
	 */
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_max = $max;
		return $this;
	}
	
	/**
	 * Set screen name
	 *
	 * @param string
	 * @return array
	 */
	public function setName($name) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Set page
	 *
	 * @param integer
	 * @return array
	 */
	public function setPage($page) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * Set exclude replies
	 *
	 * @return array
	 */
	public function setReplies() {
		$this->_replies = true;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param integer
	 * @return array
	 */
	public function setSince($since) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set trim user
	 *
	 * @return array
	 */
	public function setTrim() {
		$this->_trim = true;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}