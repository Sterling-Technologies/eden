<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter users
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Users extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_LOOK_UP		= 'https://api.twitter.com/1/users/lookup.json';
	const URL_PROFILE_IMAGE	= 'https://api.twitter.com/1/users/profile_image';
	const URL_SEARCH		= 'https://api.twitter.com/1/users/search.json';
	const URL_SHOW			= 'https://api.twitter.com/1/users/show.json';
	const URL_CONTRIBUTEES	= 'https://api.twitter.com/1/users/contributees.json';
	const URL_CONTRIBUTORS	= 'https://api.twitter.com/1/users/contributors.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_id			= NULL;
	protected $_name		= NULL;
	protected $_size		= NULL;
	protected $_page		= NULL;
	protected $_perpage		= NULL;
	protected $_entities	= NULL;
	protected $_status		= NULL;
	
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
	 * Returns an array of users that
	 * the specified user can contribute to.
	 *
	 * @param string|null Twitter User Id
	 * @param string|null Twitter Screen Name
	 * @return array
	 */
	public function getContributees($id = NULL, $name = NULL) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1,'string', 'null')		//Argument 1 must be a strng or null
			->argument(2,'string', 'null');		//Argument 2 must be a strng or null

		if($this->_id) {
			$this->_query['user_id'] = $id;
		}
		
		if($this->_name) {
			$this->_query['screen_name'] = $name;
		}
				
		return $this->_getResponse(self::URL_CONTRIBUTEES, $this->_query);
	}
	
	/**
	 * Returns an array of users that 
	 * the specified user can contribute to.
	 *
	 * @param string|null Twitter User Id
	 * @param string|null Twitter Screen Name
	 * @return array
	 */
	public function getContributors($id = NULL, $name = NULL) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1,'string', 'null')		//Argument 1 must be a strng or null
			->argument(2,'string', 'null');		//Argument 2 must be a strng or null

		if($this->_id) {
			$this->_query['user_id'] = $id;
		}
		
		if($this->_name) {
			$this->_query['screen_name'] = $name;
		}
				
		return $this->_getResponse(self::URL_CONTRIBUTORS, $this->_query);
	}
	 
	/**
	 * Returns extended information of a given user, specified
	 * by ID or screen name as per the required id parameter.
	 *
	 * @param int user ID
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');		
		
		//if it is integer
		if(is_int($id)) {
			//it is user id
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//it is screen name
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_SHOW, $this->_query);
	}
	 
	/**
	 * Access the profile image in various sizes 
	 * for the user with the indicated screen_name.
	 * If no size is provided the normal image is returned.
	 *
	 * @param string Twitter Screen Name
	 * @return array
	 */
	public function getProfileImage($name) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['screen_name'] = $name;
		
		return $this->_getResponse(self::URL_PROFILE_IMAGE, $this->_query);
	}
	
	/**
	 * Return up to 100 users worth of extended information, 
	 * specified by either ID, screen name, or combination of the two. 
	 *
	 * @return array
	 */
	public function lookupFriends() {
		
		//if id is integer
		if(is_int($this->_query['user_id'])) {
			$id = explode(',', $this->_query['user_id']);
			//at this point id will be an array
			$id = array();
			//lets put it in query
			$this->_query['user_id'] = $id;
		}
		
		//if name is string
		if(is_string($this->_query['screen_name'])) {
			$name = explode(',', $this->_query['screen_name']);
			//at this point id will be an array
			$name = array();
			$this->_query['screen_name'] = $name;
		}
		
		return $this->_getResponse(self::URL_LOOK_UP, $this->_query);
	}
	
	/**
	 * Set include entities
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/**
	 * Set user id
	 *
	 * @param integer
	 * @return this
	 */
	public function setUserId($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['user_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Set screen name
	 *
	 * @param string
	 * @return this
	 */
	public function setScreenName($name) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['screen_name'] = $name;
		
		return $this;
	}
	
	/**
	 * Set page
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
	 * Set per page
	 *
	 * @param integer
	 * @return this
	 */
	public function setPerpage($perPage) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['per_page'] = $perPage;
		
		return $this;
	}
	
	/**
	 * Set bigger image 73px by 73px
	 *
	 * @return this
	 */
	public function setBiggerImage() {
		$this->_query['size'] = 'bigger';
		
		return $this;
	}
	
	/**
	 * Set mini image 24px by 24px
	 *
	 * @return this
	 */
	public function setMiniImage() {
		$this->_query['size'] = 'mini';
		
		return $this;
	}
	
	/**
	 * This will be the size the image was originally uploaded in
	 *
	 * @return this
	 */
	public function setOriginalImage() {
		$this->_query['size'] = 'original';
		
		return $this;
	}
	
	/**
	 * Set skip status
	 *
	 * @return this
	 */
	public function skipStatus() {
		$this->_query['skip_status'] = true;
		
		$this->_status = true;
		return $this;
	}
	
	/**
	 * Runs a search for users similar to find people 
	 *
	 * @param string
	 * @return array
	 */
	public function search($search) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');	

		$this->_query['q'] = $search;
		
		return $this->_getResponse(self::URL_SEARCH, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}
