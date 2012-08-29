<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter tweets
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_Tweets extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_WHO_RETWEETED			= 'https://api.twitter.com/1/statuses/%s/retweeted_by.json';
	const URL_GET_WHO_RETWEETED_IDS	= 'https://api.twitter.com/1/statuses/%d/retweeted_by/ids.json';
	const URL_GET_RETWEETS 			= 'https://api.twitter.com/1/statuses/retweets/%s.json';
	const URL_GET_LIST 				= 'https://api.twitter.com/1/statuses/show.json';
	const URL_REMOVE 				= 'http://api.twitter.com/1/statuses/destroy/%s.json';
	const URL_RETWEET 				= 'http://api.twitter.com/1/statuses/retweet/%d.json';
	const URL_UPDATE 				= 'https://api.twitter.com/1/statuses/update.json';
	const URL_UPDATE_MEDIA 			= 'https://upload.twitter.com/1/statuses/update_with_media.json';

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
	 * Set display coordinates
	 *
	 * @return this
	 */
	public function displayCoordinates() {
		$this->_query['display_coordinates'] = true;
		
		return $this;
	}
		
	/**
	 * Set include entities
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/**
	 * Set possibly sensitive
	 *
	 * @return this
	 */
	public function isSensitive() {
		$this->_query['possibly_sensitive'] = true;
		
		return $this;
	}
	
	/**
	 * Returns a single status, specified by the id parameter below.    
	 * The status's author will be returned inline.
	 *
	 * @param integer
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		$this->_query['id'] = $id;
		
		return $this->_getResponse(self::URL_GET_LIST, $this->_query);
	}
	 
	/**
	 * Returns up to 100 of the first retweets of a given tweet.   
	 *
	 * @param integer
	 * @return array
	 */
	public function getRetweets($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		return $this->_getResponse(sprintf(self::URL_GET_RETWEETS, $id), $this->_query);
	}
	
	/**
	 * Show user objects of up to 100 members 
	 * who retweeted the status. 
	 *
	 * @param integer
	 * @return array
	 */
	public function getWhoRetweeted($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		return $this->_getResponse(sprintf(self::URL_WHO_RETWEETED, $id), $this->_query);
	}
	
	/**
	 * Show user ids of up to 100 users who 
	 * retweeted the status.   
	 *
	 * @param integer
	 * @return array
	 */
	public function getWhoRetweetedIds($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		return $this->_getResponse(sprintf(self::URL_GET_WHO_RETWEETED_IDS, $id), $this->_query);
	}
	
	/**
	 * Destroys the status specified by the required ID parameter. 
	 * The authenticating user must be the author of the specified  .
	 * status. Returns the destroyed status if successful.
	 *
	 * @param integer
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		return $this->_post(sprintf(self::URL_REMOVE, $id),$this->_query);
	}
	
	/**
	 * Set in reply to status id
	 *
	 * @param string
	 * @return array
	 */
	public function replyTo($reply) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['in_reply_to_status_id'] = $reply;
		
		return $this;
	}
	
	/**
	 * Retweets a tweet. Returns the original tweet 
	 * with retweet details embedded
	 *
	 * @param integer The numerical ID of the desired status.
	 * @return array
	 */
	public function retweet($tweetId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	

		return $this->_post(sprintf(self::URL_RETWEET, $tweetId), $this->_query);
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
	 * Set latitude
	 *
	 * @param float|integer
	 * @return this
	 */
	public function setLatitude($latitude) {
		//Argument 1 must be a float or integer
		Eden_Twitter_Error::i()->argument(1, 'float', 'int');
		$this->_query['lat'] = $latitude;
		
		return $this;
	}
	
	/**
	 * Set longtitude
	 *
	 * @param float|integer
	 * @return this
	 */
	public function setLongtitude($longtitude) {
		//Argument 1 must be a float or integer
		Eden_Twitter_Error::i()->argument(1, 'float', 'int');
		$this->_query['long'] = $longtitude;
		
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
	 * Set place id
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setPlaceId($placeId) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');
		$this->_query['place_id'] = $placeId;
		
		return $this;
	}
	
	/**
	 * Set stringify ids
	 *
	 * @return this
	 */
	public function stringify() {
		$this->_query['stringify_ids'] = true;
		
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
	
	/**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param string The text of your status update, typically up to 140 characters
	 * @return array
	 */
	 public function update($status) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['status'] = $status;
		
		return $this->_post(self::URL_UPDATE, $this->_query);
	}
	
	/**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param string The text of your status update
	 * @param string
	 * @return array
	 */
	 public function updateMedia($status, $media) {  
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
	
		$this->_query['media[]']	= $media;
		$this->_query['status']		= $status;
		
		return $this->_upload(self::URL_UPDATE_MEDIA, $this->_query);
	}
	
	/**
	 * Set wrap links
	 *
	 * @return this
	 */
	public function wrapLinks() {
		$this->_query['wrap_links'] = true;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/	 
}