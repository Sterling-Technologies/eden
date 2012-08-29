<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter block
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Block extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_USER_BLOCK	= 'https://api.twitter.com/1/blocks/blocking.json';
	const URL_GET_BLOCKING_ID	= 'https://api.twitter.com/1/blocks/blocking/ids.json';
	const URL_GET_BLOCKING		= 'https://api.twitter.com/1/blocks/exists.json';
	const URL_CREATE_BLOCKING	= 'https://api.twitter.com/1/blocks/create.json';
	const URL_REMOVE_BLOCKING	= 'https://api.twitter.com/1/blocks/destroy.json';
	
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
	 * Blocks the specified user from following the authenticating user.
	 *
	 * @param string|integer either the screen name or user ID
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function blockUser($id, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string, integer
			->argument(2, 'bool')			//Argument 2 must be a boolean
			->argument(3, 'bool');			//Argument 3 must be a boolean
		
		$query = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
		
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_post(self::URL_CREATE_BLOCKING, $query);
	}
	
	/**
	 * Returns if the authenticating user is blocking a target user. 
	 *
	 * @param string|integer either the screen name or user ID
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function isBlocked($id = NULL, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string, integer
			->argument(2, 'bool')			//Argument 2 must be a boolean
			->argument(3, 'bool');			//Argument 3 must be a boolean
		
		$query = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
			
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_GET_BLOCKING, $query);
	}
	
	/**
	 * Returns an array of numeric user ids 
	 * the authenticating user is blocking.
	 *
	 * @param boolean
	 * @return integer
	 */
	public function getBlockedUserIds($stringify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'bool');		//Argument 1 must be a boolean
		
		$query = array('stringify_ids' => $stringify);
		
		return $this->_getResponse(self::URL_GET_BLOCKING_ID, $query);
	}
	
	/**
	 * Returns an array of user objects that 
	 * the authenticating user is blocking.
	 *
	 * @param integer|null
	 * @param integer|null
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function getBlockedUsers($page = NULL, $perPage = NULL, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'null')	//Argument 1 must be a integer or null
			->argument(2, 'int', 'null')	//Argument 2 must be a integer or null
			->argument(3, 'bool')			//Argument 3 must be a boolean
			->argument(4, 'bool');			//Argument 4 must be a boolean
		
		$query = array();
		
		//if it is not empty
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if it is not empty
		if(!is_null($perPage)) {
			//lets put it in query
			$query['per_page'] = $perPage;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if entities
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_GET_USER_BLOCK, $query);
	}
	
	/**
	 * Un-blocks the user specified in the ID parameter for the 
	 * authenticating user.
	 *
	 * @param string|integer either the screen name or user ID
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function unblock($id, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string, integer
			->argument(2, 'bool')			//Argument 2 must be a boolean
			->argument(3, 'bool');			//Argument 3 must be a boolean
		
		$query = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
		
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_post(self::URL_REMOVE_BLOCKING, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}