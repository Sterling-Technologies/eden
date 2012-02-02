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
 * @category   Twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Friends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_FOLLOWERS			= 'https://api.twitter.com/1/followers/ids.json';
	const URL_FRIENDS			= 'https://api.twitter.com/1/friends/ids.json';
	const URL_FRIENDS_EXIST		= 'https://api.twitter.com/1/friendships/exists.json';
	const URL_INCOMING_FRIENDS	= 'https://api.twitter.com/1/friendships/incoming.json';
	const URL_OUTGOING_FRIENDS	= 'https://api.twitter.com/1/friendships/outgoing.json';
	const URL_SHOW_FRIENDS		= 'https://api.twitter.com/1/friendships/show.json';
	const URL_FOLLOW_FRIENDS	= 'https://api.twitter.com/1/friendships/create.json';
	const URL_UNFOLLOW_FRIENDS	= 'https://api.twitter.com/1/friendships/destroy.json';
	const URL_LOOKUP_FRIENDS	= 'https://api.twitter.com/1/friendships/lookup.json';
	const URL_UPDATE			= 'https://api.twitter.com/1/friendships/update.json';
	const URL_NO_RETWEETS_IDS	= 'https://api.twitter.com/1/friendships/no_retweet_ids.json';

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
	 * Returns an array of numeric IDs for every 
	 * user following the specified user. 
	 *
	 * @param boolean
	 * @param integer|string|null
	 * @param integer|null
	 * @return array
	 */
	public function getFollowers($stringify = false, $id = NULL, $cursor = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'bool')					//Argument 1 must be a boolean
			->argument(2, 'int', 'string', 'null')	//Argument 2 must be an integer, string or null
			->argument(3, 'int', 'null');			//Argument 3 must be an integer or null

		$query = array();
		
		//if it is not empty 
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in query
				$query['user_id'] = $id;
			}
			//if it is string
			if(is_string($id)) {
				//lets put it in query
				$query['string_name'] = $id;
			}
		}
		//if it is not empty 
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
		
		return $this->_getResponse(self::URL_FOLLOWERS, $query);
	}
	
	/**
	 * Returns an array of numeric IDs for
	 * every user the specified user is following. 
	 *
	 * @param boolean
	 * @param integer|string|null
	 * @param integer|null
	 * @return array
	 */
	public function getFriends($stringify = false, $id = NULL, $cursor = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'bool')					//Argument 1 must be an boolean
			->argument(2, 'int','string', 'null')	//Argument 2 must be an integer, string or null
			->argument(3, 'int', 'null');			//Argument 3 must be an integer or null

		$query = array();
		
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
		//if it is not empty 
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in query
				$query['user_id'] = $id;
			//if it is string
			} else {
				//lets put it in query
				$query['screen_name'] = $id;
			} 
		}
		//if it is not empty
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		
		return $this->_getResponse(self::URL_FRIENDS, $query);
	}
	
	/**
	 * Test for the existence of friendship between two users.
	 *
	 * @param integer|string|null
	 * @param integer|string|null
	 * @return boolean	
	 */
	public function checkFriendship($userA = NULL, $userB = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int', 'null')	//Argument 1 must be an integer, string or null
			->argument(2, 'string', 'int', 'null');	//Argument 2 must be an integer, string or null

		$query = array();
		
		//if it is not empty 
		if(!is_null($userA)) {
			//if it is integer
			if(is_int($userA)) {
				//lets put it in query
				$query['user_id_a'] = $userA;
			//if it is string
			} else {
				//lets put it in query
				$query['screen_name_a'] = $userA;
			}
		}
		
		//if it is not empty 
		if(!is_null($userB)) {
			//if it is integer
			if(is_int($userB)) {
				//lets put it in query
				$query['user_id_b'] = $userB;
			//if it is string
			} else {
				//lets put it in query
				$query['screen_name_b'] = $userB;
			}
	 	}
		
		return $this->_getResponse(self::URL_FRIENDS_EXIST, $query);
	}
	
	/**
	 * Returns an array of numeric IDs for every user 
	 * who has a pending request to follow the authenticating user.
	 * 
	 * @param boolean
	 * @param integer|null
	 * @return array
	 */
	public function incomingFriends($stringify = false, $cursor = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean')		//Argument 1 must be a boolean
			->argument(2, 'int', 'null');	//Argument 2 must be an integer or null

		$query = array();
		
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
		
		//if it is not empty 
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		
		return $this->_getResponse(self::URL_INCOMING_FRIENDS, $query);
	 }
	 
	/**
	 * Returns an array of numeric IDs for every protected user 
	 * for whom the authenticating user has a pending follow request.
	 * 
	 * @param boolean
	 * @param integer|null
	 * @return array
	 */
	public function outgoingFriends($stringify = false, $cursor = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean')		//Argument 1 must be a boolean
			->argument(2, 'int', 'null');	//Argument 2 must be an integer or null

		$query = array();
		
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
		
		//if it is not empty 
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		
		return $this->_getResponse(self::URL_OUTGOING_FRIENDS, $query);
	}
	
	/**
	 * Returns detailed information about the 
	 * relationship between two users.
	 * 
	 * @param integer
	 * @param boolean
	 * @return array
	 */
	 public function getDetails($id = NULL, $target = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'int', 'null')	//Argument 1 must be an integer, string or null
			->argument(2, 'string', 'int', 'null');	//Argument 2 must be an integer, string or null

		$query = array();
		
		//if it is not empty 
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in query
				$query['source_id'] = $id;
			//if it is string
			} else {
				//lets put it in query
				$query['source_screen_name'] = $id;
			}
		}
		
		//if it is not empty 
		if(!is_null($target)) {
			//if it is integer
			if(is_int($target)) {
				//lets put it in query
				$query['target_id'] = $target;
			//if it is string
			} else {
				//lets put it in query
				$query['target_screen_name'] = $target;
			}
		}
		
		return $this->_getResponse(self::URL_SHOW_FRIENDS, $query);
	}
	
	/**
	 * Allows the authenticating users to follow the 
	 * user specified in the ID parameter..
	 * 
	 * @param string|null
	 * @param integer|null
	 * @param boolean
	 * @return array
	 */
	public function followFriends($follow = false, $name = NULL, $id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean')		//Argument 1 must be a boolean
			->argument(2, 'string', 'null')	//Argument 2 must be a string or null
			->argument(3, 'int', 'null');	//Argument 3 must be an integer or null

		$query = array();
		
		//if follow
		if($follow) {
			$query['follow'] = $follow;
		}
		
		//if it is not empty 
		if(!is_null($name)) {
			//lets put it in query
			$query['screen_name'] = $name;
		}
		
		//if it is not empty 
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		
		return $this->_post(self::URL_FOLLOW_FRIENDS, $query);
	}
	
	/**
	 * Allows the authenticating users to unfollow 
	 * the user specified in the ID parameter.
	 * 
	 * @param integer|null
	 * @param string|null
	 * @param boolean
	 * @return array
	 */
	public function unfollowFriends($entities = false, $name = NULL, $id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean')		//Argument 1 must be an boolean
			->argument(2, 'string', 'null')	//Argument 2 must be a string or null
			->argument(3, 'int', 'null');	//Argument 3 must be an integer or null
			
		$query = array();
		
		//if it is not empty 
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		
		//if it is not empty 
		if(!is_null($name)) {
			//lets put it in query
			$query['screen_name'] = $name;
		}
		
		//if entities
		if($entities) {
			$query['include_entities'] = $entities;
		}
		
		return $this->_post(self::URL_UNFOLLOW_FRIENDS, $query);
	}
	
	/**
	 * Returns the relationship of the authenticating user to 
	 * the comma separated list 
	 *
	 * @param integer|string|null
	 * @return array
	 */
	public function lookupFriends($id = NULL) {
		//Argument 1 must be an integer, string or null
		Eden_Twitter_Error::i() ->argument(1, 'int', 'string', 'null');	
		
		$query = array();
		
		//if it is empty 
		if(is_null($id)) {
			return $this->_getResponse(self::URL_LOOKUP_FRIENDS, $query);
		}
		
		//if id is integer
		if(is_int($id)) {
			$id = explode(',', $id);
			//at this point id will be an array
			$id = array();
			//lets put it in query
			$query['user_id'] = $id;
		//if it is streing
		} else {
			$id = explode(',', $id);
			//at this point id will be an array
			$id = array();
			//lets put it in query
			$query['screen_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_LOOKUP_FRIENDS, $query);
	}
	 
	/**
	 * Allows one to enable or disable retweets and device notifications 
	 * from the specified user. 
	 * 
	 * @param boolean
	 * @param boolean
	 * @param string|integer|null
	 * @return array
	 */
	public function update($device = false, $retweets = false, $id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'bool')					//Argument 1 must be a boolean
			->argument(2, 'bool')					//Argument 2 must be a boolean
			->argument(3, 'string', 'int', 'null');	//Argument 3 must be a string, integer or null

		$query = array();
		
		//if it is not empty 
		if(!is_null($id)) {
			//if id is string
			if(is_string($id)) {
				//lets put it in query
				$query['screen_name'] = $id;
			//else it is integer
			} else {
				//lets put it in query
				$query['user_id'] = $id;
			}
		}

		if($device) {
			//lets put it in query
			$query['device'] = 1;
		}
		
		if($retweets) {
			//lets put it in query
			$query['retweets'] = 1;
		}
		
		return $this->_post(self::URL_UPDATE, $query);
	}
	
	/**
	 * Returns an array of user_ids that the 
	 * currently authenticated user does not 
	 * want to see retweets from.
	 * 
	 * @param boolean
	 * @return array
	 */
	public function getNoRetweets($stringify = false) {
		//Argument 1 must be an boolean
		Eden_Twitter_Error::i()->argument(1, 'bool');						
		
		$query = array();
		
		if($stringify) {
			//lets put it in query
			$query['stringify_ids'] =  1;
		}
		
		return $this->_getResponse(self::URL_NO_RETWEETS_IDS, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}