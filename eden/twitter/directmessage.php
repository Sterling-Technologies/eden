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
 * @author     Christian Blanquera cblanquera@openovate.com
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
	protected $_entities	= false;
	protected $_wrap		= NULL;
	protected $_since		= NULL;
	protected $_max			= 0;
	protected $_count		= 0;
	protected $_page		= 0;
	protected $_status		= false;
	
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
	 * Returns a single direct message, 
	 * specified by an id parameter.
	 *
	 * @param int message ID
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');				
			
		$url = sprintf(self::URL_SHOW_MESSAGE,$id);
		return $this->_getResponse($url);
	}
	
	/**
	 * Returns the 20 most recent direct messages 
	 * sent to the authenticating user.
	 *
	 * @return array
	 */
	public function getList() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_DIRECT_MESSAGE, $query);
	}
	
	/**
	 * Returns the 20 most recent direct messages 
	 * sent by the authenticating user.
	 *
	 * @return array
	 */
	public function getSent() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_SENT_MESSAGE, $query);
	}
	
	/**
	 * Each tweet will include a node called "entities". This node offers a variety 
	 * of metadata about the tweet in a discreet structure, including: user_mentions, 
	 * urls, and hashtags. 
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_entities = true;
		return $this;
	}
	 
	/**
	 * Destroys the direct message specified in the required  
	 * ID parameter. The authenticating user must be the 
	 * recipient of the specified direct message.
	 *
	 * @param int message ID
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		$query = array('id'	=> $id);
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_post(self::URL_REMOVE_MESSAGE,$query);
	}
	
	/**
	 * Sends a new direct message to the specified 
	 * user from the authenticating user. 
	 *
	 * @param string|int user ID or screen name
	 * @param string
	 * @return array
	 */
	public function send($id, $text) {
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int') 	//Argument 1 must be a string or int
			->argument(2, 'string');		//Argument 2 must be a string
		
		//poulate fields	
		$query = array(
			'text' 			=> $text,
			'wrap_links'	=> $this->_wrap);
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		} else {
			//lets put it in query
			$query['screen_name'] = $id;
		}

		return $this->_post(self::URL_NEW_MESSAGE, $query);
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
	 * Statuses will not be included in the returned user objects.
	 *
	 * @return this
	 */
	public function skipStatus() {
		$this->_status = true;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}