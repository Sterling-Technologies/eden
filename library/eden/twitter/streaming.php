<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter streaming
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Streaming extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_STREAM_PUBLIC_STATUS	= 'https://stream.twitter.com/1.1/statuses/filter.json';
	const URL_STREAM_RANDOM_STATUS	= 'https://stream.twitter.com/1.1/statuses/sample.json'; 
	const URL_STREAM_FIRE_HOSE		= 'https://stream.twitter.com/1.1/statuses/firehose.json'; 
	const URL_STREAM_USER_MESSAGE	= 'https://userstream.twitter.com/1.1/user.json';   
	const URL_STREAM_SITE			= 'https://sitestream.twitter.com/1.1/site.json';   

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
	 * Returns public statuses that match one or more filter predicates
	 *
	 * @return array
	 */
	public function streamPublicStatus() {
		
		return $this->_post(self::URL_STREAM_PUBLIC_STATUS, $this->_query);
	}
	
	/**
	 * Returns a small random sample of all public statuses. The Tweets returned by 
	 * the default access level are the same, so if two different clients connect to 
	 * this endpoint, they will see the same Tweets.
	 *
	 * @return array
	 */
	public function streamRandomStatus() {
		
		return $this->_getResponse(self::URL_STREAM_RANDOM_STATUS, $this->_query);
	}
	
	/**
	 * Returns all public statuses. Few applications require this level of access. 
	 * Creative use of a combination of other resources and various access levels 
	 * can satisfy nearly every application use case.
	 *
	 * @return array
	 */
	public function fireHose() {
		
		return $this->_getResponse(self::URL_STREAM_FIRE_HOSE, $this->_query);
	}
	
	/**
	 * Streams messages for a single user, as described in User streams.
	 *
	 * @return array
	 */
	public function streamMessage() {
		
		return $this->_getResponse(self::URL_STREAM_FIRE_HOSE, $this->_query);
	}
	
	/**
	 * Streams messages for a set of users
	 *
	 * @return array
	 */
	public function streamSite() {
		
		return $this->_getResponse(self::URL_STREAM_SITE, $this->_query);
	}
	
	/**
	 * Include messages from accounts the user follows
	 *
	 * @param integer 
	 * @return this
	 */
	public function streamWithFollowings() {
		
		$this->_query['with'] = 'followings';
		
		return $this;
	}
	
	/**
	 * By default @replies are only sent if the current user follows both the sender 
	 * and receiver of the reply. For example, consider the case where Alice follows Bob, 
	 * but Alice doesn’t follow Carol. By default, if Bob @replies Carol, Alice does not 
	 * see the Tweet. This mimics twitter.com and api.twitter.com behavior.
	 *
	 * @param integer 
	 * @return this
	 */
	public function steamWithReplies() {
		
		$this->_query['replies'] = 'all';
		
		return $this;
	}
	
	/**
	 * The number of messages to backfill. The supplied value may be an integer 
	 * from 1 to 150000 or from -1 to -150000
	 *
	 * @param integer 
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be a integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_query['count'] = $count;
		
		return $this;
	}
	
	/**
	 * Indicating the users to return statuses for in the stream
	 *
	 * @param string|array 
	 * @return this
	 */
	public function setFollow($follow) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string', 'array');
		
		//if it is array
		if(is_array($follow)) {
			$this->_query['follow'] = implode(',', $follow);	
		//else it is string
		} else {
			$this->_query['follow'] = $follow;
		}
		
		return $this;
	}
	
	/**
	 * Keywords to track. Phrases of keywords are specified by a comma-separated list. 
	 *
	 * @param string|array 
	 * @return this
	 */
	public function setTrack($track) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string', 'array');
		
		//if it is array
		if(is_array($track)) {
			$this->_query['track'] = implode(',', $track);	
		//else it is string
		} else {
			$this->_query['track'] = $track;
		}
		
		return $this;
	}
	
	/**
	 * Keywords to track. Phrases of keywords are specified by a comma-separated list. 
	 *
	 * @param string|array 
	 * @return this
	 */
	public function setLocation($locations) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string', 'array');
		
		//if it is array
		if(is_array($track)) {
			$this->_query['locations'] = implode(',', $locations);	
		//else it is string
		} else {
			$this->_query['locations'] = $locations;
		}
		
		return $this;
	}
	
	/**
	 * Specifies whether messages should be length-delimited
	 *
	 * @return this
	 */
	public function setDelimited() {
		$this->_query['delimited'] = 'length';
		
		return $this;
	}
	
	/**
	 * Specifies whether stall warnings should be delivered
	 *
	 * @return this
	 */
	public function setStallWarning() {
		$this->_query['stall_warnings'] = true;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}