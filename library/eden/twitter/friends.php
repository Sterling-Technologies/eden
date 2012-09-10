<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter friends and followers
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Friends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_FRIENDS			= 'https://api.twitter.com/1.1/friends/ids.json';
	const URL_FOLLOWERS			= 'https://api.twitter.com/1.1/followers/ids.json';
	const URL_LOOKUP_FRIENDS	= 'https://api.twitter.com/1.1/friendships/lookup.json';
	const URL_INCOMING_FRIENDS	= 'https://api.twitter.com/1.1/friendships/incoming.json';
	const URL_OUTGOING_FRIENDS	= 'https://api.twitter.com/1.1/friendships/outgoing.json';
	const URL_FOLLOW_FRIENDS	= 'https://api.twitter.com/1.1/friendships/create.json';
	const URL_UNFOLLOW_FRIENDS	= 'https://api.twitter.com/1.1/friendships/destroy.json';
	const URL_UPDATE			= 'https://api.twitter.com/1.1/friendships/update.json';
	const URL_SHOW_FRIENDS		= 'https://api.twitter.com/1.1/friendships/show.json';

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
	 * Returns an array of numeric IDs for
	 * every user the specified user is following. 
	 *
	 * @param string|int
	 * @return array
	 */
	public function getFollowing($id = NULL) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'int', 'string', 'null');					

		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {	
			//lets put it in query
			$this->_query['string_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_FRIENDS, $this->_query);
	}
	
	/**
	 * Returns an array of numeric IDs for every 
	 * user following the specified user. 
	 *
	 * @param string|int|null
	 * @return array
	 */
	public function getFollowers($id = NULL) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'int', 'string', 'null');					

		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {	
			//lets put it in query
			$this->_query['string_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_FOLLOWERS, $this->_query);
	}
	
	/**
	 * Allows the authenticating users to follow the 
	 * user specified in the ID parameter..
	 * 
	 * @param string|int user id or screen name
	 * @param bool
	 * @return array
	 */
	public function follow($id, $notify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be an integer, string
			->argument(2, 'bool');			//Argument 1 must be a boolean
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_post(self::URL_FOLLOW_FRIENDS, $this->_query);
	}
	
	
	
	
	
	/**
	 * Returns an array of numeric IDs for every protected user 
	 * for whom the authenticating user has a pending follow request.
	 * 
	 * @return array
	 */
	public function getPendingFollowing() {
		
		return $this->_getResponse(self::URL_OUTGOING_FRIENDS, $this->_query);
	}
	
	/**
	 * Returns an array of numeric IDs for every user 
	 * who has a pending request to follow the authenticating user.
	 * 
	 * @return array
	 */
	public function getPendingFollowers() {
		
		return $this->_getResponse(self::URL_INCOMING_FRIENDS, $this->_query);
	 }
	
	/**
	 * Returns detailed information about the 
	 * relationship between two users.
	 * 
	 * @param int|string user ID or screen name
	 * @param int|string user ID or screen name
	 * @return array
	 */
	public function getRelationship($id, $target) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be an integer, string
			->argument(2, 'string', 'int');	//Argument 2 must be an integer, string
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$this->_query['source_id'] = $id;
		//if it is string
		} else {
			//lets put it in query
			$this->_query['source_screen_name'] = $id;
		}
		
		//if it is integer
		if(is_int($target)) {
			//lets put it in query
			$this->_query['target_id'] = $target;
		//if it is string
		} else {
			//lets put it in query
			$this->_query['target_screen_name'] = $target;
		}
		
		return $this->_getResponse(self::URL_SHOW_FRIENDS, $this->_query);
	}
	
	/**
	 * Returns the relationship of the authenticating user to 
	 * the comma separated list 
	 *
	 * @param int[,int]|string[,string]|array|null list of user IDs or screen names
	 * @return array
	 */
	public function getRelationships($id = NULL) {
		//Argument 1 must be an integer, string or null
		Eden_Twitter_Error::i() ->argument(1, 'int', 'string', 'array', 'null');	
		
		//if it is empty 
		if(is_null($id)) {
			return $this->_getResponse(self::URL_LOOKUP_FRIENDS, $this->_query);
		}
		
		//if it's not an array
		if(!is_array($id)) {
			//make it into one
			$id = func_get_args();
		}
		
		//if id is integer
		if(is_int($id[0])) {
			//lets put it in query
			$this->_query['user_id'] = implode(',',$id);
		//if it is streing
		} else {
			//lets put it in query
			$this->_query['screen_name'] = implode(',',$id);
		}
		
		return $this->_getResponse(self::URL_LOOKUP_FRIENDS, $this->_query);
	}
	 
	/**
	 * Allows the authenticating users to unfollow 
	 * the user specified in the ID parameter.
	 * 
	 * @param string|int user ID or screen name
	 * @param bool
	 * @return array
	 */
	public function unfollow($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string or int
			->argument(2, 'boolean');		//Argument 2 must be an boolean
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in query
			$this->_query['user_id'] = $id;
		} else {
			//lets put it in query
			$this->_query['string_name'] = $id;
		}
		
		//if entities
		if($entities) {
			$this->_query['include_entities'] = $entities;
		}
		
		return $this->_post(self::URL_UNFOLLOW_FRIENDS, $this->_query);
	}
	 
	/**
	 * Allows one to enable or disable retweets and device notifications 
	 * from the specified user. 
	 * 
	 * @param string|int user ID or screen name
	 * @param boolean
	 * @param boolean
	 * @return array
	 */
	public function update($id, $device = false, $retweets = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string or int
			->argument(2, 'bool')			//Argument 2 must be a boolean
			->argument(3, 'bool');			//Argument 3 must be a boolean
		
		//if id is string
		if(is_string($id)) {
			//lets put it in query
			$this->_query['screen_name'] = $id;
		//else it is integer
		} else {
			//lets put it in query
			$this->_query['user_id'] = $id;
		}

		if($device) {
			//lets put it in query
			$this->_query['device'] = 1;
		}
		
		if($retweets) {
			//lets put it in query
			$this->_query['retweets'] = 1;
		}
		
		return $this->_post(self::URL_UPDATE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}