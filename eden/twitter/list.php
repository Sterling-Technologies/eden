<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter list
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_List extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_ALL_LIST			= 'https://api.twitter.com/1/lists/all.json';
	const URL_GET_STATUS		= 'https://api.twitter.com/1/lists/statuses.json';
	const URL_REMOVE			= 'https://api.twitter.com/1/lists/members/destroy';
	const URL_MEMBERSHIP		= 'https://api.twitter.com/1/lists/memberships.json';
	const URL_SUBSCRIBER		= 'https://api.twitter.com/1/lists/subscribers.json';
	const URL_CREATE_SUBCRIBER	= 'https://api.twitter.com/1/lists/subscribers/create.json';
	const URL_SHOW_SUBSCRIBER	= 'https://api.twitter.com/1/lists/subscribers/show.json';
	const URL_REMOVE_SUBCRIBER	= 'https://api.twitter.com/1/lists/subscribers/destroy.json';
	const URL_CREATE_ALL		= 'https://api.twitter.com/1/lists/members/create_all.json';
	const URL_GET_MEMBER		= 'https://api.twitter.com/1/lists/members/show.json';
	const URL_GET_DETAIL		= 'https://api.twitter.com/1/lists/members.json';
	const URL_CREATE_MEMBER		= 'https://api.twitter.com/1/lists/members/create.json';
	const URL_REMOVE_MEMBER		= 'https://api.twitter.com/1/lists/destroy.json';
	const URL_UPDATE_MEMBER		= 'https://api.twitter.com/lists/update.json';
	const URL_CREATE_USER		= 'https://api.twitter.com/1/lists/create.json';
	const URL_GET_LISTS			= 'https://api.twitter.com/1/lists.json';
	const URL_SHOW				= 'https://api.twitter.com/1/lists/show.json';
	const URL_GET_SUBSCRITION	= 'https://api.twitter.com/1/lists/subscriptions.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/	
	protected $_id			= NULL;
	protected $_name		= NULL;
	protected $_ownerName	= NULL;
	protected $_ownerId		= NULL;
	protected $_since		= NULL;
	protected $_max			= NULL;
	protected $_perpage		= NULL;
	protected $_listId		= NULL;
	protected $_slug		= NULL;
	protected $_cursor		= NULL;
	protected $_mode		= NULL;
	protected $_description	= NULL;
	protected $_entities	= false;
	protected $_rts			= false;
	protected $_filter		= false;
	protected $_status		= false;
	
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
	 * Set user id
	 *
	 * @param integer
	 * @return array
	 */
	public function setId($id) {
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
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Set owner name
	 *
	 * @param string
	 * @return array
	 */
	public function setOwnerName($ownerName) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_ownerName = $ownerName;
		return $this;
	}
	
	
	/**
	 * Set owner id
	 *
	 * @param integer
	 * @return array
	 */
	public function setOwnerId($ownerId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_ownerId = $ownerId;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param integer
	 * @return array
	 */
	public function setSince($since) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set max id
	 *
	 * @param integer
	 * @return array
	 */
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_max = $max;
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
	 * Set list id
	 *
	 * @param integer
	 * @return array
	 */
	public function setListId($listId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_listId = $listId;
		return $this;
	}
	
	/**
	 * Set list id
	 *
	 * @param string
	 * @return array
	 */
	public function setSlug($slug) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_slug = $slug;
		return $this;
	}
	
	/**
	 * Set cursor
	 *
	 * @param string
	 * @return array
	 */
	public function setCursor($cursor) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_cursor = $cursor;
		return $this;
	}
	
	/**
	 * Set mode
	 *
	 * @param string
	 * @return array
	 */
	public function setMode($mode) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_mode = $mode;
		return $this;
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 * @return array
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_description = $description;
		return $this;
	}
	
	/**
	 * Set include entities
	 *
	 * @return array
	 */
	public function setEntities() {
		$this->_entities = true;
		return $this;
	}
	
	/**
	 * Set include entities
	 *
	 * @return array
	 */
	public function setRts() {
		$this->_rts = true;
		return $this;
	}
	
	/**
	 * Set filter to owned list
	 *
	 * @return array
	 */
	public function setFilter() {
		$this->_filter = true;
		return $this;
	}
	
	
	/**
	 * Set skip status
	 *
	 * @return array
	 */
	public function setStatus() {
		$this->_status = true;
		return $this;
	}
	
	
	/**
	 * Returns all lists the authenticating or specified user 
	 * subscribes to, including their own.
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query = array(
			'user_id'		=> $this->_id,
			'screen_name'	=> $this->_name);
			
		return $this->_getResponse(self::URL_ALL_LIST, $query);
	} 
	 
	/**
	 * Returns tweet timeline for members
	 * of the specified list.
	 *
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function getStatus($id, $slug) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')		//Argument 1 must be an integer
			->argument(2, 'string');	//Argument 2 must be a string
				
		$query = array(
			'list_id' 			=> $id, 
			'slug' 				=> $slug,
			'owner_name'		=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId,
			'since_id'			=> $this->_since,
			'max_id'			=> $this->_max,
			'per_page'			=> $this->_perpage,
			'include_entities'	=> $this->_entities,
			'rts'				=> $this->_rts);
		
		return $this->_getResponse(self::URL_GET_STATUS, $query);
	}
	 
	/**
	 * Removes the specified member from the list. 
	 * The authenticated user must be the list's 
	 * owner to remove members from the list.
	 *
	 * @return array
	 */
	public function remove() {
		//populate fields
		$query = array(
			'list_id'		=> $this->_listId,
			'slug'			=> $this->_slug,
			'user_id'		=> $this->_id,
			'screen_name'	=> $this->_name,
			'owner_name'	=> $this->_ownerName,
			'owner_id'		=> $this->_ownerId);
	
		return $this->_post(self::URL_REMOVE,$query);
	}
	
	/**
	 * Returns the lists the specified user has been 
	 * added to. If user_id or screen_name are not 
	 * provided the memberships for the authenticating 
	 * user are returned.
	 *
	 * @return array
	 */
	public function getMembership() {
		//populate fields
		$query = array(
			'user_id'				=> $this->_id,
			'screen_name'			=> $this->_name,
			'cursor'				=> $this->_cursor,
			'filter_to_owned_lists'	=> $this->_filter);
		
		return $this->_getResponse(self::URL_MEMBERSHIP, $query);
	}
	
	/**
	 * Returns the lists the specified user has been 
	 * added to. If user_id or screen_name are not 
	 * provided the memberships for the authenticating 
	 * user are returned.
	 *
	 * @param integer
	 * @return array
	 */
	public function getSubscribers($listId) {
		//populate fields
		$query = array(
			'list_id' 			=> $listId,
			'slug'				=> $this->_slug,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId,
			'cursor'			=> $this->_cursor,
			'include_entities'	=> $this->_entities,
			'skip_status'		=> $this->_status);
		
		return $this->_getResponse(self::URL_SUBSCRIBER,$query);
	}
	
	/**
	 * Subscribes the authenticated 
	 * user to the specified list.
	 *
	 * @param integer
	 * @return array
	 */
	public function createSubscriber($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
		
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_post(self::URL_CREATE_SUBCRIBER,$query);
	}
	
	/**
	 * Subscribes the authenticated user 
	 * to the specified list.
	 *
	 * @param integer
	 * @param string
	 * @param string
	 * @return array
	 */
	public function showSubsciber($id, $slug, $name) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')		//Argument 1 must be an integer
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
			
		//populate fields	
		$query = array(
			'list_id'			=> $id, 
			'slug'				=> $slug,
			'screen_name'		=> $name,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId,
			'include_entities'	=> $this->_entities,
			'skip_status'		=> $this->_status);
		
		return $this->_getResponse(self::URL_SHOW_SUBSCRIBER, $query);
	}
	
	/**
	 * Unsubscribes the authenticated 
	 * user from the specified list.
	 *
	 * @param integer
	 * @return array
	 */
	public function removeSubscriber($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,			
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_post(self::URL_REMOVE_SUBCRIBER, $query);
	}
	
	/**
	 * Adds multiple members to a list, by specifying a 
	 * comma-separated list of member ids or screen names. 
	 *
	 * @param integer
	 * @return array
	 */
	public function createAll($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		//populate fields	
		$query = array(
			'list_id'			=> $id,
			'slug'				=> $this->_slug,
			'screen_name'		=> $this->_name,
			'user_id'			=> $this->_id,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_post(self::URL_CREATE_ALL, $query);
	}
	
	/**
	 * Adds multiple members to a list, by specifying a 
	 * comma-separated list of member ids or screen names. 
	 *
	 * @param integer
	 * @return array
	 */
	public function getMember($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
		
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,
			'screen_name'		=> $this->_name,
			'user_id'			=> $this->_id,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId,
			'include_entities'	=> $this->_entities,
			'skip_status'		=> $this->_status);
		
		return $this->_getResponse(self::URL_GET_MEMBER, $query);
	}
	
	/**
	 * Returns the members of the specified list. 
	 * Private list members will only be shown if 
	 * the authenticated user owns the specified list.
	 *
	 * @param integer
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
			
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId,
			'cursor'			=> $this->_cursor,
			'include_entities'	=> $this->_entities,
			'skip_status'		=> $this->_status);
		
		return $this->_getResponse(self::URL_GET_DETAIL, $query);
	}
	
	/**
	 * Add a member to a list. The authenticated user 
	 * must own the list to be able to add members 
	 * to it. Note that lists can't have more than 500 members.
	 *
	 * @param integer
	 * @return array
	 */
	public function createMember($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
			
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,
			'user_id'			=> $this->_id,
			'screen_name'		=> $this->_name,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
	
		return $this->_post(self::URL_CREATE_MEMBER, $query);
	}
	
	/**
	 * Deletes the specified list. The authenticated 
	 * user must own the list to be able to destroy it
	 *
	 * @param integer
	 * @return array
	 */
	public function removeMember($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
			
		//populate fields
		$query = array(
			'list_id'			=> $id,
			'slug'				=> $this->_slug,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_post(self::URL_REMOVE_MEMBER, $query);
	}
	
	/**
	 * Updates the specified list. The authenticated user 
	 * must own the list to be able to update it.
	 *
	 * @param integer
	 * @return array
	 */
	public function updateMember($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');			
			
		//populate fields
		$query = array(
			'list_id' 			=> $id,
			'slug'				=> $this->_slug,
			'name'				=> $this->_name,
			'mode'				=> $this->_mode,
			'description'		=> $this->_description,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_post(self::URL_UPDATE_MEMBER, $query);
	}
	
	/**
	 * Creates a new list for the authenticated user.
	 * Note that you can't create more than 20 lists per account.
	 *
	 * @param string
	 * @return array
	 */
	public function createUser($name) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');				
		
		//populate fields
		$query = array(
			'name' 			=> $name,
			'mode'			=> $this->_mode,
			'description'	=> $this->_description);
		
		return $this->_post(self::URL_CREATE_USER, $query);
	}
	
	/**
	 * Returns the lists of the specified (or authenticated) 
	 * user. Private lists will be included if the 
	 * authenticated user is the same as the user whose
	 * lists are being returned.
	 *
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function getLists($id, $name) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')		//Argument 1 must be an integer
			->argument(2, 'string');	//Argument 2 must be a string
			
		//populate fields	
		$query = array(
			'user_id'		=> $id, 
			'screen_name'	=> $name,
			'cursor'		=> $this->_cursor);
	
		return $this->_getResponse(self::URL_GET_LISTS, $query);
	}
	
	/**
	 * Returns the specified list. Private lists will only 
	 * be shown if the authenticated user owns the specified list.
	 *
	 * @param integer
	 * @return array
	 */
	public function showList($listId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		//populate fields	
		$query = array(
			'list_id' 			=> $listId,
			'slug'				=> $this->_slug,
			'owner_screen_name'	=> $this->_ownerName,
			'owner_id'			=> $this->_ownerId);
		
		return $this->_getResponse(self::URL_SHOW, $query);
	}
	
	/**
	 * Returns the specified list. Private lists will only 
	 * be shown if the authenticated user owns the specified list.
	 *
	 * @return array
	 */
	public function getSubscription() {
		//populate fields
		$query = array(
			'user_id'		=> $this->_id,
			'screen_name'	=> $this->_name,
			'count'			=> $this->_count,
			'cursor'		=> $this->_cursor);
		
		return $this->_getResponse(self::URL_GET_SUBSCRITION, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}