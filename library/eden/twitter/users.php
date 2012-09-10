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
	const URL_USERS_SETTING				= 'https://api.twitter.com/1.1/account/settings.json';
	const URL_USERS_VERIFY_CREDENTIALS	= 'https://api.twitter.com/1.1/account/verify_credentials.json';
	const URL_USERS_UPDATE_DEVICE		= 'https://api.twitter.com/1.1/account/update_delivery_device.json';
	const URL_USERS_UPDATE_PROFILE		= 'https://api.twitter.com/1.1/account/update_profile.json';
	const URL_USERS_UPDATE_BACKGROUND	= 'https://api.twitter.com/1.1/account/update_profile_background_image.json';
	const URL_UPDATE_PROFILE_COLOR		= 'https://api.twitter.com/1.1/account/update_profile_colors.json';
	const URL_ACCOUNT_UPLOAD			= 'https://api.twitter.com/1.1/account/update_profile_image.json';
	const URL_USERS_BLOCK_LIST			= 'https://api.twitter.com/1.1/blocks/list.json';
	const URL_GET_BLOCKING_ID			= 'https://api.twitter.com/1.1/blocks/ids.json';
	const URL_CREATE_BLOCKING			= 'https://api.twitter.com/1.1/blocks/create.json';
	const URL_REMOVE_BLOCKING			= 'https://api.twitter.com/1.1/blocks/destroy.json';
	const URL_LOOK_UP					= 'https://api.twitter.com/1.1/users/lookup.json';
	const URL_SEARCH					= 'https://api.twitter.com/1/users/search.json';
	const URL_SHOW						= 'https://api.twitter.com/1/users/show.json';
	const URL_CONTRIBUTEES				= 'https://api.twitter.com/1/users/contributees.json';
	const URL_CONTRIBUTORS				= 'https://api.twitter.com/1/users/contributors.json';

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
	 * Returns settings (including current trend, geo and sleep time information)
	 * for the authenticating user.
	 *
	 * @return array
	 */
	public function getAccountSettings() {
		
		return $this->_getResponse(self::URL_USERS_SETTING);
	}
	
	/**
	 * Returns an HTTP 200 OK response code and
	 * a representation of the requesting user 
	 * if authentication was successful 
	 *
	 * @return array
	 */
	public function getCredentials() {
		
		return $this->_getResponse(self::URL_USERS_VERIFY_CREDENTIALS, $this->_query);
	}
	
	/**
	 * Sets which device Twitter delivers updates to for the authenticating user. 
	 * Sending none as the device parameter will disable SMS updates.
	 *
	 * @param string Must be one of: sms, none.
	 * @return array
	 */
	public function updateDeliveryDevice($device) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');	
		
		$this->_query['device'] = $device;
		
		return $this->_post(self::URL_USERS_UPDATE_DEVICE, $this->_query);
	}
	
	/**
	 * Sets values that users are able to set 
	 * under the "Account" tab of their settings 
	 * page. Only the parameters specified 
	 * will be updated.
	 *
	 * @return array
	 */
	public function updateProfile() {
		
		return $this->_post(self::URL_USERS_UPDATE_PROFILE, $this->_query);
	}
	
	/**
	 * Updates the authenticating user's profile background image. 
	 * This method can also be used to enable or disable the profile 
	 * background image
	 *
	 * @param string
	 * @return array
	 */
	public function updateBackgroundImage($image) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['image'] = $image;
		
		return $this->_upload(self::URL_UPDATE_BACKGROUND, $this->_query);
	}
	
	/**
	 * Sets values that users are able to 
	 * set under the Account tab of their
	 * settings page. Only the parameters 
	 * specified will be updated.
	 *
	 * @return array
	 */
	public function updateProfileColor() {
		
		return $this->_post(self::URL_UPDATE_PROFILE_COLOR, $this->_query);
		
	}
	
	/**
	 * Updates the authenticating user's profile image.
	 *
	 * @param string
	 * @return array
	 */
	public function updateProfileImage($image) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
	
		$this->_query['image'] = $image;
		
		return $this->_upload(self::URL_ACCOUNT_UPLOAD, $this->_query);
	}
	
	/**
	 * Returns a collection of user objects that the authenticating user is blocking.
	 *
	 * @return array
	 */
	public function getBlockList() {
		
		return $this->_getResponse(self::URL_USERS_BLOCK_LIST, $this->_query);
	}
	
	/**
	 * Returns an array of numeric user ids 
	 * the authenticating user is blocking.
	 *
	 * @param boolean
	 * @return integer
	 */
	public function getBlockedUserIds($stringify = false) {
		//Argument 1 must be a boolean
		Eden_Twitter_Error::i()->argument(1, 'bool');		
		
		$this->_query['stringify_ids'] = $stringify;
		
		return $this->_getResponse(self::URL_GET_BLOCKING_ID, $this->_query);
	}
	
	/**
	 * Blocks the specified user from following the authenticating user.
	 *
	 * @param string|integer either the screen name or user ID
	 * @return array
	 */
	public function blockUser($id) {
		//Argument 1 must be a string, integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');	
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_post(self::URL_CREATE_BLOCKING, $this->_query);
	}
	
	/**
	 * Un-blocks the user specified in the ID parameter for the 
	 * authenticating user.
	 *
	 * @param string|integer either the screen name or user ID
	 * @return array
	 */
	public function unblock($id) {
		//Argument 1 must be a string, integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');	
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_post(self::URL_REMOVE_BLOCKING, $this->_query);
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
	
	/**
	 * Set name
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['name'] = $name;
		
		return $this;
	}
	
	/**
	 * Set url
	 *
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['url'] = $url;
		
		return $this;
	
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
	
	}
	
	/**
	 * Set location
	 *
	 * @param string
	 * @return this
	 */
	public function setLocation($location) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['location'] = $location;
		
		return $this;
	
	}
	
	/**
	 * Set profile background image to tile
	 *
	 * @return this
	 */
	public function setToTile() {
		$this->_query['tile'] = true;
		
		return $this;
	}
	
	/**
	 * Disable profile imaga background
	 *
	 * @return this
	 */
	public function disableProfileBackground() {
		$this->_query['use'] = false;
		
		return $this;
	}
	
	/**
	 * Set profile background color
	 *
	 * @param string
	 * @return this
	 */
	public function setBackgroundColor($background) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_background_color'] = $backgroud;
		
		return $this;
	}
	
	/**
	 * Set profile sibebar border color
	 *
	 * @param string
	 * @return this
	 */
	public function setBorderColor($border) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_sidebar_border_color'] = $border;
		
		return $this;
	}
	
	/**
	 * Set profile sibebar fill color
	 *
	 * @param string
	 * @return this
	 */
	public function setFillColor($fill) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_sidebar_fill_color'] = $fill;
		
		return $this;
	}
	
	/**
	 * Set profile link color
	 *
	 * @param string
	 * @return this
	 */
	public function setLinkColor($link) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_link_color'] = $link;
		
		return $this;
	}
	
	/**
	 * Set profile text color
	 *
	 * @param string
	 * @return this
	 */
	public function setTextColor($textColor) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_text_color'] = $textColor;
		
		return $this;
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
	 * Set skip status
	 *
	 * @return this
	 */
	public function skipStatus() {
		$this->_query['skip_status'] = true;
		
		$this->_status = true;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}
