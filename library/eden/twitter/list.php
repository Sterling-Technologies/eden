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
	const URL_ALL_LIST			= 'https://api.twitter.com/1.1/lists/list.json';
	const URL_GET_STATUS		= 'https://api.twitter.com/1.1/lists/statuses.json';
	const URL_REMOVE_MEMBER		= 'https://api.twitter.com/1.1/lists/members/destroy.json';
	const URL_MEMBERSHIP		= 'https://api.twitter.com/1.1/lists/memberships.json';
	const URL_SUBSCRIBER		= 'https://api.twitter.com/1.1/lists/subscribers.json';
	const URL_CREATE_SUBCRIBER	= 'https://api.twitter.com/1.1/lists/subscribers/create.json';
	const URL_SHOW_SUBSCRIBER	= 'https://api.twitter.com/1.1/lists/subscribers/show.json';
	const URL_REMOVE_SUBCRIBER	= 'https://api.twitter.com/1.1/lists/subscribers/destroy.json';
	const URL_CREATE_ALL		= 'https://api.twitter.com/1.1/lists/members/create_all.json';
	const URL_GET_MEMBER		= 'https://api.twitter.com/1.1/lists/members/show.json';
	const URL_GET_DETAIL		= 'https://api.twitter.com/1.1/lists/members.json';
	const URL_CREATE_MEMBER		= 'https://api.twitter.com/1.1/lists/members/create.json';
	const URL_REMOVE			= 'https://api.twitter.com/1.1/lists/destroy.json';
	const URL_UPDATE			= 'https://api.twitter.com/1.1/lists/update.json';
	const URL_CREATE_USER		= 'https://api.twitter.com/1.1/lists/create.json';
	const URL_SHOW				= 'https://api.twitter.com/1.1/lists/show.json';
	const URL_GET_SUBSCRITION	= 'https://api.twitter.com/1.1/lists/subscriptions.json';

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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($userId)) {
			//lets put it in our query
			$this->_query['user_id'] = $userId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $userId;
		}
		
		return $this->_post(self::URL_CREATE_MEMBER, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		//if it is integer
		if(is_int($ownerId)) {
			//lets put it in our query
			$this->_query['owner_id'] = $ownerId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['owner_screen_name'] = $ownerId;
		}
		
		//if id is integer
		if(is_int($userIds[0])) {
			//lets put it in query
			$this->_query['user_id'] = implode(',',$userIds);
		//if it is streing
		} else {
			//lets put it in query
			$this->_query['screen_name'] = implode(',',$userIds);
		}
		
		return $this->_post(self::URL_CREATE_ALL, $this->_query);
	}
	
	/**
	 * Creates a new list for the authenticated user.
	 * Note that you can't create more than 20 lists per account.
	 *
	 * @param string The name for the list.
	 * @return array
	 */
	public function createList($name) {
		//argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');			
			
		$this->_query['name'] = $name;
		
		return $this->_post(self::URL_CREATE_USER, $this->_query);
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
	
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}		
		
		return $this->_getResponse(self::URL_GET_DETAIL, $this->_query);
	}
	
	/**
	 * Returns all lists the authenticating or specified user 
	 * subscribes to, including their own.
	 *
	 * @param string|null The user is specified using the user_id or screen_name parameters. 
	 * If no user is given, the authenticating user is used.
	 * @return array
	 */
	public function getAllLists($id = NULL) {
		//Argument 2 must be an integer, null or string
		Eden_Twitter_Error::i()->argument(2, 'int', 'string', 'null');		
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_ALL_LIST, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_getResponse(self::URL_SHOW, $this->_query);
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
		
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in our query
				$this->_query['user_id'] = $id;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['screen_name'] = $id;
			}
		}
		
		return $this->_getResponse(self::URL_MEMBERSHIP, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}	
		
		return $this->_getResponse(self::URL_GET_STATUS, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}	
		
		return $this->_getResponse(self::URL_SUBSCRIBER, $this->_query);
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
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_GET_SUBSCRITION, $this->_query);
	}
	
	/**
	 * Will return just lists the authenticating user owns, and the user 
	 * represented by user_id or screen_name is a member of.
	 *
	 * @return this
	 */
	public function filterToOwn() {
		$this->_query['filter_to_owned_lists'] = true;
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
		$this->_query['include_entities'] = true;
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
		$this->_query['include_rts'] = true;
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$this->_query['user_id'] = $user_id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $user_id;
		}		
		
		
		return $this->_getResponse(self::URL_GET_MEMBER, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$query['user_id'] = $user_id;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $user_id;
		}		
		
		return $this->_getResponse(self::URL_SHOW_SUBSCRIBER, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$qthis->_uery['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}	
			
		return $this->_post(self::URL_REMOVE, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		//if it is integer
		if(is_int($user_id)) {
			//lets put it in our query
			$this->_query['user_id'] = $ownerId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['screen_name'] = $ownerId;
		}
		
		return $this->_post(self::URL_REMOVE_MEMBER, $this->_query);
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
		$this->_query['count'] = $count;
		
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
		$this->_query['cursor'] = $cursor;
		
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
		$this->_query['max_id'] = $max;
		
		return $this;
	}
	
	/**
	 * Sets page
	 *
	 * @param integer
	 * @return this
	 */
	public function setPage($perPage) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['per_page'] = $perPage;
		
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param integer the tweet ID
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $sinceId;
		
		return $this;
	}
	
	/**
	 * The description to give the list.
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be an string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	/**
	 * Whether your list is public or private. Values can be public 
	 * or private. If no mode is specified the list will be public.
	 *
	 * @return this
	 */
	public function setModeToPrivate() {
		$this->_query['mode'] = 'private';
		
		return $this;
	}
	/**
	 * Statuses will not be included in the returned user objects.
	 *
	 * @return this
	 */
	public function skipStatus() {
		$this->_query['skip_status'] = true;
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_post(self::URL_CREATE_SUBCRIBER, $this->_query);
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
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_post(self::URL_REMOVE_SUBCRIBER, $this->_query);
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
		
		$this->_query['name']			= $name;
		$this->_query['description']	= $description;
		
		//if it is integer
		if(is_int($listId)) {
			//lets put it in our query
			$this->_query['list_id'] = $listId;
		//else it is string
		} else {
			//lets put it in our query
			$this->_query['slug'] = $listId;
		}
		
		if(!is_null($ownerId)) {
			//if it is integer
			if(is_int($ownerId)) {
				//lets put it in our query
				$this->_query['owner_id'] = $ownerId;
			//else it is string
			} else {
				//lets put it in our query
				$this->_query['owner_screen_name'] = $ownerId;
			}
		}
		
		return $this->_post(self::URL_UPDATE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}