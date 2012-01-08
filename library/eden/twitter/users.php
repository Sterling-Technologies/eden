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
class Eden_Twitter_Users extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_LOOK_UP			= 'https://api.twitter.com/1/users/lookup.json';
	const URL_PROFILE_IMAGE		= 'https://api.twitter.com/1/users/profile_image.json';
	const URL_SEARCH			= 'https://api.twitter.com/1/users/search.json';
	const URL_SHOW				= 'https://api.twitter.com/1/users/show.json';
	const URL_CONTRIBUTEES		= 'https://api.twitter.com/1/users/contributees.json';
	const URL_CONTRIBUTORS		= 'https://api.twitter.com/1/users/contributors.json';


	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($key, $secret) {
		return self::_getMultiple(__CLASS__, $key, $secret);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	 /**
	 * Return up to 100 users worth of extended information, 
	 * specified by either ID, screen name, or combination of the two. 
	 *
	 * @param id is string or integer
	 * @param netities is boolean
	 * @return $this
	 */
	 public function lookupFriends($id = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')		//Argument 1 must be a string or integer
			->argument(2, 'boolean');			//Argument 1 must be a boolean

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
		
		return $this->_getResponse(self::URL_LOOK_UP, $query);
	 }
	 
	 /**
	 * Access the profile image in various sizes for the user with the 
	 * indicated screen_name. If no size is provided the normal image is returned.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function getProfileImage($name = NULL, $size = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')						//Argument 1 must be a string
			->argument(2, 'string', 'null');							//Argument 2 must be a string

		$query = array();
		//if it is not empty 
		if(!is_null($name)) {
				//lets put it in query
				$query['screen_name'] = $name;
		}
		//if it is not empty 
		if(!is_null($size)) {
				//lets put it in query
				$query['size'] = $size;
		}
		
		
		return $this->_getResponse(self::URL_PROFILE_IMAGE, $query);
	 }
	 /**
	 * Runs a search for users similar to Find People button on Twitter.com.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function search($q,	$page = NULL, $perpage = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string','int','null')			//Argument 1 must be a string or integer
			->argument(2, 'int', 'null')					//Argument 2 must be an integer
			->argument(3, 'int', 'null')					//Argument 3 must be an integer
			->argument(4, 'boolean');						//Argument 4 must be a boolean

		$query = array('q' => $q);
		//if it is not empty 
		if(!is_null($page)) {
				//lets put it in query
				$query['page'] = $page;
		}
		//if it is not empty 
		if(!is_null($perpage) && $perpage <= 20) {
				//lets put it in query
				$query['per_page'] = $perpage;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	 }
	 /**
	 * Returns extended information of a given user, specified
	 *  by ID or screen name as per the required id parameter.
	 *
	 * @param id is string or integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getDetail($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string','int')			//Argument 1 must be a string or integer
			->argument(2, 'boolean');				//Argument 4 must be a boolean

		$query = array('user_id', 'screen_name' => $id);
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		
		return $this->_getResponse(self::URL_SHOW, $query);
	 }
	 /**
	 * Returns an array of users that the specified user can contribute to.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function getContributees($id = NULL, $name = NULL, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'null')			//Argument 1 must be a string or integer
			->argument(2, 'int','string', 'null')	//Argument 1 must be a string or integer
			->argument(3, 'boolean')				//Argument 4 must be a boolean
			->argument(4, 'boolean');				//Argument 4 must be a boolean

		$query = array();
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in our query	
			$query['user_id'] = $id;
		}
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in our query	
			$query['screen_name'] = $name;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if entities
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_CONTRIBUTEES, $query);
	 }
	 /**
	 * Returns an array of users that the specified user can contribute to.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function getContributors($id = NULL, $name = NULL, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'null')			//Argument 1 must be a string or integer
			->argument(2, 'int','string', 'null')	//Argument 1 must be a string or integer
			->argument(3, 'boolean')				//Argument 4 must be a boolean
			->argument(4, 'boolean');				//Argument 4 must be a boolean

		$query = array();
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in our query	
			$query['user_id'] = $id;
		}
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in our query	
			$query['screen_name'] = $name;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if entities
		if($status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_CONTRIBUTORS, $query);
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}
