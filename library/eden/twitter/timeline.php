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
	 * @return this
	 */
	public function addContributorDetail() {
		$this->_query['contributor_details'] = true;
		
		return $this;
	}
	
	/**
	 * Set exclude replies
	 *
	 * @return this
	 */
	public function excludeReplies() {
		$this->_query['exclude_replies'] = true;
		
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
			return $this->_getResponse(self::URL_BY_USER, $this->_query);
		} 
		
		return $this->_getResponse(self::URL_BY_ME, $this->_query);
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
		
		return $this->_getResponse(self::URL_USER, $this->_query);
	}
	 
	/**
	 * Returns the 20 most recent mentions (status containing @username)
	 * for the authenticating user 
	 *
	 * @return array
	 */
	public function getMentions() {
		
		return $this->_getResponse(self::URL_MENTION, $this->_query);
	}
	
	/**
	 * Returns the 20 most recent tweets of the authenticated 
	 * user that have been retweeted by others.
	 *
	 * @return array
	 */
	public function getRetweeted() {
		
		return $this->_getResponse(self::URL_OF_ME, $this->_query);
	}
	 
	/**
	 * Returns the 20 most recent statuses, including  
	 * retweets if they exist.
	 *
	 * @return array
	 */
	public function getAllTweets() {
		
		return $this->_getResponse(self::URL_PUBLIC, $this->_query);
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
		
		return $this->_getResponse(self::URL_TIMELINE, $this->_query);
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
		
			return $this->_getResponse(self::URL_TO_USER, $this->_query);
		} 
		
		return $this->_getResponse(self::URL_TO_ME, $this->_query);
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
	 * Set count
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
	 * Set max id
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxId($maxId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['max_id'] = $maxId;
		
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
	 * Set since id
	 *
	 * @param integer
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $sinceId;
		
		return $this;
	}
	
	/**
	 * Set trim user
	 *
	 * @return this
	 */
	public function trimUser() {
		$this->_query['trim_user'] = true;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}