<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter search
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Search extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_SEARCH	= 'https://api.twitter.com/1.1/search/tweets.json'; 

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
	 * Returns a collection of relevant Tweets matching a specified query.
	 *
	 * @param string The tweets you want to search
	 * @return array
	 */
	public function search($query) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['q'] = $query;
		
		return $this->_getResponse(self::URL_SEARCH, $this->_query);
	}
	
	/**
	 * Set callback
	 *
	 * @param string
	 * @return this
	 */
	public function setCallback($callback) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['callback'] = $callback;
		
		return $this;
	}
	
	/**
	 * Set include entites
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/**
	 * Set geocode
	 *
	 * @param string
	 * @return this
	 */
	public function setGeocode($geocode) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['geocode'] = $geocode;
		
		return $this;
	}
	
	/**
	 * Restricts tweets to the given language, given by an ISO 639-1 code.
	 *
	 * @param string
	 * @return this
	 */
	public function setLanguage($language) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['lang'] = $language;
		
		return $this;
	}
	
	/**
	 * Specify the language of the query you are sending (only ja is currently effective). 
	 * This is intended for language-specific clients and the default should work in the
	 * majority of cases.
	 *
	 * @param string
	 * @return this
	 */
	public function setLocale($locale) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['locale'] = $locale;
		
		return $this;
	}
	
	/**
	 * The page number (starting at 1) to return, up to a max of roughly 1500 results 
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
	 * Set mixed result
	 *
	 * @return this
	 */
	public function setMixedResultType() {
		$this->_query['result_type'] = 'mixed';
		
		return $this;
	}
	
	/**
	 * Set recent result
	 *
	 * @return this
	 */
	public function setRecentResultType() {
		$this->_query['result_type'] = 'recent';
		
		return $this;
	}
	
	/**
	 * Set populat result
	 *
	 * @return this
	 */
	public function setPopularResultType() {
		$this->_query['result_type'] = 'popular';
		
		return $this;
	}
	
	/**
	 * The number of tweets to return per page, up to a max of 100.
	 *
	 * @param int 
	 * @return this
	 */
	public function setRpp($rpp) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		//if it is greater than 100
		if($rpp > 100) {
			//set it to 100
			$rpp = 100;
		}
		
		$this->_query['rpp'] = $rpp;
		
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param int
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $sinceId;
		
		return $this;
	}
	
	/**
	 * Set show user
	 *
	 * @return this
	 */
	public function showUser() {
		$this->_query['show_user'] = true;
		
		return $this;
	}
	
	/**
	 * Returns tweets generated before the given date.
	 *
	 * @param string|int unix time for date format
	 * @return this
	 */
	public function setUntil($until) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');
		
		//if it is a string
		if(is_string($until)) {
			//make it a integer date
			$until = strtotime($until);
		}
		
		//format date
		$until = date('Y-m-d', $until);
		$this->_query['until'] = $until;
		
		return $this;
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}