<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square tips
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Tips extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_TIPS_ADD 			= 'https://api.foursquare.com/v2/tips/add';
	const URL_TIPS_SEARCH 		= 'https://api.foursquare.com/v2/tips/search';
	const URL_TIPS_GET	 		= 'https://api.foursquare.com/v2/tips/%s/done';
	const URL_TIPS_LIST	 		= 'https://api.foursquare.com/v2/tips/%s/listed';
	const URL_TIPS_MARK_DONE	= 'https://api.foursquare.com/v2/tips/%s/markdone';
	const URL_TIPS_MARK_TODO	= 'https://api.foursquare.com/v2/tips/%s/marktodo';
	const URL_TIPS_UNMARK		= 'https://api.foursquare.com/v2/tips/%s/unmark';
	
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
	 * Set location by setting longtitide 
	 * and latitude
	 * 
	 * @param int|float
	 * @param int|float
	 * @return this
	 */
	public function setLocation($longtitude, $latitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'int', 'float')	//argument 1 must be an integer or float
			->argument(2, 'int', 'float');	//argument 2 must be an integer or float
			
		$this->_query['ll'] =$longtitude.', '.$latitude; 
		
		return $this;
	}
	
	/**
	 * Number of results to return, up to 50.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument 1 must be a integer
		Eden_Foursquare_Error::i()->argument(1, 'int');			
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * If set to friends, only show nearby tips from friends.
	 * 
	 * @param string
	 * @return this
	 */
	public function setFilter($filter) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['filter'] = $filter;
		
		return $this;
	}
	
	/**
	 * Only find tips matching the given term, cannot be used in 
	 * conjunction with friends filter.
	 * 
	 * @param string
	 * @return this
	 */
	public function setQuery($query) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['query'] = $query;
		
		return $this;
	}
	
	/**
	 * Whether to broadcast this tip. Send twitter if you want to 
	 * send to twitter, facebook if you want to send to facebook, 
	 * or twitter,facebook if you want to send to both.
	 * 
	 * @param string
	 * @return this
	 */
	public function broadcast($broadcast) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		
		//if the input value is not allowed
		if(!in_array($broadcast, array('facebook', 'twitter', 'followers'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_BROADCAST_TIPS) 
				->addVariable($broadcast)
				->trigger();
		}
		
		$this->_query['broadcast'] = $broadcast;
		
		return $this;
	}
	
	/**
	 * Can be created, edited, followed, friends, other. If no 
	 * acting user is present, only other is supported.
	 * 
	 * @param string
	 * @return this
	 */
	public function setGroup($group) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		
		//if the input value is not allowed
		if(!in_array($group, array('created', 'edited', 'followed', 'friends', 'other'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_GROUP) 
				->addVariable($broadcast)
				->trigger();
		}
		
		$this->_query['group'] = $group;
		
		return $this;
	}
	
	/**
	 * Check in to a place. 
	 * 
	 * @param string The venue where the user is checking in
	 * @param string The text of the tip, up to 200 characters.
	 * @return array
	 */
	public function checkin($venueId, $text) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['text'] 		= $text;
		$this->_query['venueId']	= $venueId;
		
		return $this->_post(self::URL_TIPS_ADD, $this->_query);
	}	
	
	/**
	 * Returns a list of tips near the area specified. 
	 * 
	 * @param string The venue where the user is checking in
	 * @return array
	 */
	public function search($near) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
				
		$this->_query['near'] = $near;
		
		return $this->_post(self::URL_TIPS_SEARCH, $this->_query);
	}
	
	/**
	 * Returns an array of users have done this tip.
	 * 
	 * @param string Identity of a tip to get users who have marked the tip as done.
	 * @return array
	 */
	public function getTips($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_TIPS_GET, $tipId), $this->_query);
	}
	
	/**
	 * Returns lists that this tip appears on
	 * 
	 * @param string Identity of a tip to get lists for.
	 * @return array
	 */
	public function getTipsList($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['_group'] = $_group;
		
		return $this->_post(sprintf(self::URL_TIPS_LIST, $tipId), $this->_query);
	}
	
	/**
	 * Allows the acting user to mark a tip done.
	 * 
	 * @param string The tip you want to mark done.
	 * @return array
	 */
	public function markDone($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_post(sprintf(self::URL_TIPS_MARK_DONE, $tipId));
	}
	
	/**
	 * Allows you to mark a tip to-do. 
	 * 
	 * @param string The tip you want to mark done.
	 * @return array
	 */ 
	public function markToDo($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_post(sprintf(self::URL_TIPS_MARK_TODO, $tipId));
	}
	
	/**
	 * Allows you to remove a tip from your to-do list or done list. 
	 * 
	 * @param string The tip you want to mark done.
	 * @return array
	 */
	public function unmark($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_post(sprintf(self::URL_TIPS_UNMARK, $tipId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}