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
	protected $_rpp			= NULL;
	protected $_until		= NULL;
	protected $_since		= NULL;		
	protected $_show		= false;
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
	 * Set result
	 *
	 * @param string
	 * @return this
	 */
	public function setResult($result) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		//if result is a string
			if(is_string($result)) {
				//lets make it an array
				$result = explode(',', $result);
			}
			
			//at this point result will be an array
			$results = array();
			//for each result
			foreach($result as $event) {
				//if this result is a valid result
				if(in_array($result, $this->_validResult)) {
					//lets add this to our valid resulr list 
					$results[] = $event;
				}
			}
			
			//if we have at least one valid result
			if(!empty($results)) {
				//lets make results into a string
				$result = implode(',', $result);
				//and add to query
				$this->_result = $result;		
			}
			
		return $this;
	}
	
	/**
	 * Set rpp
	 *
	 * @param string
	 * @return this
	 */
	public function setRpp($rpp) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_rpp = $rpp;
		return $this;
	}
	
	/**
	 * Set until
	 *
	 * @param string
	 * @return this
	 */
	public function setUntil($until) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$until = date('Y-m-d', $until);
		$this->_until = $until;
		return $this;
	}
	
	/**
	 * Set since id
	 *
	 * @param string
	 * @return this
	 */
	public function setSince($since) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_since = $since;
		return $this;
	}
	
	/**
	 * Set show user
	 *
	 * @return this
	 */
	public function setShow() {
		$this->_show = true;
		return $this;
	}
	
	/**
	 * Set include entites
	 *
	 * @return this
	 */
	public function setEntities() {
		$this->_entities = true;
		return $this;
	}
	
	/**
	 * Returns tweets that match a specified query
	 *
	 * @param string|integer
	 * @return array
	 */
	public function search($search) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'integer');

		$query = array(
			'q' 				=> $search,
			'callback'			=> $this->_callback,
			'geocode'			=> $this->_geocode,
			'lang'				=> $this->_lang,
			'locale'			=> $this->_locale,
			'page'				=> $this->_page,
			'result_type'		=> $this->_result,
			'rpp'				=> $this->_rpp,
			'show_user'			=> $this->_show,
			'until'				=> $this->_until,
			'since_id'			=> $this->_since,
			'include_entities'	=> $this->_entities);
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}