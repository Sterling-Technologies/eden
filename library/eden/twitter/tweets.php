<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter tweets
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Tweets extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_WHO_RETWEETED			= 'https://api.twitter.com/1/statuses/%s/retweeted_by.json';
	const URL_GET_WHO_RETWEETED_IDS	= 'https://api.twitter.com/1/statuses/%d/retweeted_by/ids.json';
	const URL_GET_RETWEETS 			= 'https://api.twitter.com/1/statuses/retweets/%s.json';
	const URL_GET_LIST 				= 'https://api.twitter.com/1/statuses/show.json';
	const URL_REMOVE 				= 'http://api.twitter.com/1/statuses/destroy/%s.json';
	const URL_RETWEET 				= 'http://api.twitter.com/1/statuses/retweet/%d.json';
	const URL_UPDATE 				= 'https://api.twitter.com/1/statuses/update.json';
	const URL_UPDATE_MEDIA 			= 'https://upload.twitter.com/1/statuses/update_with_media.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_latitude	= NULL;
	protected $_longtitude	= NULL;
	protected $_count		= NULL;
	protected $_page		= NULL;
	protected $_reply		= NULL;
	protected $_place		= NULL;
	protected $_stringify	= false;
	protected $_entities	= false;
	protected $_trim		= false;
	protected $_display		= false;
	protected $_wrap		= false;
	protected $_sensitive	= false;
	
	
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
	 * Set latitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLatitude($latitude) {
		//Argument 1 must be a float
		Eden_Twitter_Error::i()->argument(1, 'float');
		
		$this->_latitude = $latitude;
		return $this;
	}
	
	/**
	 * Set longtitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLongtitude($longtitude) {
		//Argument 1 must be a float
		Eden_Twitter_Error::i()->argument(1, 'float');
		
		$this->_longtitude = $longtitude;
		return $this;
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
	 * Set in reply to status id
	 *
	 * @param string
	 * @return array
	 */
	public function setReply($reply) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_reply = $reply;
		return $this;
	}
	
	/**
	 * Set place id
	 *
	 * @param string|integer
	 * @return array
	 */
	public function setPlace($place) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');
		
		$this->_place = $place;
		return $this;
	}
	
	/**
	 * Set stringify ids
	 *
	 * @return array
	 */
	public function setStringify() {
		$this->_stringify = true;
		return $this;
	}
	
	/**
	 * Set include entities
	 *
	 * @return array
	 */
	public function setEntities() {
		$this->_entities = true;
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
	
	/**
	 * Set display coordinates
	 *
	 * @return array
	 */
	public function setDisplay() {
		$this->_display = true;
		return $this;
	}
	
	/**
	 * Set wrap links
	 *
	 * @return array
	 */
	public function setWrap() {
		$this->_wrap = true;
		return $this;
	}
	
	/**
	 * Set possibly sensitive
	 *
	 * @return array
	 */
	public function setSensitive() {
		$this->_sensitive = true;
		return $this;
	}
	
	/**
	 * Show user objects of up to 100 members 
	 * who retweeted the status. 
	 *
	 * @param integer
	 * @return array
	 */
	public function getWhoRetweeted($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
		
		//populate fields
		$query = array(
			'id' 	=> $id,
			'count'	=> $this->_count,
			'page'	=> $this>_page);
	}
	
	/**
	 * Show user ids of up to 100 users who 
	 * retweeted the status.   
	 *
	 * @param integer
	 * @return array
	 */
	public function getWhoRetweetedIds() {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		//populate fields
		$query = array(
			'id' 			=> $id,
			'count'			=> $this->_count,
			'page'			=> $this->_page,
			'stringify_ids'	=> $this->_stringify);
		
		
		$url = sprintf(self::URL_GET_WHO_RETWEETED_IDS, $id);
		return $this->_post($url, $query);
	}
	 
	/**
	 * Returns up to 100 of the first retweets of a given tweet.   
	 *
	 * @param integer
	 * @return array
	 */
	public function getRetweets($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		//populate fields
		$query = array(
			'id' 				=> $id,
			'count'				=> $this->_count,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		$url = sprintf(self::URL_GET_RETWEETS, $id);
		return $this->_post($url, $query);
	}
	
	/**
	 * Returns a single status, specified by the id parameter below.    
	 * The status's author will be returned inline.
	 *
	 * @param integer
	 * @return array
	 */
	 public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		//populate fields
		$query = array(
			'id' 				=> $id,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);

		return $this->_getResponse(self::URL_GET_LIST, $query);
	}
	
	/**
	 * Destroys the status specified by the required ID parameter. 
	 * The authenticating user must be the author of the specified  .
	 * status. Returns the destroyed status if successful.
	 *
	 * @param integer
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		//populate fields
		$query = array(
			'id' 				=> $id,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);

		$url = sprintf(self::URL_REMOVE, $id);
		return $this->_post($url,$query);
	}
	
	/**
	 * Retweets a tweet. Returns the original tweet 
	 * with retweet details embedded
	 *
	 * @param integer
	 * @return array
	 */
	public function retweet($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		//populate fields
		$query = array(
			'id' 				=> $id,
			'trim_user'			=> $this->_trim,
			'include_entities'	=> $this->_entities);
		
		$url = sprintf(self::URL_RETWEET, $id);
		return $this->_post($url, $query);
	}
	
	/**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param string
	 * @return array
	 */
	 public function update($status) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		//populate fields
		$query = array(
			'status' 				=> $status,
			'in_reply_to_status_id'	=> $this->_reply,
			'lat'					=> $this->_latitude,
			'long'					=> $this->_longtitude,
			'place_id'				=> $this->_place,
			'display_coordinates'	=> $this->_display,
			'trim_user'				=> $this->_trim,
			'include_entities'		=> $this->_entities,
			'wrap_links'			=> $this->_wrap);		
		
		return $this->_post(self::URL_UPDATE, $query);
	}
	
	/**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	 public function updateMedia($status, $media) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		//populate fields
		$query = array(
			'status' 				=> $status,
			'media[]'				=> $media,
			'possibly_sensitive'	=> $this->_sensitive,
			'in_reply_to_status_id'	=> $this->_reply,
			'lat'					=> $this->_latitude,
			'long'					=> $this->_longtitude,
			'place_id'				=> $this->_place,
			'display_coordinates'	=> $this->_display);
		
		return $this->_getResponse(self::URL_UPDATE_MEDIA, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/	 
}