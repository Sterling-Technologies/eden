<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google calendar
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Shopping extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const RANGES			= ':ranges';
	const REQUEST_URL		= 'https://www.googleapis.com/shopping/search/v1/public/products';
	
	const NAME				= 'name';
	const VALUE				= 'value';
	
	const QUERY				= 'q';
	const COUNTRY			= 'country';
	const CURRENCY			= 'currency';
	const RESTRICT_BY		= 'restrictBy';
	const RANK_BY			= 'rankBy';
	const CROWD_BY			= 'crowdBy';
	const SPELLING_CHECK 	= 'spelling.enabled';
	const FACETS_ENABLED	= 'facets.enabled';
	const FACETS_INCLUDE	= 'facets.include';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_country			= NULL;
	protected $_currency		= NULL;
	protected $_restrictBy		= array();
	protected $_rankBy			= array();
	protected $_crowding		= array();
	protected $_keyword			= array();
	protected $_spellChecker	= false;
	protected $_facet			= false;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 *	Add facet
	 *
	 * @param string
	 * @param array
	 * @return this
	 */
	public function addFacet($name, $value, $range = false) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'int')
			->argument(3, 'bool');
		
		if(!$this->_facet) { //set facet if not yet set
			$this->_facet = true;
		}
		
		if($range) {
			$value = $value.self::RANGES;
		}
		
		$this->_facetItem[] = array(
			self::NAME		=> $name,
			self::VALUE		=> $value);
		
		return $this;
		
	}
	
	/**
	 *	add keyword to be searched
	 *
	 * @param string
	 * @return this
	 */
	public function addKeyword($keyword) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_keyword[] = $keyword;
		
		return $this;
	}
	
	/**
	 *	Add restriction for the search
	 *
	 * @param string
	 * @param array
	 * @return this
	 */
	public function addRestriction($name, $value) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'array');
			
		$this->_restrictBy[] = array(
			self::NAME	=> $name,
			self::VALUE	=> implode('|', $value));
		
		return $this;
	}
	
	/**
	 * get response
	 *
	 * @return json
	 */
	public function getResponse() {
		if(!empty($this->_restrictBy)) {
			foreach($this->_restrictBy as $key => $restrict) {
				$restrictBy[] = $restrict[self::NAME].':'.$restrict[self::VALUE];
			}
		}
		
		if(!empty($this->_rankBy)) {
			$order = $this->_rankBy[self::NAME].':'.$this->_rankBy[self::VALUE];
		}
		
		if(!empty($this->_crowding)) {
			$crowding = $this->_crowding[self::NAME].':'.$this->_crowding[self::VALUE];
		}
		
		if(!empty($this->_facetItem)) {
			foreach($this->_facetItem as $key => $facet) {
				$facets[] = $facet[self::NAME].':'.$facet[self::VALUE];
			}
		}
		
		$params = array(
			self::QUERY				=> implode('|', $this->_keyword),
			self::COUNTRY			=> $this->_country,
			self::CURRENCY			=> $this->_currency,
			self::RESTRICT_BY		=> (!isset($restrictBy)) ? NULL : implode(', ', $restrictBy),
			self::RANK_BY			=> (!isset($order)) ? NULL : $order,
			self::CROWD_BY			=> (!isset($crowding)) ? NULL : $crowding,
			self::SPELLING_CHECK	=> ($this->_spellChecker) ? 'true' : 'false',
			self::FACETS_ENABLED	=> ($this->_facet) ? 'true' : 'false',
			self::FACETS_INCLUDE	=> (!isset($facets)) ? NULL : implode(', ', $facets));
		
		return $this->_getResponse(self::REQUEST_URL, $params);
	}
	
	/**
	 *	Sets the country
	 *
	 * @param string
	 * @return this
	 */
	public function setCountry($country = 'US'){
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_country = $country;
		
		return $this;
	}
	
	/**
	 * Set crowding of the search result
	 *
	 * @param string
	 * @param int
	 * @return this
	 */
	public function setCrowding($name, $occurrence) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'int');
		
		$this->_crowding = array(
			self::NAME	=> $name, 
			self::VALUE	=> $occurrence);
		
		return $this;
	}
	
	/**
	 *	Sets currency
	 *
	 * @param string
	 * @return this
	 */
	public function setCurrency($currency = 'USD'){
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_currency = $currency;
		
		return $this;
	}
	
	/**
	 * Set facet
	 *
	 * @param bool
	 * @return this
	 */
	public function setFacet($value = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		$this->_facet = $value;
		
		return $this;
	}
	
	/**
	 * Set Order of the search result
	 *
	 * @param string
	 * @param array
	 * @return this
	 */
	public function setOrder($name, $value = 'assending') {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_rankBy = array(
			self::NAME	=> $name,
			self::VALUE	=> $value);
		
		return $this;
	}
	
	/**
	 * Set spell checker
	 *
	 * @param bool
	 * @return this
	 */
	public function setSpellChecker($value = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		$this->_spellChecker = $value;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}