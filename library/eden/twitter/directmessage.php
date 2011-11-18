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
	const URL_REMOVE_MESSAGE	= 'https://api.twitter.com/1/direct_messages/destroy/1270516771.json';
	const URL_NEW_MESSAGE		= 'httsp://api.twitter.com/1/direct_messages/new.format ';
	const URL_SHOW_MESSAGE		= 'https://api.twitter.com/1/direct_messages/show/:id.format ';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
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
	 public function directMessage($since = NULL, $max = NULL $count = NULL,, $page = NULL, $entities = false, $skip = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'int')						//Argument 3 must be an integer
			->argument(4, 'int')						//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be an boolean
			->argument(6, 'bool');						//Argument 6 must be a boolean
			
		$query = array();
		
		//if it is not empty a
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and max is not less than count
		if(!is_null(max) && $max <= $count) {
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
	 public function sentMessage($since = NULL, $max = NULL $count = NULL,, $page = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'int')						//Argument 3 must be an integer
			->argument(4, 'int')						//Argument 4 must be an integer
			->argument(5, 'bool');						//Argument 5 must be an boolean

		$query = array();
		
		//if it is not empty a
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and max is not less than count
		if(!is_null(max) && $max <= $count) {
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
	 * @param since is integer
	 * @param max is integer
	 * @param count is integer
	 * @param page is integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function removeMessage($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'bool');						//Argument 2 must be an boolean

		$query = array('id' => $id);
		
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}

		return $this->_getResponse(self::URL_REMOVE_MESSAGE, $query);
	 }
	 /**
	 * Sends a new direct message to the specified 
	 * user from the authenticating user. 
	 *
	 * @param text is string
	 * @param user is integer
	 * @param name is string
	 * @param wrap is boolean
	 * @return $this
	 */
	 public function newMessage($text, $user = NULL, $name = NULL,  $wrap = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string')					//Argument 1 must be an string
			->argument(2, 'int')					//Argument 2 must be an integer
			->argument(2, 'string')					//Argument 2 must be an string
			->argument(2, 'bool');					//Argument 2 must be an boolean

		$query = array('text' => $text);
		//if it is not empty  
		if(!is_null($user)) {
			//lets put it in query
			$query['user_id'] = $user;
		}
		//if it is not empty  
		if(!is_null($name)) {
			//lets put it in query
			$query['screen_name'] = $name;
		}
		//if wrap
		if($wrap) {
			$query['wrap_links'] = 1;
		}

		return $this->_getResponse(self::URL_NEW_MESSAGE, $query);
	 }
	 /**
	 * Returns a single direct message, 
	 * specified by an id parameter.
	 *
	 * @param id is integer
	 * @return $this
	 */
	 public function showMessage($id) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'id')					//Argument 1 must be an integer
			
		$query = array('id' => $id);

		return $this->_getResponse(self::URL_SHOW_MESSAGE, $query);
	 }
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}