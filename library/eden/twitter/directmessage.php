<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter direct message
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Directmessage extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_DIRECT_MESSAGE	= 'https://api.twitter.com/1/direct_messages.json';
	const URL_SENT_MESSAGE		= 'https://api.twitter.com/1/direct_messages/sent.json';
	const URL_REMOVE_MESSAGE	= 'https://api.twitter.com/1/direct_messages/destroy/%d.json';
	const URL_NEW_MESSAGE		= 'https://api.twitter.com/1/direct_messages/new.json';
	const URL_SHOW_MESSAGE		= 'https://api.twitter.com/1/direct_messages/show/%d.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_entities	= NULL;
	protected $_skip		= NULL;
	protected $_wrap		= NULL;
	protected $_since		= NULL;
	protected $_max			= NULL;
	protected $_count		= NULL;
	protected $_page		= NULL;
	protected $_user		= NULL;
	
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
	 * Set include entities
	 *
	 * @param boolean
	 * @return this
	 */
	public function setEntities($entities) {
		//Argument 1 must be a boolean
		Eden_Twitter_Error::i()->argument(1, 'bool');
		
		$this->_entities = $entities;
		return $this;
	}
	
	/**
	 * Set skip status
	 *
	 * @param boolean
	 * @return this
	 */
	public function setSkip($skip) {
		//Argument 1 must be a boolean
		Eden_Twitter_Error::i()->argument(1, 'bool');
		
		$this->_skip = $skip;
		return $this;
	}
	
	/**
	 * Set wrap link
	 *
	 * @param boolean
	 * @return this
	 */
	public function setWrap($wrap) {
		//Argument 1 must be a boolean
		Eden_Twitter_Error::i()->argument(1, 'bool');
		
		$this->_wrap = $wrap;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param integer|null
	 * @return this
	 */
	public function setSince($since) {
		//Argument 1 must be an integer or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'null');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set max id
	 *
	 * @param integer|null
	 * @return this
	 */
	public function setMax($max) {
		//Argument 1 must be an integer or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'null');
		
		$this->_max = $max;
		return $this;
	}
	
	/**
	 * Set count
	 *
	 * @param integer|null
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be an integer or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'null');
		
		$this->_count = $count;
		return $this;
	}
	
	/**
	 * Set page
	 *
	 * @param integer|null
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be an integer or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'null');
		
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * Set user id or screen name
	 *
	 * @param integer|null
	 * @return this
	 */
	public function setUser($user) {
		//Argument 1 must be an integer or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'null');
		
		$this->_user = $user;
		return $this;
	}
	
	/**
	 * Returns the 20 most recent direct messages 
	 * sent to the authenticating user.
	 *
	 * @return array
	 */
	public function getList() {
		
		$query = array(
			'include_entities'	=> $this->_entities,
			'skip_status'		=> $this->_status,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'count'				=> $this->_count,
			'page'				=> $this->_page);
		
		return $this->_getResponse(self::URL_DIRECT_MESSAGE, $query);
	}
	
	/**
	 * Returns the 20 most recent direct messages 
	 * sent by the authenticating user.
	 *
	 * @return array
	 */
	public function getSent() {

		$query = array(
			'include_entities'	=> $this->_entities,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'count'				=> $this->_count,
			'page'				=> $this->_page);

		return $this->_getResponse(self::URL_SENT_MESSAGE, $query);
	}
	 
	/**
	 * Destroys the direct message specified in the required  
	 * ID parameter. The authenticating user must be the 
	 * recipient of the specified direct message.
	 *
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		$query = array(
			'id'				=> $id,
			'include_entities'	=> $this->_entities);
		
		return $this->_post(self::URL_REMOVE_MESSAGE,$query);
	}
	 
	/**
	 * Sends a new direct message to the specified 
	 * user from the authenticating user. 
	 *
	 * @param string
	 * @return array
	 */
	public function add($text) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');				
		
		//poulate fields	
		$query = array(
			'text' 			=> $text,
			'wrap_links'	=> $this->_wrap);
		
		//if it is integer
		if(is_int($this->_user)) {
			//lets put it in query
			$query['user_id'] = $this->_user;
		}
		
		//if it is string
		if(is_string($this->_user)) {
			//lets put it in query
			$query['screen_name'] = $this->_user;
		}

		return $this->_post(self::URL_NEW_MESSAGE, $query);
	}
	
	/**
	 * Returns a single direct message, 
	 * specified by an id parameter.
	 *
	 * @param integer
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');				
			
		$url = sprintf(self::URL_SHOW_MESSAGE,$id);
		return $this->_getResponse($url);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}