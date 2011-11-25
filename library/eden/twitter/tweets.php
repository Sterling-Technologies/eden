<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Twitter_Tweets extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_WHO_RETWEETED				= 'https://api.twitter.com/1/statuses/%s/retweeted_by.json';
	const URL_GET_WHO_RETWEETED_IDS 	= 'https://api.twitter.com/1/statuses/%d/retweeted_by/ids.json';
	const URL_GET_RETWEETS 				= 'https://api.twitter.com/1/statuses/retweets/%s.json';
	const URL_GET_LIST 					= 'https://api.twitter.com/1/statuses/show.json';
	const URL_REMOVE 					= 'http://api.twitter.com/1/statuses/destroy/%s.json';
	const URL_RETWEET 					= 'http://api.twitter.com/1/statuses/retweet/%d.json';
	const URL_UPDATE 					= 'https://api.twitter.com/1/statuses/update.json';
	const URL_UPDATE_MEDIA 				= 'https://upload.twitter.com/1/statuses/update_with_media.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($key, $secret) {
		return self::_getMultiple(__CLASS__, $key, $secret);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Show user objects of up to 100 members 
	 * who retweeted the status. 
	 *
	 * @param id is integer.
	 * @param count is integer.
	 * @param page is integer
	 * @return $this
	 */
	 public function getWhoRetweeted($id, $count = NULL, $page = NULL) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'int');						//Argument 3 must be an integer

		$query = array();
		//if it is not empty and not up to a maximum of 100
		if(!is_null($count) && $count <= 100) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $count;
		}
		$url = sprintf(self::URL_WHO_RETWEETED, $id);
		return $this->_post($url, $query);
	 }
	 /**
	 * Show user ids of up to 100 users who retweeted the status.   
	 *
	 * @param id is integer.
	 * @param count is integer.
	 * @param page is integer
	 * @param stringify is boolean
	 * @return $this
	 */
	 public function getWhoRetweetedIds($id, $count = NULL, $page = NULL, $stringify = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'int')						//Argument 3 must be an integer
			->argument(4, 'bool');						//Argument 4 must be a boolean

		$query = array();
		//if it is not empty and not up to a maximum of 100
		if(!is_null($count) && $count <= 100) {
			//lets put it in query
			$query['count'] = $count;
		}
		//if it is not empty
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $count;
		}
		//if stringify
		if($stringify) {

			$query['stringify_ids'] = 1;
		}
		
		$url = sprintf(self::URL_GET_WHO_RETWEETED_IDS, $id);
		return $this->_post($url, $query);
	 }
	 /**
	 * Returns up to 100 of the first retweets of a given tweet.   
	 *
	 * @param id is integer
	 * @param count is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getRetweets($id, $count = NULL, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'int')						//Argument 2 must be an integer
			->argument(3, 'bool')						//Argument 3 must be an boolean
			->argument(4, 'bool');						//Argument 4 must be an boolean
			
		$query = array('id' => $id);
		//if count is not empty and less than equal to 100
		if(!is_null($count) && $count <= 100) {
			//Lets put it in query
			$query['count'] = $count;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		$url = sprintf(self::URL_GET_RETWEETS, $id);
		return $this->_post($url, $query);
	 }
	 /**
	 * Returns a single status, specified by the id parameter below.    
	 * The status's author will be returned inline.
	 *
	 * @param id is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getDetail($id, $trim = false, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'bool')						//Argument 2 must be an boolean
			->argument(3, 'bool');						//Argument 3 must be an boolean
			
		$query = array('id' => $id);
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}

		return $this->_getResponse(self::URL_GET_LIST, $query);
	 }
	 /**
	 * Destroys the status specified by the required ID parameter. 
	 * The authenticating user must be the author of the specified  .
	 * status. Returns the destroyed status if successful.
	 *
	 * @param id is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function remove($id, $entities = false, $trim = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'bool')						//Argument 2 must be an boolean
			->argument(3, 'bool');						//Argument 3 must be an boolean
			
		$query = array();
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}

		$url = sprintf(self::URL_REMOVE, $id);
		return $this->_post($url,$query);
	 }
	 /**
	 * Retweets a tweet. Returns the original tweet 
	 * with retweet details embedded
	 *
	 * @param id is integer
	 * @param trim is boolean
	 * @param entities is boolean
	 * @return $this
	 */
	 public function retweet($id, $entities = false, $trim = false) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'bool')						//Argument 2 must be an boolean
			->argument(3, 'bool');						//Argument 3 must be an boolean
			
		$query = array();
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		$url = sprintf(self::URL_RETWEET, $id);
		return $this->_post($url, $query);
	 }
	 /**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param status is integer
	 * @param reply is string
	 * @param lat is float
	 * @param long is float
	 * @param place is string or integer
	 * @param display is boolean
	 * @param trim is boolean
	 * @param entities is boolean
	 * @param wrap is boolean
	 * @return $this
	 */
	 public function update($status, $reply = NULL, $lat = NULL, $long = NULL, $place = NULL, $display = NULL, $trim = FALSE, $entities = FALSE, $wrap = FALSE) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'string')						//Argument 2 must be a string
			->argument(3, 'float')						//Argument 3 must be a float
			->argument(4, 'float')						//Argument 4 must be a float
			->argument(5, 'string', 'int')				//Argument 5 must be an string or integer
			->argument(6, 'boolean')					//Argument 6 must be an boolean
			->argument(7, 'boolean')					//Argument 7 must be an boolean
			->argument(8, 'boolean');					//Argument 8 must be an boolean

			
		$query = array('status' => $status);
		//if reply is not empty
		if(!is_null($reply)) {
			//lets put it in query
			$query['in_reply_to_status_id '] = $reply;
		}
		//if reply is not empty
		if(!is_null($lat) && $lat >= -90.0 && $lat <= +90.0) {
			//lets put it in query
			$query ['lat'] = $lat;
		}
		//if reply is not empty
		if(!is_null($long) && $long >= -180.0 && $lat <= +180.0) {
			//lets put it in query
			$query ['long'] = $long;
		}
		//if reply is not empty
		if(!is_null($place)) {
			//lets put it in query
			$query['place_id '] = $place;
		}
		//if entities
		if($display) {
			$query['display_coordinates'] = 1;
		}
		//if trim
		if($trim) {
			$query['trim_user'] = 1;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if wrap
		if($wrap) {
			$query['wrap_links'] = 1;
		}

		return $this->_post(self::URL_UPDATE, $query);
	 }
	 /**
	 * Updates the authenticating user's status, 
	 * also known as tweeting.
	 *
	 * @param status is integer
	 * @param reply is string
	 * @param lat is float
	 * @param long is float
	 * @param place is string or integer
	 * @param display is boolean
	 * @param trim is boolean
	 * @param entities is boolean
	 * @param wrap is boolean
	 * @return $this
	 */
	 public function updateMedia($status, $media, $sensitive = NULL, $id = NULL, $lat = NULL, $long = NULL, $place = NULL, $display = NULL) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string')					//Argument 2 must be a string
			->argument(3, 'boolean')				//Argument 3 must be a boolean 
			->argument(4, 'string')					//Argument 4 must be an string
			->argument(5, 'boolean')				//Argument 5 must be an boolena
			->argument(6, 'boolean')				//Argument 6 must be an boolean
			->argument(7, 'boolean')				//Argument 7 must be an boolean
			->argument(8, 'boolean');				//Argument 8 must be an boolean

			
		$query = array('status' => $status, 'media[]' => $media);
		//if sensitive
		if($sensitive) {
			$query['possibly_sensitive'] = 1;
		}
		//if reply is not empty
		if(!is_null($id)) {
			//lets put it in query
			$query['in_reply_to_status_id'] = $id;
		}
		//if reply is not empty
		if(!is_null($lat) && $lat >= -90.0 && $lat <= +90.0) {
			//lets put it in query
			$query ['lat'] = $lat;
		}
		//if reply is not empty
		if(!is_null($long) && $long >= -180.0 && $lat <= +180.0) {
			//lets put it in query
			$query ['long'] = $long;
		}
		//if reply is not empty
		if(!is_null($place)) {
			//lets put it in query
			$query['place_id '] = $place;
		}
		//if entities
		if($display) {
			$query['display_coordinates'] = 1;
		}

		return $this->_getResponse(self::URL_UPDATE_MEDIA, $query);
	 }
	 /* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}