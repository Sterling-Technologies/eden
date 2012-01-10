<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
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
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	 /**
	 * Returns the 20 most recent direct messages 
	 * sent to the authenticating user.
	 *
	 * @param since is integer
	 * @param max is integer
	 * @param count is integer
	 * @param page is integer
	 * @param entities is boolean
	 * @param skip is boolean
	 * @return $this
	 */
	 public function getList($since = NULL, $max = NULL, $count = NULL, $page = NULL, $entities = false, $skip = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be an boolean
			->argument(6, 'bool');						//Argument 6 must be a boolean
			
		$query = array();
		
		//if it is not empty a
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and max is not less than count
		if(!is_null($max) && $max <= $count) {
			//lets put it in query
			$query['max_id'] = $max;
		}
		//if it is not empty and its less than equal to 100 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty  
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if replies
		if($skip) {
			$query['skip_status'] = 1;
		}
		return $this->_getResponse(self::URL_DIRECT_MESSAGE, $query);
	 }
	 /**
	 * Returns the 20 most recent direct messages 
	 * sent by the authenticating user.
	 *
	 * @param since is integer
	 * @param max is integer
	 * @param count is integer
	 * @param page is integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getSent($since = NULL, $max = NULL, $count = NULL, $page = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool');						//Argument 5 must be an boolean

		$query = array();
		
		//if it is not empty a
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and max is not less than count
		if(!is_null($max) && $max <= $count) {
			//lets put it in query
			$query['max_id'] = $max;
		}
		//if it is not empty and its less than equal to 100 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty  
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}

		return $this->_getResponse(self::URL_SENT_MESSAGE, $query);
	 }
	 /**
	 * Destroys the direct message specified in the required  
	 * ID parameter. The authenticating user must be the 
	 * recipient of the specified direct message.
	 *
	 * @param id is integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function remove($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'bool');						//Argument 2 must be a boolean
		
		$query = array();
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		$url = sprintf(self::URL_REMOVE_MESSAGE, $id);
		return $this->_post($url,$query);
	 }
	 /**
	 * Sends a new direct message to the specified 
	 * user from the authenticating user. 
	 *
	 * @param text is string
	 * @param user is integer
	 * @param wrap is boolean
	 * @return $this
	 */
	 public function add($text, $user = NULL,  $wrap = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'int','string','null')	//Argument 2 must be an integer or string 
			->argument(3, 'bool');					//Argument 2 must be a boolean

		$query = array('text' => $text);
		//if it is not empty  
		if(!is_null($user)) {
			//if it is integer
			if(is_int($user)) {
				$query['user_id'] = $user;
			} else {
				$query['screen_name'] = $user;
			}
		}
		//if wrap
		if($wrap) {
			$query['wrap_links'] = 1;
		}
		return $this->_post(self::URL_NEW_MESSAGE, $query);
	 }
	 /**
	 * Returns a single direct message, 
	 * specified by an id parameter.
	 *
	 * @param id is integer
	 * @return $this
	 */
	 public function getDetail($id) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int');				//Argument 1 must be an integer
		$url = sprintf(self::URL_SHOW_MESSAGE,$id);
		return $this->_getResponse($url);
	 }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}