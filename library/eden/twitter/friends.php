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
class Eden_Twitter_Friends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_FOLLOWERS			= 'https://api.twitter.com/1/followers/ids.json';
	const URL_FRIENDS			= 'https://api.twitter.com/1/friends/ids.json';
	const URL_FRIENDS_EXIST		= 'https://api.twitter.com/1/friendships/exists.json';
	const URL_INCOMING_FRIENDS	= 'https://api.twitter.com/1/friendships/incoming.json';
	const URL_OUTGOING_FRIENDS	= 'https://api.twitter.com/1/friendships/outgoing.json';
	const URL_SHOW_FRIENDS		= 'https://api.twitter.com/1/friendships/show.json';
	const URL_FOLLOW FRIENDS	= '____________________________________';
	const URL_UNFOLLOW_FRIENDS	= '____________________________________';
	const URL_LOOKUP_FRIENDS	= 'https://api.twitter.com/1/friendships/lookup.json';
	const URL_UPDATE			= '____________________________________';
	const URL_NO_RETWEETS_IDS	= 'https://api.twitter.com/1/friendships/no_retweet_ids.json';


	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected static $_validName = array('twitterapi','twitter');
	
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
	 * Returns an array of numeric IDs for every 
	 * user following the specified user. 
	 *
	 * @param id is integer
	 * @param name is string
	 * @param cursor is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function followers($id = NULL, $name = NULL, $cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'string')						//Argument 2 must be an string
			->argument(3, 'int')						//Argument 3 must be an integer
			->argument(4, 'bool');						//Argument 4 must be an boolean

		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		//if it is not empty 
		if(!is_null($name)) {
			//lets put it in query
			$query['string_name'] = $name;
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
	 public function friends($id = NULL, $name = NULL, $cursor = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'string')						//Argument 2 must be an string
			->argument(3, 'int')						//Argument 3 must be an integer
			->argument(4, 'bool');						//Argument 4 must be an boolean

		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		//if it is not empty 
		if(!is_null($name)) {
			//lets put it in query
			$query['string_name'] = $name;
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
	 public function friendsExist($userA = NULL, $userB = NULL, $nameA = NULL, $nameB = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'string')						//Argument 3 must be an string
			->argument(4, 'string');						//Argument 4 must be an string

		$query = array();
		//if it is not empty 
		if(!is_null($userA)) {
			//lets put it in query
			$query['user_id_a'] = $userA;
		}
		//if it is not empty 
		if(!is_null($userB)) {
			//lets put it in query
			$query['user_id_b'] = $userB;
		}
		//if it is not empty 
		if(!is_null($nameA)) {
			//lets put it in query
			$query['screen_name_a'] = $nameA;
		}
		//if it is not empty 
		if(!is_null($nameB)) {
			//lets put it in query
			$query['screen_name_b'] = $nameB;
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
		Eden_Twitter_Error::get()
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
		Eden_Twitter_Error::get()
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
	 public function outgoingFriends($id = NULL, $name = NULL, $target = NULL, $screen = NULL) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string')						//Argument 1 must be an string
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'string')						//Argument 3 must be an string
			->argument(4, 'int');						//Argument 4 must be an integer




		$query = array();
		//if it is not empty 
		if(!is_null($id)) {
			//lets put it in query
			$query['source_id'] = $id;
		}
		//if it is not empty 
		if(!is_null($name)) {
			//lets put it in query
			$query['source_screen_name'] = $name;
		}//if it is not empty 
		if(!is_null($target)) {
			//lets put it in query
			$query['target_id'] = $target;
		}
		//if it is not empty 
		if(!is_null($screen)) {
			//lets put it in query
			$query['target_screen_name'] = $screen;
		}
		
		return $this->_getResponse(self::URL_OUTGOING_FRIENDS, $query);
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
		Eden_Twitter_Error::get()
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
		
		return $this->_getResponse(self::URL_FOLLOW_FRIENDS, $query);
	 }
	 /**
	 * Allows the authenticating users to unfollow the user specified in the ID parameter.
	 * 
	 * @param id is integer
	 * @param name is string
	 * @param entities is boolean
	 * @return $this
	 */
	 public function unfollowFriends($id = NULL, $name = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')							//Argument 1 must be an string
			->argument(2, 'string')							//Argument 2 must be an integer
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
		
		return $this->_getResponse(self::URL_UNFOLLOW_FRIENDS, $query);
	 }
	 /**
	 * Returns the relationship of the authenticating user to 
	 * the comma separated list of up to 100 screen_names or user_ids provided.
	 *
	 * @param id is integer
	 * @param name is string
	 * @param entities is boolean
	 * @return $this
	 */
	 public function unfollowFriends($id = NULL, $name = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')							//Argument 1 must be an string
			->argument(2, 'string')							//Argument 2 must be an integer
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
		
		return $this->_getResponse(self::URL_UNFOLLOW_FRIENDS, $query);
	 }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}