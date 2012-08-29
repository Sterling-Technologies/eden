<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square checkins
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Checkins extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_CHECKINS_CREATE 			= 'https://api.foursquare.com/v2/checkins/add';
	const URL_CHECKINS_RECENT			= 'https://api.foursquare.com/v2/checkins/recent';
	const URL_CHECKINS_ADD_COMMENT		= 'https://api.foursquare.com/v2/checkins/%s/addcomment';
	const URL_CHECKINS_ADD_POST			= 'https://api.foursquare.com/v2/checkins/%s/addpost';
	const URL_CHECKINS_DELETE_COMMENT	= 'https://api.foursquare.com/v2/checkins/%s/deletecomment';
	const URL_CHECKINS_REPLY			= 'https://api.foursquare.com/v2/checkins/%s/reply';
	
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
	 * The event the user is checking in to.
	 * 
	 * @param string
	 * @return this
	 */
	public function setEventId($eventId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['eventId'] = $eventId;
		
		return $this;
	}
	
	/**
	 * Set shout
	 * 
	 * @param string
	 * @return this
	 */
	public function setShout($shout) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['shout'] = $shout;
		
		return $this;
	}
	
	/**
	 * Number of results to return, up to 50.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');		
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * The url of the homepage of the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['url'] = $url;
		
		return $this;
	}
	
	/**
	 * Set Content id.
	 * 
	 * @param string
	 * @return this
	 */
	public function setContentId($contentId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['contentId'] = $contentId;
		
		return $this;
	}
	
	/**
	 * Check in to a place. 
	 * 
	 * @param string The venue where the user is checking in
	 * @param string Who to broadcast this check-in to
	 * @return array
	 */
	public function checkin($venueId, $broadcast) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//if the input value is not allowed
		if(!in_array($broadcast, array('private', 'public', 'facebook', 'twitter', 'followers'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_BROADCAST) 
				->addVariable($broadcast)
				->trigger();
		}
		
		$this->_query['venueId'] = $venueId;
		$this->_query['broadcast'] = $broadcast;
		
		return $this->_post(self::URL_CHECKINS_CREATE, $this->_query);
	}
	
	/**
	 * Returns a list of recent checkins from friends.
	 * 
	 * @return array
	 */
	public function getRecentCheckins() {
		
		return $this->_getResponse(self::URL_CHECKINS_CHECKINS, $this->_query);
	}
	
	/**
	 * Comment on a checkin-in
	 * 
	 * @param string The ID of the checkin to add a comment to.
	 * @param string The text of the comment, up to 200 characters.
	 * @return array
	 */
	public function addComment($checkinId, $text) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['text'] = $text;
		
		return $this->_post(sprintf(self::URL_CHECKINS_ADD_COMMENT, $checkinId), $this->_query);
	}
	
	/**
	 * Post user generated content from an external app to a check-in. 
	 * This post will be accessible to anyone who can view the details of the check-in. 
	 * 
	 * @param string The ID of the checkin to add a comment to.
	 * @param string The text of the comment, up to 200 characters.
	 * @return array
	 */
	public function addPost($checkinId, $text) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['text'] = $text;
		
		return $this->_post(sprintf(self::URL_CHECKINS_ADD_POST, $checkinId), $this->_query);
	}
	
	/**
	 * Remove a comment from a checkin, if the acting user is the author or the owner of the checkin.
	 * 
	 * @param string The ID of the checkin to remove a comment from.
	 * @param string The id of the comment to remove.
	 * @return array
	 */
	public function deleteComment($checkinId, $commentId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['commentId'] = $commentId;
		
		return $this->_post(sprintf(self::URL_CHECKINS_DELETE_COMMENT, $checkinId), $this->_query);
	}
	
	/**
	 * Reply to a user about their check-in. This reply will only be visible to the owner of the check-in.  
	 * 
	 * @param string The ID of the checkin to remove a comment from.
	 * @param string The id of the comment to remove.
	 * @return array
	 */
	public function replyToCheckin($checkinId, $text) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['text'] = $text;
		
		return $this->_post(sprintf(self::URL_CHECKINS_REPLY, $checkinId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}