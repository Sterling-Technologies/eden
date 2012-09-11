<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter timelines v1.1
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_Timeline extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/	
	const URL_TIMELINES_MENTION		= 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
	const URL_TIMELINES_USER		= 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	const URL_TIMELINES_HOME		= 'https://api.twitter.com/1.1/statuses/home_timeline.json';
	
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
	 * Returns the 20 most recent mentions (status containing @username) 
	 * for the authenticating user. The timeline returned is the equivalent <br />
	 * of the one seen when you view your mentions on twitter.com.
	 *
	 * @return array
	 */
	public function getMentionTimeline() {
	
		return $this->_getResponse(self::URL_TIMELINES_MENTION, $this->_query);
	}
	
	/**
	 * Returns a collection of the most recent Tweets posted by the user indicated by
	 * the screen_name or user_id parameters.
	 *
	 * @param string|integer|null user_id or screen_name
	 * @return array
	 */
	public function getUserTimelines($id = NULL) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');
		
		//if id is integer
		if(is_int($id)) {
			//set it as user id
			$this->_query['user_id'] = $id;
		//else it is string
		} else {
			//set it as screen name
			$this->_query['screen_name'] = $id;
		}
		
		return $this->_getResponse(self::URL_TIMELINES_USER, $this->_query);
	}
	
	/**
	 * Returns a collection of the most recent Tweets and retweets posted by 
	 * the authenticating user and the users they follow. 
	 *
	 * @return array
	 */
	public function getYourTimeLine() {
	
		return $this->_getResponse(self::URL_TIMELINES_MENTION, $this->_query);
	}
	
	/**
	 * Returns results with an ID greater than (that is, 
	 * more recent than) the specified ID. 
	 *
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');		
		$this->_query['since_id'] = $sinceId;
	
		return $this;
	}
	
	/**
	 * Specifies the number of tweets to try and retrieve, up to a 
	 * maximum of 200 per distinct request
	 *
	 * @param string
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');		
		$this->_query['count'] = $count;
	
		return $this;
	}
	
	/**
	 * Specifies the number of tweets to try and retrieve, up to a 
	 * maximum of 200 per distinct request
	 *
	 * @param string
	 * @return this
	 */
	public function setMaxId($maxId) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');		
		$this->_query['max_id'] = $maxId;
	
		return $this;
	}
	
	/**
	 * When set to either true, t or 1, each tweet returned in a timeline will include 
	 * a user object including only the status authors numerical ID
	 *
	 * @return this
	 */
	public function trimUser() {		
		$this->_query['trim_user'] = true;
	
		return $this;
	}
	
	/**
	 * This parameter will prevent replies from appearing in the returned timeline
	 *
	 * @return this
	 */
	public function excludeReplies() {		
		$this->_query['exclude_replies'] = true;
	
		return $this;
	}
	
	/**
	 * This parameter enhances the contributors element of the status response to
	 * include the screen_name of the contributor
	 *
	 * @return this
	 */
	public function setContributorDetails() {		
		$this->_query['contributor_details'] = true;
	
		return $this;
	}
	
	/**
	 * When set to false, the timeline will strip any native retweets
	 *
	 * @return this
	 */
	public function includeRts() {		
		$this->_query['include_rts'] = false;
	
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}