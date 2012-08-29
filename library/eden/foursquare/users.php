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
		$this->_query['phone'] = $phone;
		
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
		$this->_query['email'] = $email;
		
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
		$this->_query['twitter'] = $twitter;
		
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
		$this->_query['twitterSource'] = $twitterSource;
		
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
		$this->_query['fbid'] = $facebookId;
		
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
		$this->_query['name'] = $name;
		
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
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * Set to get a results after
	 * timestamp
	 * 
	 * @return this
	 */
	public function setAfterTimeStamp() {
		$this->_query['afterTimestamp'] = time();
		
		return $this;
	}
	
	/**
	 * Set to get a results before
	 * timestamp
	 * 
	 * @return this
	 */
	public function setBeforeTimeStamp() {
		$this->_query['beforeTimestamp'] = time();
		
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
		$this->_query['offset'] = $offset;
		
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
		$this->_query['group'] = $group;
		
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
			
		$this->_query['ll'] = $longtitude.', '.$latitude;
		
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
	 * Returns users search
	 * 
	 * @return array
	 */
	public function search() {
		
		return $this->_getResponse(self::URL_USERS_SEARCH, $this->_query);
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
		
		return $this->_getResponse(self::URL_USERS_CHECKINS, $this->_query);
	}
	
	/**
	 * Returns users friends
	 * 
	 * @param string
	 * @return array
	 */
	public function getFriends() {
		
		return $this->_getResponse(self::URL_USERS_FRIENDS, $this->_query);
	}
	
	/**
	 * Returns users list
	 * 
	 * @return array
	 */
	public function getUsersList() {
		
		return $this->_getResponse(self::URL_USERS_LIST, $this->_query);
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
		
		return $this->_getResponse(self::URL_USERS_PHOTOS, $this->_query);
	}
	
	/**
	 * Returns users catagory history
	 * 
	 * @return array
	 */
	public function getVenuehistory() {

		return $this->_getResponse(self::URL_USERS_VENUE, $this->_query);
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
		
		$this->_query['photo'] = $photo;
		
		return $this->_post(self::URL_USERS_UPDATE_PHOTO, $this->_query);
	
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
			
		$this->_query['USER_ID'] = $userId;
		
		return $this->_post(self::URL_USERS_UNFRIEND, $this->_query);
	
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
			
		$this->_query['USER_ID']	= $userId;
		$this->_query['value'] 		= $value;
		
		return $this->_post(self::URL_USERS_SETPINGS, $this->_query);
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

		$this->_query['USER_ID'] = $userId;
		
		return $this->_post(self::URL_USERS_SEND_REQUEST, $this->_query);
	
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
		
		$this->_query['USER_ID'] = $userId;
		
		return $this->_post(self::URL_USERS_DENY_REQUEST, $this->_query);
	
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

		$this->_query['USER_ID'] = $userId;
		
		return $this->_post(self::URL_USERS_APPROVE_REQUEST, $this->_query);
	
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}