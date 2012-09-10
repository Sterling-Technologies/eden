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
	const URL_DIRECT_MESSAGE	= 'https://api.twitter.com/1.1/direct_messages.json';
	const URL_SENT_MESSAGE		= 'https://api.twitter.com/1.1/direct_messages/sent.json';
	const URL_SHOW_MESSAGE		= 'https://api.twitter.com/1.1/direct_messages/show.json';
	const URL_REMOVE_MESSAGE	= 'https://api.twitter.com/1.1/direct_messages/destroy.json';
	const URL_NEW_MESSAGE		= 'https://api.twitter.com/1.1/direct_messages/new.json';

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
	 * Returns the 20 most recent direct messages 
	 * sent to the authenticating user.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_DIRECT_MESSAGE, $this->_query);
	}
	
	/**
	 * Returns the 20 most recent direct messages 
	 * sent by the authenticating user.
	 *
	 * @return array
	 */
	public function getSent() {
		
		return $this->_getResponse(self::URL_SENT_MESSAGE, $this->_query);
	}
	
	/**
	 * Returns a single direct message, 
	 * specified by an id parameter.
	 *
	 * @param int message ID
	 * @return array
	 */
	public function getDetail($messageId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');				
		
		$this->_query['id'] = $messageId;
		
		return $this->_getResponse(self::URL_SHOW_MESSAGE, $this->_query);
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
		
		$this->_query['id'] = $id;
		
		return $this->_post(self::URL_REMOVE_MESSAGE,$this->_query);
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
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$this->_query['user_id'] = $id;
		} else {
			//lets put it in query
			$this->_query['screen_name'] = $id;
		}
		
		$this->_query['text'] = $text;
		
		return $this->_post(self::URL_NEW_MESSAGE, $this->_query);
	}
	
	/**
	 * Each tweet will include a node called "entities". This node offers a variety 
	 * of metadata about the tweet in a discreet structure, including: user_mentions, 
	 * urls, and hashtags. 
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/**
	 * Specifies the number of direct messages to try and retrieve, up to 
	 * a maximum of 200. The value of count is best thought of as a limit 
	 * to the number of Tweets to return because suspended or deleted 
	 * content is removed after the count has been applied.
	 *
	 * @param integer
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['count'] = $count;
		
		return $this;
	}
	
	/**
	 * Returns results with an ID less than (that is, older than) or 
	 * equal to the specified ID.
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxId($maxId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['max_id'] = $maxId;
		
		return $this;
	}
	
	/**
	 * Specifies the page of results to retrieve.
	 *
	 * @param integer
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['page'] = $page;
		
		return $this;
	}
	
	/**
	 * Returns results with an ID greater than (that is, more recent than) the specified ID. 
	 * There are limits to the number of Tweets which can be accessed through the API. If 
	 * the limit of Tweets has occured since the since_id, the since_id will be forced 
	 * to the oldest ID available.
	 *
	 * @param integer
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $sinceId;
		
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
		$this->_query['skip_status'] = true;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}