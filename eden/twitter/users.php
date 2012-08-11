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
	const URL_PROFILE_IMAGE	= 'https://api.twitter.com/1/users/profile_image.json';
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
	 * @return array
	 */
	public function getContributees() {
		$query = array();
		
		if($this->_id) {
			$query['user_id'] = $this->_id;
		}
		
		if($this->_name) {
			$query['screen_name'] = $this->_name;
		}
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_CONTRIBUTEES, $query);
	}
	
	/**
	 * Returns an array of users that 
	 * the specified user can contribute to.
	 *
	 * @return array
	 */
	public function getContributors() {
		$query = array();
		
		if($this->_id) {
			$query['user_id'] = $this->_id;
		}
		
		if($this->_name) {
			$query['screen_name'] = $this->_name;
		}
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_CONTRIBUTORS, $query);
	}
	 
	/**
	 * Returns extended information of a given user, specified
	 * by ID or screen name as per the required id parameter.
	 *
	 * @param int user ID
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1,'int');		

		$query = array('user_id' => $id);
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_SHOW, $query);
	}
	 
	/**
	 * Access the profile image in various sizes 
	 * for the user with the indicated screen_name.
	 * If no size is provided the normal image is returned.
	 *
	 * @return array
	 */
	public function getProfileImage() {
		//populate fields
		$query = array(
			'screen_name'	=> $this->_name,
			'size'			=> $this->_size);
		
		return $this->_getResponse(self::URL_PROFILE_IMAGE, $query);
	}
	
	/**
	 * Return up to 100 users worth of extended information, 
	 * specified by either ID, screen name, or combination of the two. 
	 *
	 * @return array
	 */
	public function lookupFriends() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		//if id is integer
		if(is_int($this->_id)) {
			$this->_id = explode(',', $this->_id);
			//at this point id will be an array
			$this->_id = array();
			//lets put it in query
			$query['user_id'] = $this->_id;
		}
		
		//if name is string
		if(is_string($this->_name)) {
			$this->_name = explode(',', $this->_name);
			//at this point id will be an array
			$this->_name = array();
			$query['screen_name'] = $this->_name;
		}
		
		return $this->_getResponse(self::URL_LOOK_UP, $query);
	}
	
	/**
	 * Set include entities
	 *
	 * @return array
	 */
	public function includeEntities() {
		$this->_entities = true;
		return $this;
	}
	
	/**
	 * Set user id
	 *
	 * @param integer
	 * @return array
	 */
	public function setUserId($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Set screen name
	 *
	 * @param string
	 * @return array
	 */
	public function setScreenName($name) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Set page
	 *
	 * @param integer
	 * @return array
	 */
	public function setPage($page) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * Set per page
	 *
	 * @param integer
	 * @return array
	 */
	public function setPerpage($perpage) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_perpage = $perpage;
		return $this;
	}
	
	/**
	 * Set size
	 *
	 * @param string
	 * @return array
	 */
	public function setSize($size) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_size = $size;
		return $this;
	}
	
	/**
	 * Set skip status
	 *
	 * @return array
	 */
	public function skipStatus() {
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

		$query = array('q' => $search);
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_perpage) {
			$query['per_page'] = $this->_perpage;
		}
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}
