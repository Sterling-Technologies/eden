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
class Eden_Twitter_Timelines extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_TIMELINE		= 'https://api.twitter.com/1/statuses/home_timeline.json';
	const URL_MENTION 		= 'https://api.twitter.com/1/statuses/mentions.json';
	const URL_PUBLIC 		= 'https://api.twitter.com/1/statuses/public_timeline.json';
	const URL_BY_ME 		= 'https://api.twitter.com/1/statuses/retweeted_by_me.json';
	const URL_TO_ME 		= 'https://api.twitter.com/1/statuses/retweeted_to_me.json';
	const URL_OF_ME 		= 'https://api.twitter.com/1/statuses/retweets_of_me.json';
	const URL_USER 			= 'https://api.twitter.com/1/statuses/user_timeline.json';
	const URL_TO_USER 		= 'https://api.twitter.com/1/statuses/retweeted_to_user.json';
	const URL_BY_USER 		= 'https://api.twitter.com/1/statuses/retweeted_by_user.json';
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
	 * Returns the 20 most recent statuses, including retweets 
	 * if they exist, posted by the authenticating user and 
	 * the user's they follow. This is the same timeline seen
	 * by a user when they login to twitter.com.
	 *
	 * @param count is integer
	 * @param since is integer
	 * @param max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param include is boolean
	 * @param entities is boolean
	 * @param replies is boolean
	 * @param detail is boolean
	 * @return $this
	 */
	 public function getTimeline($count = NULL, $since = NULL, $max = NULL, $page = NULL, $trim = false, $include = false, $entities = false, $replies = false, $detail =false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be a boolean
			->argument(6, 'bool')						//Argument 6 must be a boolean
			->argument(7, 'bool')						//Argument 7 must be a boolean
			->argument(8, 'bool')						//Argument 8 must be a boolean
			->argument(9, 'bool');						//Argument 9 must be a boolean
			
		$query = array();
		//if it is not empty and its less than equal to 100 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty  
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if include
		if($include) {
			$query['include_rts'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if replies
		if($replies) {
			$query['exclude_replies'] = 1;
		}
		//if datails
		if($detail) {
			$query['contributor_details'] = 1;
		}
		
		return $this->_getResponse(self::URL_TIMELINE, $query);
	 }
	 /**
	 * Returns the 20 most recent mentions (status containing @username) for the authenticating user 
	 *
	 * @param count is integer
	 * @param since is integer
	 * @param max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param include is boolean
	 * @param entities is boolean
	 * @param detail is boolean
	 * @return $this
	 */
	 public function getMention($count = NULL, $since = NULL, $max = NULL, $page = NULL, $trim = false, $include = false, $entities = false, $detail =false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be an boolean
			->argument(6, 'bool')						//Argument 6 must be a boolean
			->argument(7, 'bool')						//Argument 7 must be a boolean
			->argument(8, 'bool');						//Argument 8 must be a boolean
			
		$query = array();
		
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty and 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if include
		if($include) {
			$query['include_rts'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if datails
		if($detail) {
			$query['contributor_details'] = 1;
		}
		
		return $this->_getResponse(self::URL_MENTION, $query);
	 }
	 /**
	 * Returns the 20 most recent statuses, including  
	 * retweets if they exist, from non-protected users.
	 *
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getPublic($trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'bool')						//Argument 1 must be a boolean
			->argument(2, 'bool');						//Argument 2 must be a boolean
			
		$query = array();
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}

		return $this->_getResponse(self::URL_PUBLIC, $query);
	 }
	  /**
	 * Returns the 20 most recent retweets posted by the authenticating user.
	 *
	 * @param count is integer
	 * @param since is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getBy($count = NULL, $since = NULL, $max = NULL, $page = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be an boolean
			->argument(6, 'bool');						//Argument 6 must be an boolean
			
		$query = array();
		
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty and 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_BY_ME, $query);
	 }
	 /**
	 * Returns the 20 most recent retweets posted by users the authenticating user follow
	 *
	 * @param count is integer
	 * @param since is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getTo($count = NULL, $since = NULL, $max = NULL, $page = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be a boolean
			->argument(6, 'bool');						//Argument 6 must be a boolean
			
		$query = array();
		
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty and 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_TO_ME, $query);
	 }
	 /**
	 * Returns the 20 most recent tweets of the authenticated user that have been retweeted by others.
	 *
	 * @param count is integer
	 * @param since is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getOf($count = NULL, $since = NULL, $max = NULL, $page = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int', 'null')				//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'bool')						//Argument 5 must be a boolean
			->argument(6, 'bool');						//Argument 6 must be a boolean
			
		$query = array();
		
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_OF_ME, $query);
	 }
	 /**
	 * Returns the 20 most recent statuses posted by the 
	 * authenticating user. It is also possible to request  
	 * another user's timeline by using the screen_name 
	 * or user_id parameter
	 *
	 * @param id is a integer
	 * @param name is a string
	 * @param since is integer
	 * @param count is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param include is boolean
	 * @param entities is boolean
	 * @param replies is boolean
	 * @param detail is boolean
	 * @return $this
	 */
	 public function getList($id = NULL, $since = NULL, $count = NULL, $max = NULL, $page = NULL, $trim = false, $include = false, $entities = false, $replies = false, $detail =false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int','string', 'null')		//Argument 1 must be an integer
			->argument(2, 'int', 'null')				//Argument 2 must be an integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be a boolean
			->argument(5, 'int', 'null')				//Argument 5 must be a boolean
			->argument(6, 'bool')						//Argument 6 must be a boolean
			->argument(7, 'bool')						//Argument 7 must be a boolean
			->argument(8, 'bool')						//Argument 8 must be a boolean
			->argument(9, 'bool')						//Argument 9 must be a boolean
			->argument(10, 'bool');						//Argument 10 must be a boolean
			
		$query = array();
		//If it is not empty
		if(!is_null($id)) {
			
			if(is_int($id)) {
				//Lets put it in query
				$query['user_id'] = $id;
			}
			
			if(is_string($id)) {
				//Lets put it in query
				$query['screen_name'] = $id;
			}	
		}
		//if it is not empty 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
				//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if include
		if($include) {
			$query['include_rts'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if replies
		if($replies) {
			$query['exclude_replies'] = 1;
		}
		//if datails
		if($detail) {
			$query['contributor_details'] = 1;
		}
		
		return $this->_getResponse(self::URL_USER, $query);
	 }
	 /**
	 * Returns the 20 most recent retweets posted 
	 * by users the specified user follows.  
	 *
	 * @param name is a string
	 * @param id is a integer or string
	 * @param since is integer
	 * @param count is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param include is boolean
	 * @param entities is boolean
	 * @param replies is boolean
	 * @param detail is boolean
	 * @return $this
	 */
	 public function getToUser($name = NULL, $id = NULL, $since = NULL, $count = NULL, $max = NULL, $page = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string', 'null')				//Argument 1 must be a string
			->argument(2, 'string', 'int', 'null')		//Argument 2 must be a string or integer
			->argument(3, 'int', 'null')				//Argument 3 must be an integer
			->argument(4, 'int', 'null')				//Argument 4 must be an integer
			->argument(5, 'int', 'null')				//Argument 5 must be a boolean
			->argument(6, 'int', 'null')				//Argument 6 must be a boolean
			->argument(7, 'bool')						//Argument 7 must be a boolean
			->argument(8, 'bool')						//Argument 8 must be a boolean
			->argument(9, 'bool')						//Argument 9 must be a boolean
			->argument(10, 'bool')						//Argument 10 must be a boolean
			->argument(11, 'bool');						//Argument 11 must be a boolean
			
		$query = array();
		//If it is not empty
		if(!is_null($id)) {
			//Lets put it in query
			$query['user_id'] = $id;
		}
		//IF it is not empty
		if(!is_null($name)) {
			//Lets put it in query
			$query['screen_name'] = $name;
		}
		//if it is not empty 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		return $this->_getResponse(self::URL_TO_USER, $query);
	 }
	 /**
	 * Returns the 20 most recent retweets posted by 
	 * the specified user. The user is specified using 
	 * the user_id or screen_name parameters  
	 *
	 * @param name is a string
	 * @param id is a integer or string
	 * @param since is integer
	 * @param count is integer
	 * @param $max is integer
	 * @param page is integer
	 * @param trim is boolean
	 * @param include is boolean
	 * @param entities is boolean
	 * @param replies is boolean
	 * @param detail is boolean
	 * @return $this
	 */
	 public function getByUser($name = NULL, $id = NULL, $since = NULL, $count = NULL, $max = NULL, $page = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string', 'null')				//Argument 1 must be a string
			->argument(2, 'string', 'int', 'null')		//Argument 2 must be a string or integer
			->argument(3, 'int', 'null')				//Argument 3 must be a integer
			->argument(4, 'int', 'null')				//Argument 4 must be a integer
			->argument(5, 'int', 'null')				//Argument 5 must be a boolean
			->argument(6, 'int', 'null')				//Argument 6 must be a boolean
			->argument(7, 'bool')						//Argument 7 must be a boolean
			->argument(8, 'bool');						//Argument 8 must be a boolean
			
		$query = array();
		//If it is not empty
		if(!is_null($id)) {
			//Lets put it in query
			$query['user_id'] = $id;
		}
		//IF it is not empty
		if(!is_null($name)) {
			//Lets put it in query
			$query['screen_name'] = $name;
		}
		//if it is not empty 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if it is not empty and 
		if(!is_null($count) && $count <= 200) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty and $max is not less than count
		if(!is_null($max) && $$max <= $count) {
			//lets put it in query
			$query['$max_id'] = $$max;
		}
		//if it is not empty and 
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $page;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		return $this->_getResponse(self::URL_BY_USER, $query);
	 }
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/


}