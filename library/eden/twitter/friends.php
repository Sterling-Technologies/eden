
<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
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
	const URL_FOLLOW_FRIENDS	= 'http://api.twitter.com/1/friendships/create.json';
	const URL_UNFOLLOW_FRIENDS	= 'https://api.twitter.com/1/friendships/destroy.json';
	const URL_LOOKUP_FRIENDS	= 'https://api.twitter.com/1/friendships/lookup.json';
	const URL_UPDATE			= 'https://api.twitter.com/1/friendships/update.json';
	const URL_NO_RETWEETS_IDS	= 'https://api.twitter.com/1/friendships/no_retweet_ids.json';


	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected static $_validName = array('twitterapi','twitter');
	
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
	 * @param id is integer
	 * @param name is string
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function getFollowers($id = NULL, $cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'bool');						//Argument 3 must be an boolean

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
	 * @param id is integer
	 * @param name is string
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function getFriends($id = NULL, $cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int','string')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 3 must be an integer
			->argument(3, 'bool');						//Argument 4 must be an boolean

		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			if(is_int($id)) {
				$query['user_id'] = $id;
			} else {
			//lets put it in query
			$query['screen_name'] = $id;
		} 
		}
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
		return $this->_getResponse(self::URL_FRIENDS, $query);
	 }
	 /**
	 * Test for the existence of friendship between two users.
	 *
	 * @param userA is integer
	 * @param userB is string
	 * @param nameA is integer
	 * @param nameB is boolean
	 * @return $this
	 */
	 public function friendsExist($userA = NULL, $userB = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string','int')						//Argument 1 must be an integer
			->argument(2, 'string','int');						//Argument 2 must be an integer

		$query = array();
		//if it is not empty 
		if(!is_null($userA)) {
			
			if(is_int($userA)) {
			//lets put it in query
				$query['user_id_a'] = $userA;
			} else {
				$query['screen_name_a'] = $userA;
			}
		}
		//if it is not empty 
		if(!is_null($userB)) {
			
			if(is_int($userB)) {
				//lets put it in query
				$query['user_id_b'] = $userB;
			} else {
				$query['screen_name_b'] = $userB;
			}
	 	}
		return $this->_getResponse(self::URL_FRIENDS_EXIST, $query);
	 }
	 /**
	 * Returns an array of numeric IDs for every user 
	 * who has a pending request to follow the authenticating user.
	 * 
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function incomingFriends($cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')							//Argument 1 must be an integer
			->argument(2, 'boolean');						//Argument 2 must be an integer

		$query = array();
		//if it is not empty 
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
	
		return $this->_getResponse(self::URL_INCOMING_FRIENDS, $query);
	 }
	 /**
	 * Returns an array of numeric IDs for every protected user 
	 * for whom the authenticating user has a pending follow request.
	 * 
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function outgoingFriends($cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')							//Argument 1 must be an integer
			->argument(2, 'boolean');						//Argument 2 must be an integer

		$query = array();
		//if it is not empty 
		if(!is_null($cursor)) {
			//lets put it in query
			$query['cursor'] = $cursor;
		}
		//if stringify
		if($stringify) {
			$query['stringify_ids'] = 1;
		}
	
		return $this->_getResponse(self::URL_OUTGOING_FRIENDS, $query);
	 }
	  /**
	 * Returns detailed information about the relationship between two users.
	 * 
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function getDetails($id = NULL, $target = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string','int')						//Argument 1 must be an string
			->argument(2, 'string','int');						//Argument 2 must be an string

		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			
			if(is_int($id)) {
				//lets put it in query
				$query['source_id'] = $id;
			}
			
			if(is_string($id)) {
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
			}
			//if it is string
			if(is_string($target)) {
				//lets put it in query
				$query['target_screen_name'] = $target;
			}
		}
		
		
		
		return $this->_getResponse(self::URL_SHOW_FRIENDS, $query);
	 }
	 /**
	 * Allows the authenticating users to follow the user specified in the ID parameter..
	 * 
	 * @param name is string
	 * @param id is integer
	 * @param follow is boolean
	 * @return $this
	 */
	 public function followFriends($name = NULL, $id = NULL, $follow = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')							//Argument 1 must be an string
			->argument(2, 'int')							//Argument 2 must be an integer
			->argument(3, 'boolean');						//Argument 3 must be an boolean



		$query = array();
		
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
		//if follow
		if($follow) {
			$query['follow'] = $follow;
		}
		
		return $this->_post(self::URL_FOLLOW_FRIENDS, $query);
	 }
	 /**
	 * Allows the authenticating users to unfollow the user specified in the ID parameter.
	 * 
	 * @param id is integer
	 * @param name is string
	 * @param entities is boolean
	 * @return $this
	 */
	 public function unfollowFriends($name = NULL, $id = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')							//Argument 1 must be an string
			->argument(2, 'int')							//Argument 2 must be an integer
			->argument(3, 'boolean');						//Argument 3 must be an boolean



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
	 * the comma separated list of up to 100 screen_names or user_ids provided.
	 *
	 * @param name is string
	 * @param id is integer
	 * @return $this
	 */
	 public function lookupFriends($id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string');							//Argument 1 must be an string

		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			//if id is integer
			if(is_int($id)) {
				$id = explode(',', $id);
				//lets put it in query
				$query['user_id'] = $id;
			}
			//if id is string
			if(is_string($id)) {
				$id = explode(',', $id);
				//at this poit id will be an array
				$id = array();
				 $query['screen_name'] = $id;
				
				
				//lets put it in query
				//$query['screen_name'] = $id;
			}
		}
		
		return $this->_getResponse(self::URL_LOOKUP_FRIENDS, $query);
	 }
	 /**
	 * Allows one to enable or disable retweets and device notifications from the specified user. 
	 * 
	 * @param id is string or integer
	 * @param device is boolean
	 * @param retweets is boolean
	 * @return $this
	 */
	 public function update($id = NULL, $device = NULL, $retweets = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string','int')					//Argument 1 must be a string or integer
			->argument(2, 'boolean')						//Argument 2 must be a boolean
			->argument(3, 'boolean');						//Argument 3 must be a boolean

		$query = array();
		
		//if it is not empty 
		if(!is_null($id)) {
			//if id is string
			if(is_string($id)) {
				//lets put it in query
				$query['screen_name'] = $id;
			}
			//if id is integer
			if(is_int($id)) {
				//lets put it in query
				$query['user_id'] = $id;
			}
		}
		
		if(!is_null($device)) {
			//lets put it in query
			$query['device'] = $device;
		}
		
		if(!is_null($retweets)) {
			//lets put it in query
			$query['retweets'] = $dretweets;
		}
		
		return $this->_post(self::URL_UPDATE, $query);
	 }
	  /**
	 * Returns an array of user_ids that the currently authenticated user does not want to see retweets from.
	 * 
	 * @param stringify is string
	 * @return $this
	 */
	 public function getNoRetweets($stringify = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean');						//Argument 1 must be an boolean

		$query = array();
		
		if(!is_null($stringify)) {
			//lets put it in query
			$query['stringify_ids'] = $stringify;
		}
		
		return $this->_getResponse(self::URL_NO_RETWEETS_IDS, $query);
	 }
	 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

?>