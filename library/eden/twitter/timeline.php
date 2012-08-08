<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter timelines
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_Timeline extends Eden_Twitter_Base {
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
	protected $_count		= NULL;
	protected $_since		= NULL;
	protected $_max			= NULL;
	protected $_page		= NULL;
	protected $_trim		= NULL;
	protected $_entities	= false;
	protected $_rts			= false;
	protected $_replies		= false;
	protected $_detail		= false;
	
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
	 * Set contributors details
	 *
	 * @return array
	 */
	public function addContributorDetail() {
		$this->_detail = true;
		return $this;
	}
	
	/**
	 * Set exclude replies
	 *
	 * @return array
	 */
	public function excludeReplies() {
		$this->_replies = true;
		return $this;
	}
	
	/**
	 * Returns the 20 most recent retweets posted 
	 * by the authenticating user.
	 *
	 * @param string|int|null user ID or screen name
	 * @return array
	 */
	public function getRetweets($id = NULL) {
		//Argument 1 must be an integer, string or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'string', 'null');
		
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
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
			return $this->_getResponse(self::URL_BY_USER, $query);
		} 
		
		return $this->_getResponse(self::URL_BY_ME, $query);
	}
	
	/**
	 * Returns the 20 most recent statuses posted by the 
	 * authenticating user. It is also possible to request  
	 * another user's timeline by using the screen_name 
	 * or user_id parameter
	 *
	 * @param string|int|null user ID or screen name
	 * @return array
	 */
	public function getStatuses($id = NULL) {
		//Argument 1 must be an integer, string or null
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
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_rts) {
			$query['include_rts'] = 1;
		}
		
		if($this->_replies) {
			$query['exclude_replies'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_detail) {
			$query['contributor_details'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_USER, $query);
	}
	 
	/**
	 * Returns the 20 most recent mentions (status containing @username)
	 * for the authenticating user 
	 *
	 * @return array
	 */
	public function getMentions() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_rts) {
			$query['include_rts'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_detail) {
			$query['contributor_details'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_MENTION, $query);
	}
	
	/**
	 * Returns the 20 most recent tweets of the authenticated 
	 * user that have been retweeted by others.
	 *
	 * @return array
	 */
	public function getRetweeted() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_OF_ME, $query);
	}
	 
	/**
	 * Returns the 20 most recent statuses, including  
	 * retweets if they exist.
	 *
	 * @return array
	 */
	public function getAllTweets() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		return $this->_getResponse(self::URL_PUBLIC, $query);
	}
	
	/**
	 * Returns the 20 most recent statuses, including retweets 
	 * if they exist, posted by the authenticating user and 
	 * the user's they follow. This is the same timeline seen
	 * by a user when they login to twitter.com.
	 *
	 * @return array
	 */
	public function getTimeline() {
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_rts) {
			$query['include_rts'] = 1;
		}
		
		if($this->_replies) {
			$query['exclude_replies'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_detail) {
			$query['contributor_details'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
		return $this->_getResponse(self::URL_TIMELINE, $query);
	}
	
	/**
	 * Returns the 20 most recent retweets posted by 
	 * users the authenticating user follow
	 *
	 * @param string|int|null user ID or screen name
	 * @return array
	 */
	public function getFollowingRetweets($id = NULL) {
		//Argument 1 must be an integer, string or null
		Eden_Twitter_Error::i()->argument(1, 'int', 'string', 'null');
		
		$query = array();
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		if($this->_trim) {
			$query['trim_user'] = 1;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_max) {
			$query['max_id'] = $this->_max;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_count) {
			$query['count'] = $this->_count;
		}
		
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
		
			return $this->_getResponse(self::URL_TO_USER, $query);
		} 
		
		return $this->_getResponse(self::URL_TO_ME, $query);
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
	 * Set count
	 *
	 * @param integer
	 * @return array
	 */
	public function setCount($count) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_count = $count;
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
	 * Set trim user
	 *
	 * @return array
	 */
	public function trimUser() {
		$this->_trim = true;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}