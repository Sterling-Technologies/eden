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
	const URL_SEARCH	= 'http://search.twitter.com/search.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_validResult = array('mixed', 'recent', 'popular');
	
	protected $_callback	= NULL;
	protected $_geocode		= NULL;
	protected $_lang		= NULL;
	protected $_locale		= NULL;
	protected $_page		= NULL;
	protected $_result		= NULL;
	protected $_rpp			= 25;
	protected $_until		= NULL;
	protected $_since		= 0;		
	protected $_show		= 0;
	protected $_entities	= false;
	
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
	 * Returns tweets that match a specified query
	 *
	 * @param string|integer
	 * @return array
	 */
	public function search($search) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'integer');
		
		$query = array('q' => $search);
		
		if($this->_callback) {
			$query['callback'] = $this->_callback;
		}
		
		if($this->_geocode) {
			$query['geocode'] = $this->_geocode;
		}
		
		if($this->_lang) {
			$query['lang'] = $this->_lang;
		}
		
		if($this->_locale) {
			$query['locale'] = $this->_locale;
		}
		
		if($this->_page) {
			$query['page'] = $this->_page;
		}
		
		if($this->_result) {
			$query['result_type'] = $this->_result;
		}
		
		if($this->_rpp) {
			$query['rpp'] = $this->_rpp;
		}
		
		if($this->_show) {
			$query['show_user'] = $this->_show;
		}
		
		if($this->_until) {
			$query['until'] = $this->_until;
		}
		
		if($this->_since) {
			$query['since_id'] = $this->_since;
		}
		
		if($this->_entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_SEARCH, $query);
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
		
		$this->_callback = $callback;
		return $this;
	}
	
	/**
	 * Set include entites
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_entities = true;
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
		
		$this->_geocode = $geocode;
		return $this;
	}
	
	/**
	 * Set lang
	 *
	 * @param string
	 * @return this
	 */
	public function setLang($lang) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_lang = $lang;
		return $this;
	}
	
	/**
	 * Set locale
	 *
	 * @param string
	 * @return this
	 */
	public function setLocale($locale) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_locale = $locale;
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
		
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * Set mixed result
	 *
	 * @return this
	 */
	public function setMixedResultType() {
		$this->_result = 'mixed';
		return $this;
	}
	
	/**
	 * Set recent result
	 *
	 * @return this
	 */
	public function setRecentResultType() {
		$this->_result = 'recent';
		return $this;
	}
	
	/**
	 * Set populat result
	 *
	 * @return this
	 */
	public function setPopularResultType() {
		$this->_result = 'popular';
		return $this;
	}
	
	/**
	 * Set rpp
	 *
	 * @param int The number of tweets to return per page, up to a max of 100
	 * @return this
	 */
	public function setRpp($rpp) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		if($this->_rpp > 100) {
			$this->_rpp = 100;
		}
		
		$this->_rpp = $rpp;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param int
	 * @return this
	 */
	public function setSince($since) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set show user
	 *
	 * @return this
	 */
	public function showUser() {
		$this->_show = true;
		return $this;
	}
	
	/**
	 * Set until
	 *
	 * @param string|int unix time for date format
	 * @return this
	 */
	public function setUntil($until) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($until)) {
			$until = strtotime($until);
		}
		
		$until = date('Y-m-d', $until);
		$this->_until = $until;
		return $this;
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}