<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Four square users
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Users extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_USERS				= 'https://api.foursquare.com/v2/users/self';
	const URL_USERS_LEADERBOARD	= 'https://api.foursquare.com/v2/users/leaderboard';
	const URL_USERS_PENDING		= 'https://api.foursquare.com/v2/users/requests';
	const URL_USERS_SEARCH		= 'https://api.foursquare.com/v2/users/search';
	const URL_USERS_BADGES		= 'https://api.foursquare.com/v2/users/self/badges';
	const URL_USERS_CHECKINS	= 'https://api.foursquare.com/v2/users/self/checkins';
	const URL_USERS_FRIENDS		= 'https://api.foursquare.com/v2/users/self/friends';
	const URL_USERS_LIST		= 'https://api.foursquare.com/v2/users/self/lists';
	const URL_USERS_MAYORSHIPS	= 'https://api.foursquare.com/v2/users/self/mayorships';
	const URL_USERS_PHOTOS		= 'https://api.foursquare.com/v2/users/self/photos';
	const URL_USERS_TIPS		= 'https://api.foursquare.com/v2/users/self/tips';
	const URL_USERS_TODOS		= 'https://api.foursquare.com/v2/users/self/todos';
	const URL_USERS_VENUE		= 'https://api.foursquare.com/v2/users/self/venuehistory';
	
	const URL_USERS_UPDATE_PHOTO	= 'https://api.foursquare.com/v2/users/self/update';
	const URL_USERS_UNFRIEND		= 'https://api.foursquare.com/v2/users/self/unfriend';
	const URL_USERS_SETPINGS		= 'https://api.foursquare.com/v2/users/self/setpings';
	const URL_USERS_SEND_REQUEST	= 'https://api.foursquare.com/v2/users/self/request';
	const URL_USERS_DENY_REQUEST	= 'https://api.foursquare.com/v2/users/self/deny';
	const URL_USERS_APPROVE_REQUEST	= 'https://api.foursquare.com/v2/users/self/approve';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_sort			= 'popular';
	protected $_token			= NULL;
	protected $_phone			= NULL;
	protected $_email			= NULL;
	protected $_twitter			= NULL;
	protected $_twitterSource	= NULL;
	protected $_fbid			= NULL;
	protected $_name			= NULL;
	protected $_limit			= NULL;
	protected $_offset			= NULL;
	protected $_afterTimestamp	= NULL;
	protected $_beforeTimestamp	= NULL;
	protected $_group			= NULL;
	protected $_location		= NULL;
	protected $_catagoryId		= NULL;
	protected $_userId			= NULL;
	protected $_photo			= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set phone
	 * 
	 * @param string
	 * @return this
	 */
	public function setPhone($phone) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_phone = $phone; 
		
		return $this;
	}
	
	/**
	 * Set email
	 * 
	 * @param string
	 * @return this
	 */
	public function setEmail($email) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_email  = $email; 
		
		return $this;
	}
	
	/**
	 * Set twitter account
	 * 
	 * @param string
	 * @return this
	 */
	public function setTwitter($twitter) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_twitter  = $twitter; 
		
		return $this;
	}
	
	/**
	 * Set twitter account id
	 * 
	 * @param string
	 * @return this
	 */
	public function setTwitterSource($twitterSource) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_twitterSource  = $twitterSource; 
		
		return $this;
	}
	
	/**
	 * Set facebook account
	 * 
	 * @param string
	 * @return this
	 */
	public function setFacebookId($facebookId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_facebookId  = $facebookId; 
		
		return $this;
	}
	
	/**
	 * Set name
	 * 
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_name  = $name; 
		
		return $this;
	}
	
	/**
	 * Set limits
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'int');
		$this->_limit  = $limit; 
		
		return $this;
	}
	
	/**
	 * Set to get a results after
	 * timestamp
	 * 
	 * @return this
	 */
	public function setAfterTimeStamp() {
		$this->_afterTimeStamp = time();
		
		return $this;
	}
	
	/**
	 * Set to get a results before
	 * timestamp
	 * 
	 * @return this
	 */
	public function setBeforeTimeStamp() {
		$this->_beforeTimeStamp = time();
		
		return $this;
	}
	
	/**
	 * Set offset for the results
	 * timestamp
	 * 
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'int');
		$this->_offset  = $offset; 
		
		return $this;
	}
	
	/**
	 * Set groups
	 * 
	 * @param string
	 * @return this
	 */
	public function setGroup($group) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_group  = $group; 
		
		return $this;
	}
	
	/**
	 * Sort results by recent tips
	 * 
	 * @return this
	 */
	public function sortByRecent() {
		$this->_sort = 'recent';
		
		return $this;
	}
	
	/**
	 * Sort results by near by tips
	 * 
	 * @return this
	 */
	public function sortByNearBy() {
		$this->_sort = 'nearby';
		
		return $this;
	}
	
	/**
	 * Set location by setting longtitide 
	 * and latitude
	 * 
	 * @param int|float
	 * @param int|float
	 * @return this
	 */
	public function setLocation($longtitude, $latitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'int', 'float')	//argument 1 must be an integer or float
			->argument(2, 'int', 'float');	//argument 2 must be an integer or float
			
		$this->_location  = $longtitude.', '.$latitude; 
		
		return $this;
	}
	
	/**
	 * Returns users informations
	 * 
	 * @return array
	 */
	public function getList() {	
		
		return $this->_getResponse(self::URL_USERS);
	}
	
	/**
	 * Returns users leader board
	 * 
	 * @param string
	 * @return array
	 */
	public function getLeaderBoard() {
		
		return $this->_getResponse(self::URL_USERS_LEADERBOARD);
	}
	
	/**
	 * Returns users all pending request
	 * 
	 * @return array
	 */
	public function getPendingRequest() {
		
		return $this->_getResponse(self::URL_USERS_PENDING);
	}
	
	/**
	 * Returns users saerch
	 * 
	 * @return array
	 */
	public function search() {
		//populate fields
		$query = array(
			'phone'			=> $this->_phone,			//optional
			'email'			=> $this->_email,			//optional
			'twitter'		=> $this->_twitter,			//optional
			'twitterSource'	=> $this->_twitterSource,	//optional
			'fbid'			=> $this->_fbid,			//optional
			'name'			=> $this->_name);			//optional
		
		return $this->_getResponse(self::URL_USERS_SEARCH, $query);
	}
	
	/**
	 * Returns users badges
	 * 
	 * @return array
	 */
	public function getBadget() {
		
		return $this->_getResponse(self::URL_USERS_BADGES);
	}
	
	/**
	 * Returns users checkins
	 * 
	 * @return array
	 */
	public function getCheckins() {
		
		//populate fields
		$query = array(
			'limit'				=> $this->_limit,				//optional
			'offset'			=> $this->_offset,				//optional
			'afterTimestamp'	=> $this->_afterTimestamp,		//optional
			'beforeTimestamp'	=> $this->_beforeTimestamp);	//optional
		
		return $this->_getResponse(self::URL_USERS_CHECKINS, $query);
	}
	
	/**
	 * Returns users friends
	 * 
	 * @param string
	 * @return array
	 */
	public function getFriends() {
		
		//populate fields
		$query = array(
			'limit'		=> $this->_limit,		//optional
			'offset'	=> $this->_offset);		//optional
		
		return $this->_getResponse(self::URL_USERS_FRIENDS, $query);
	}
	
	/**
	 * Returns users list
	 * 
	 * @return array
	 */
	public function getUsersList() {
		
		//populate fields
		$query = array(
			'group'	=> $this->_group,		//optional
			'll'	=> $this->_location);	//optional
		
		return $this->_getResponse(self::URL_USERS_LIST, $query);
	}
	
	/**
	 * Returns users mayor ships
	 * 
	 * @return array
	 */
	public function getMayorships() {
		
		return $this->_getResponse(self::URL_USERS_MAYORSHIPS);
	}
	
	/**
	 * Returns users photos
	 * 
	 * @return array
	 */
	public function getPhotos() {
		//populate fields
		$query = array(
			'limit'		=> $this->_limit,	//optional
			'offset'	=> $this->_offset);	//optional
		
		return $this->_getResponse(self::URL_USERS_PHOTOS, $query);
	}
	
	/**
	 * Returns users catagory history
	 * 
	 * @return array
	 */
	public function getVenuehistory() {

		//populate fields
		$query = array(
			'categoryId'		=> $this->_categoryId,
			'afterTimestamp'	=> $this->_afterTimestamp,
			'beforeTimestamp'	=> $this->_beforeTimestamp);
		
		return $this->_getResponse(self::URL_USERS_VENUE, $query);
	}
	
	/**
	 * Updates the user's profile photo. 
	 * 
	 * @param string Photo under 100KB in multipart MIME encoding with content type image/jpeg, image/gif, or image/png.
	 * @return array
	 */
	public function updatePhoto($photo) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		//populate fields
		$query = array('photo' => $photo);
		
		return $this->_post(self::URL_USERS_UPDATE_PHOTO, $query);
	
	}
	
	/**
	 * Cancels any relationship between the 
	 * acting user and the specified user. 
	 * 
	 * @param string Identity of the user to unfriend.
	 * @return array
	 */
	public function unFriend($userId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
			
		//populate fields
		$query = array('USER_ID' => $userId);
		
		return $this->_post(self::URL_USERS_UNFRIEND, $query);
	
	}
	
	/**
	 * Changes whether the acting user will receive pings
	 * when the specified user checks in.
	 * 
	 * @param string The user ID of a friend.
	 * @param boolean
	 * @return array
	 */
	public function setPings($userId, $value) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
			
		//populate fields
		$query = array(
			'USER_ID'	=> $this->_userId,
			'value'		=> $this->_value);
		
		return $this->_post(self::URL_USERS_SETPINGS, $query);
	}
	
	/**
	 * Sends a friend request to another user.
	 * 
	 * @param string The user ID to which a request will be sent.
	 * @return array
	 */
	public function sendRequest($userId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	

		//populate fields
		$query = array('USER_ID' => $userId);
		
		return $this->_post(self::URL_USERS_SEND_REQUEST, $query);
	
	}
	
	/**
	 * Denies a pending friend request from another user. 
	 * 
	 * @param string The user ID of a pending friend.
	 * @return array
	 */
	public function denyRequest($userId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		//populate fields
		$query = array('USER_ID' => $userId);
		
		return $this->_post(self::URL_USERS_DENY_REQUEST, $query);
	
	}
	
	/**
	 * Approves a pending friend request from another user. 
	 * 
	 * @param string The user ID of a pending friend.
	 * @return array
	 */
	public function approveRequest($userId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		

		//populate fields
		$query = array('USER_ID' => $userId);
		
		return $this->_post(self::URL_USERS_APPROVE_REQUEST, $query);
	
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}