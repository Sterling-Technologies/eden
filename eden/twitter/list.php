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
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_List extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_ALL_LIST			= 'https://api.twitter.com/1/lists/all.json';
	const URL_GET_STATUS		= 'https://api.twitter.com/1/lists/statuses.json';
	const URL_REMOVE			= 'https://api.twitter.com/1/lists/destroy.json';
	const URL_MEMBERSHIP		= 'https://api.twitter.com/1/lists/memberships.json';
	const URL_SUBSCRIBER		= 'https://api.twitter.com/1/lists/subscribers.json';
	const URL_CREATE_SUBCRIBER	= 'https://api.twitter.com/1/lists/subscribers/create.json';
	const URL_SHOW_SUBSCRIBER	= 'https://api.twitter.com/1/lists/subscribers/show.json';
	const URL_REMOVE_SUBCRIBER	= 'https://api.twitter.com/1/lists/subscribers/destroy.json';
	const URL_CREATE_ALL		= 'https://api.twitter.com/1/lists/members/create_all.json';
	const URL_GET_MEMBER		= 'https://api.twitter.com/1/lists/members/show.json';
	const URL_GET_DETAIL		= 'https://api.twitter.com/1/lists/members.json';
	const URL_CREATE_MEMBER		= 'https://api.twitter.com/1/lists/members/create.json';
	const URL_REMOVE_MEMBER		= 'https://api.twitter.com/1/lists/members/destroy';
	const URL_UPDATE			= 'https://api.twitter.com/lists/update.json';
	const URL_CREATE_USER		= 'https://api.twitter.com/1/lists/create.json';
	const URL_GET_LISTS			= 'https://api.twitter.com/1/lists.json';
	const URL_SHOW				= 'https://api.twitter.com/1/lists/show.json';
	const URL_GET_SUBSCRITION	= 'https://api.twitter.com/1/lists/subscriptions.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/	
	protected $_since		= NULL;
	protected $_max			= 0;
	protected $_perpage		= 0;
	protected $_cursor		= -1;
	protected $_entities	= false;
	protected $_rts			= false;
	protected $_filter		= false;
	protected $_status		= false;
	protected $_count		= 0;
	
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
	 * Add a member to a list. The authenticated user 
	 * must own the list to be able to add members 
	 * to it. Note that lists can't have more than 500 members.
	 *
	 * @param int|string user ID or screen name
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function addMember($userId, $listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string')				//Argument 2 must be an integer or string
			->argument(3, 'int', 'string', 'null');		//Argument 3 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$query['user_id'] = $user_id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $user_id;
		}
		
		return $this->_post(self::URL_CREATE_MEMBER, $query);
	}
	
	/**
	 * Adds multiple members to a list, by specifying a 
	 * comma-separated list of member ids or screen names. 
	 *
	 * @param int|string list ID or slug
	 * @param array list of user IDs
	 * @param int|string ownder ID or screen name
	 * @return array
	 */
	public function addMembers($listId, $userIds, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'array')						//Argument 2 must be an array
			->argument(3, 'int', 'string');				//Argument 3 must be an integer or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		//if it is integer
		if(is_int($ownerId)) {
			//lets put it in our query
			$query['owner_id'] = $ownerId;
		//else it is string
		} else {
			//lets put it in our query
			$query['owner_screen_name'] = $ownerId;
		}
		
		//if id is integer
		if(is_int($userIds[0])) {
			//lets put it in query
			$query['user_id'] = implode(',',$userIds);
		//if it is streing
		} else {
			//lets put it in query
			$query['screen_name'] = implode(',',$userIds);
		}
		
		return $this->_post(self::URL_CREATE_ALL, $query);
	}
	
	/**
	 * Creates a new list for the authenticated user.
	 * Note that you can't create more than 20 lists per account.
	 *
	 * @param string 
	 * @param string|null
	 * @param bool
	 * @return array
	 */
	public function createList($name, $description = NULL, $public = true) {
		Eden_Twitter_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null')
			->argument(3, 'bool');			
			
		$query = array('name' => $name);
		
		if($description) {
			$query['description'] = $description;
		}
		
		if(!$public) {
			$query['mode'] = 'private';
		}
		
		return $this->_post(self::URL_CREATE_USER, $query);
	}
	
	/**
	 * Returns the members of the specified list. 
	 * Private list members will only be shown if 
	 * the authenticated user owns the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function getMembers($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}	
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		if($this->_cursor != -1) {
			$query['cursor'] = $this->_cursor;
		}	
		
		return $this->_getResponse(self::URL_GET_DETAIL, $query);
	}
	
	/**
	 * Returns all lists the authenticating or specified user 
	 * subscribes to, including their own.
	 *
	 * @return array
	 */
	public function getAllLists() {
		//populate fields
		$query = array(
			'user_id'		=> $this->_id,
			'screen_name'	=> $this->_name);
			
		return $this->_getResponse(self::URL_ALL_LIST, $query);
	} 
	
	/**
	 * Returns the lists of the specified (or authenticated) 
	 * user. Private lists will be included if the 
	 * authenticated user is the same as the user whose
	 * lists are being returned.
	 *
	 * @param int
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
			'screen_name'	=> $name);
		
		if($this->_cursor != -1) {
			$query['cursor'] = $this->_cursor;
		}
		
		return $this->_getResponse(self::URL_GET_LISTS, $query);
	}
	
	/**
	 * Returns the specified list. Private lists will only 
	 * be shown if the authenticated user owns the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function getList($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_getResponse(self::URL_SHOW, $query);
	}
	
	/**
	 * Returns the lists the specified user has been 
	 * added to. If user_id or screen_name are not 
	 * provided the memberships for the authenticating 
	 * user are returned.
	 *
	 * @param int|string|null user ID or screen name
	 * @return array
	 */
	public function getMemberships($id = NULL) {
		//Argument 1 must be an integer, null or string
		Eden_Twitter_Error::i()->argument(1, 'int', 'string', 'null');
		
		$query = array();
		
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in our query
				$query['user_id'] = $id;
			//else it is string
			} else {
				//lets put it in our query
				$query['screen_name'] = $id;
			}
		}
		
		if($this->_cursor != -1) {
			$query['cursor'] = $this->_cursor;
		}
		
		if($this->_filter) {
			$query['filter_to_owned_lists'] = 1;
		}
		
		return $this->_getResponse(self::URL_MEMBERSHIP, $query);
	}
	 
	/**
	 * Returns tweet timeline for members
	 * of the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function getTweets($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}	
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_rts) {
			$query['include_rts'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_perpage) {
			$query['per_page'] = $this->_perpage;
		}
		
		return $this->_getResponse(self::URL_GET_STATUS, $query);
	}
	 
	/**
	 * Returns the subscribers of the specified list. Private list 
	 * subscribers will only be shown if the authenticated user owns 
	 * the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function getSubscribers($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}	
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		if($this->_cursor != -1) {
			$query['cursor'] = $this->_cursor;
		}
		
		return $this->_getResponse(self::URL_SUBSCRIBER,$query);
	}
	
	/**
	 * Obtain a collection of the lists the specified user is subscribed to, 
	 * 20 lists per page by default. Does not include the user's own lists.
	 *
	 * @param int|string user ID or screen name
	 * @return array
	 */
	public function getSubscriptions($id) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1, 'int', 'string');	
		
		$query = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
		
		if($this->_cursor != -1) {
			$query['cursor'] = $this->_cursor;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_GET_SUBSCRITION, $query);
	}
	
	/**
	 * Will return just lists the authenticating user owns, and the user 
	 * represented by user_id or screen_name is a member of.
	 *
	 * @return this
	 */
	public function filterToOwn() {
		$this->_filter = true;
		return $this;
	}
	
	/**
	 * Each tweet will include a node called "entities". This node offers a variety 
	 * of metadata about the tweet in a discreet structure, including: user_mentions, 
	 * urls, and hashtags. 
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_entities = true;
		return $this;
	}
	
	/**
	 * The list timeline will contain native retweets (if they exist) in addition to the 
	 * standard stream of tweets. The output format of retweeted tweets is identical to 
	 * the representation you see in home_timeline.
	 *
	 * @return this
	 */
	public function includeRts() {
		$this->_rts = true;
		return $this;
	}
	
	/**
	 * Check if the specified user is a member of the specified list.
	 *
	 * @param int|string user ID or screen name
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function isMember($userId, $listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string')				//Argument 2 must be an integer or string
			->argument(3, 'int', 'string', 'null');		//Argument 3 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$query['user_id'] = $user_id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $user_id;
		}		
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_GET_MEMBER, $query);
	}
	
	/**
	 * Check if the specified user is a subscriber of the specified list. 
	 * Returns the user if they are subscriber.
	 *
	 * @param int|string user ID or screen name
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function isSubsciber($userId, $listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string')				//Argument 2 must be an integer or string
			->argument(3, 'int', 'string', 'null');		//Argument 3 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$query['user_id'] = $user_id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $user_id;
		}		
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_status) {
			$query['skip_status'] = 1;
		}
		
		return $this->_getResponse(self::URL_SHOW_SUBSCRIBER, $query);
	}
	
	/**
	 * Deletes the specified list. The authenticated 
	 * user must own the list to be able to destroy it
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function remove($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}	
			
		return $this->_post(self::URL_REMOVE,$query);
	}
	
	/**
	 * Removes the specified member from the list. 
	 * The authenticated user must be the list's 
	 * owner to remove members from the list.
	 *
	 * @param int|string user ID or screen name
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function removeMember($userId, $listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string')				//Argument 2 must be an integer or string
			->argument(3, 'int', 'string', 'null');		//Argument 3 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$query['user_id'] = $ownerId;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $ownerId;
		}
		
		return $this->_post(self::URL_REMOVE_MEMBER, $query);
	}
	
	/**
	 * Sets count
	 *
	 * @param integer
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_count = $count;
		return $this;
	}
	
	/**
	 * Causes the list of connections to be broken into pages of no more than 5000 
	 * IDs at a time. The number of IDs returned is not guaranteed to be 5000 as 
	 * suspended users are filtered out after connections are queried. 
	 *
	 * @param string
	 * @return this
	 */
	public function setCursor($cursor) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_cursor = $cursor;
		return $this;
	}
	
	/**
	 * Set max id
	 *
	 * @param integer
	 * @return this
	 */
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_max = $max;
		return $this;
	}
	
	/**
	 * Sets page
	 *
	 * @param integer
	 * @return this
	 */
	public function setPage($perpage) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_perpage = $perpage;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param integer the tweet ID
	 * @return array
	 */
	public function setSince($since) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Statuses will not be included in the returned user objects.
	 *
	 * @return this
	 */
	public function skipStatus() {
		$this->_status = true;
		return $this;
	}
	
	/**
	 * Subscribes the authenticated 
	 * user to the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function subscribe($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string			
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_post(self::URL_CREATE_SUBCRIBER, $query);
	}
	
	/**
	 * Unsubscribes the authenticated 
	 * user from the specified list.
	 *
	 * @param int|string list ID or slug
	 * @param int|string|null owner ID or screen name
	 * @return array
	 */
	public function unsubscribe($listId, $ownerId = NULL) {
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string')				//Argument 1 must be an integer or string
			->argument(2, 'int', 'string', 'null');		//Argument 2 must be an integer, null or string
		
		$query = array();
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_post(self::URL_REMOVE_SUBCRIBER, $query);
	}
	
	/**
	 * Updates the specified list. The authenticated user must own 
	 * the list to be able to update it.
	 *
	 * @param int|string list ID or slug
	 * @param string
	 * @param string
	 * @param int|string|null owner ID or screen name
	 * @param bool
	 * @return array
	 */
	public function update($listId, $name, $description, $ownerId = NULL, $public = true) {
		Eden_Twitter_Error::i()
		->argument(1, 'int', 'string')			//Argument 1 must be an integer or string
		->argument(2, 'string')					//Argument 2 must be an string
		->argument(3, 'string')					//Argument 3 must be an string
		->argument(4, 'int', 'string', 'null')	//Argument 4 must be an integer, string or null			
		->argument(5, 'bool');					//Argument 3 must be an boolean
		$query = array(
			'name'				=> $name,
			'description'		=> $description);
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$query['owner_screen_name'] = $ownerId;
			}
		}
		
		if(!$public) {
			$query['mode'] = 'private';
		}
		
		return $this->_post(self::URL_UPDATE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}