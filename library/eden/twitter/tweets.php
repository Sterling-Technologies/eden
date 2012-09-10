<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter tweets v1.1
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_Tweets extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_TWEETS_GET_RETWEET	= 'https://api.twitter.com/1.1/statuses/retweets/%s.json';
	const URL_TWEETS_GET_TWEET		= 'https://api.twitter.com/1.1/statuses/show.json';
	const URL_TWEETS_REMOVE_TWEET	= 'https://api.twitter.com/1.1/statuses/destroy/%s.json';
	const URL_TWEETS_TWEET			= 'https://api.twitter.com/1.1/statuses/update.json';
	const URL_TWEETS_RETWEET		= 'https://api.twitter.com/1.1/statuses/retweet/%s.json'; 
	const URL_TWEETS_TWEET_MEDIA	= 'https://api.twitter.com/1.1/statuses/update_with_media.json';
	
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
	 * Returns up to 100 of the first retweets of a given tweet.
	 *
	 * @param string|int The numerical ID of the desired status
	 * @return array
	 */
	public function getRetweet($id) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');
	
		return $this->_getResponse(sprintf(self::URL_TWEETS_GET_RETWEET, $id), $this->_query);
	}
	
	/**
	 * Returns a single Tweet, specified by the id parameter. The Tweet's author will 
	 * also be embedded within the tweet.
	 *
	 * @param string|int The numerical ID of the desired Tweet.
	 * @return array
	 */
	public function getTweet($id) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');
		
		$this->_query['id'] = $id;
		
		return $this->_getResponse(self::URL_TWEETS_GET_TWEET, $this->_query);
	}
	
	/**
	 * Destroys the status specified by the required ID parameter. The authenticating 
	 * user must be the author of the specified status. Returns the destroyed status if successful.
	 *
	 * @param string|int The numerical ID of the desired status.
	 * @return array
	 */
	public function removeTweet($id) {
		//Argument 1 must be an integer or string
		Eden_Twitter_Error::i()->argument(1,'int', 'string');
	
		return $this->_post(sprintf(self::URL_TWEETS_REMOVE_TWEET, $id), $this->_query);
	}
	
	/**
	 * Updates the authenticating user's current status, also known as tweeting.
	 *
	 * @param string The text of your status update, typically up to 140 characters.
	 * @return array
	 */
	public function tweet($status) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['status'] = $status;
		
		return $this->_post(self::URL_TWEETS_TWEET, $this->_query);
	}
	
	/**
	 * Retweets a tweet. Returns the original tweet with retweet details embedded.
	 *
	 * @param string The numerical ID of the desired status.
	 * @return array
	 */
	public function retweet($tweetId) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_TWEETS_RETWEET, $tweetId), $this->_query);
	}
	
	/**
	 * Updates the authenticating user's current status and attaches media for upload. 
	 * In other words, it creates a Tweet with a picture attached.
	 *
	 * @param string The text of your status update, typically up to 140 characters.
	 * @param string 
	 * @return array
	 */
	public function tweetMedia($status, $media) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_query['status']		= $status;
		$this->_query['media[]']	= $media;
		
		return $this->_upload(self::URL_TWEETS_TWEET_MEDIA, $this->_query);
	}
	
	/**
	 * The ID of an existing status that the update is in reply to.
	 *
	 * @param string
	 * @return this
	 */
	public function inReplyToStatusId($statusId) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1,'string');
		
		$this->_query['in_reply_to_status_id'] = $statusId;
		
		return $this;
	}
	
	/**
	 * The latitude of the location this tweet refers to. This parameter will be ignored 
	 * unless it is inside the range -90.0 to +90.0 (North is positive) inclusive. It will 
	 * also be ignored if there isn't a corresponding long parameter.
	 *
	 * @param float
	 * @return this
	 */
	public function setLatitude($latutide) {
		//Argument 1 must be a float
		Eden_Twitter_Error::i()->argument(1,'float');
		
		$this->_query['lat'] = $latutide;
		
		return $this;
	}
	
	/**
	 * The longitude of the location this tweet refers to. The valid ranges for longitude 
	 * is -180.0 to +180.0 (East is positive) inclusive. This parameter will be ignored if 
	 * outside that range, if it is not a number, if geo_enabled is disabled, or if there 
	 * not a corresponding lat parameter.
	 *
	 * @param float
	 * @return this
	 */
	public function setLongtitude($longtitude) {
		//Argument 1 must be a float
		Eden_Twitter_Error::i()->argument(1,'float');
		
		$this->_query['long'] = $longtitude;
		
		return $this;
	}
	
	/**
	 * A place in the world. These IDs can be retrieved from GET geo/reverse_geocode.
	 *
	 * @param string
	 * @return this
	 */
	public function setPlaceId($placeId) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1,'string');
		
		$this->_query['place_id'] = $placeId;
		
		return $this;
	}
	
	/**
	 * Specifies the number of records to retrieve. Must be less than or equal to 100.
	 *
	 * @param integer
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1,'int');
		
		//Prevent sending number greater that 100
		if($count <= 100) {
			$this->_query['count'] = $count;
		} else {
			$this->_query['count'] = 100;	
		}
		
		return $this;
	}
	
	/**
	 * When set to either true, t or 1, each tweet returned in a timeline will 
	 * include a user object including only the status authors numerical ID
	 *
	 * @return this
	 */
	public function displayCoordinates() {
		$this->_query['display_coordinates'] = true;
		
		return $this;
	}
	
	/**
	 * When set to either true, t or 1, each tweet returned in a timeline will 
	 * include a user object including only the status authors numerical ID
	 *
	 * @return this
	 */
	public function trimUser() {
		$this->_query['trim_user'] = true;
		
		return $this;
	}
		
	/**
	 * The entities node will be disincluded when set to false
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = false;
		
		return $this;
	}
	
	/**
	 * When set to either true, t or 1, any Tweets returned that have been retweeted 
	 * by the authenticating user will include an additional current_user_retweet 
	 * node, containing the ID of the source status for the retweet.
	 *
	 * @return this
	 */
	public function includeMyRetweet() {
		$this->_query['include_my_retweet'] = true;
		
		return $this;
	}
	
	/**
	 * For content which may not be suitable for every audience.
	 *
	 * @return this
	 */
	public function possiblySensitive() {
		$this->_query['possibly_sensitive'] = true;
		
		return $this;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/	 
}