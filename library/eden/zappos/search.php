<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos Search
 *
 * @package    Eden
 * @category   search
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Search extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const ITEMS			= 'list';
	const SORT			= 'sort';
	const EXCLUDE		= 'excludes';
	const EXPRESSION	= 'filterExpression';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_terms		= NULL;
	protected $_limits		= NULL;
	protected $_list		= NULL;
	protected $_sort		= NULL;
	protected $_exclude		= NULL;
	protected $_page		= NULL;
	protected $_include		= NULL;
	protected $_expression	= NULL;
	protected $_filter		= NULL;
	protected $_order		= 'desc';
	
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
	 * Set search terms
	 *
	 * @param string
	 * @return this
	 */
	public function setTerms($terms) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_terms = $terms;
		return $this;
	}
	
	/**
	 * Set limits in the search query
	 *
	 * @param string|int
	 * @return this
	 */
	public function setLimits($limits) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_limits = $limits;
		return $this;
	}
	
	/**
	 * Set face fields list. 
	 * SetTerms and setList
	 * cannot call at the same time
	 *
	 * @return this
	 */
	public function setList() {
		
		$this->_list = 'facetFields';
		return $this;
	}
	
	/**
	 * Sort result to ascending order
	 * by default in is set to descending
	 *
	 * @return this
	 */
	public function ascendingOrder() {
		
		$this->_order = 'asc';
		return $this;
	}
	
	/**
	 * Sort results by price
	 *
	 * @return this
	 */
	public function sortByPrice(){
		
		$this->_sort = '{"price":"'.$this->_order.'"}';
		return $this;
	}
	
	/**
	 * Sort results by live date
	 *
	 * @return this
	 */
	public function sortGoLiveDate(){
		
		$this->_sort = '{"goLiveDate":".'.$this->_order.'."}';
		return $this;
	}
	
	/**
	 * Sort results by product populariry
	 *
	 * @return this
	 */
	public function sortByPopularity (){
		
		$this->_sort = '{"productPopularity":"'.$this->_order.'"}';
		return $this;
	}
	
	/**
	 * Sort results by recent sale
	 *
	 * @return this
	 */
	public function sortByRecentSale() {
		
		$this->_sort = '{"recentSales":"'.$this->_order.'"}';
		return $this;
	}
	
	public function sortByBrandNameFacet() {
		
		$this->_post = '{"brandNameFacet":"'.$this->_order.'"}';
		return $this;
	}
	
	/**
	 * Exclude results by style Id
	 *
	 * @return this
	 */
	public function excludeByStyleId() {
		
		$this->_exclude = '["results","styleId"]';
		return $this;
	}
	
	/**
	 * Exclude results by price
	 *
	 * @return this
	 */
	public function excludeByPrice() {
		
		$this->_exclude = '["results","price"]';
		return $this;
	}
	
	/**
	 * Exclude results by original price
	 *
	 * @return this
	 */
	public function excludeOriginalPrice() {
		
		$this->_exclude = '["results","originalPrice"]';
		return $this;
	}
	
	/**
	 * Exclude results by product url
	 *
	 * @return this
	 */
	public function excludeProductUrl() {
		
		$this->_exclude = '["results","productUrl"]';
		return $this;
	}
	
	/**
	 * Exclude results by color id
	 *
	 * @return this
	 */
	public function excludeColorId() {
		
		$this->_exclude = '["results","colorId"]';
		return $this;
	}
	
	/**
	 * Exclude results by product name
	 *
	 * @return this
	 */
	public function excludeProductName() {
		
		$this->_exclude = '["results","productName"]';
		return $this;
	}
	
	/**
	 * Exclude results by brand name
	 *
	 * @return this
	 */
	public function excludeBrandName() {
		
		$this->_exclude = '["results","brandName"]';
		return $this;
	}
	
	/**
	 * Exclude results by image url
	 *
	 * @return this
	 */
	public function excludeImageUrl() {
		
		$this->_exclude = '["results","thumbnailImageUrl"]';
		return $this;
	}
	
	/**
	 * Exclude results by percent off
	 *
	 * @return this
	 */
	public function excludePercentOff() {
		
		$this->_exclude = '["results","percentOff"]';
		return $this;
	}
	
	/**
	 * Exclude results by product id
	 *
	 * @return this
	 */
	public function excludeProductId() {
		
		$this->_exclude = '["results","percentOff"]';
		return $this;
	}
	
	/**
	 * include facet in resuts
	 *
	 * @return this
	 */
	public function includeFacets() {
		$this->_include  = '["facets"]';
		return $this;
	}
	
	/**
	 * Set page number
	 *
	 * @param string|int
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * filter results with specific expression
	 *
	 * @param string
	 * @return this
	 */
	public function filterExpression($expression) {
		//Argument 1 must be a string 
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_expression = $expression;
		return $this;
	}
	
	/**
	 * filter results with distinct expression
	 *
	 * @param string
	 * @param string
	 * @return this
	 */
	public function filterProduct($facetFields, $facetValue) {
		
		Eden_Zappos_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_filter = '{".'.$facetFields.'.":[".'.$facetValue.'."]}';
		return $this;
	}
	
	/**
	 *	search zappos products 
	 *
	 * @return array
	 */
	public function search() {			
		//populate fields
		$query = array(
			self::TERM			=> $this->_terms,
			self::LIMIT			=> $this->_limits,
			self::ITEMS			=> $this->_list,
			self::SORT			=> $this->_sort,
			self::EXCLUDES		=> $this->_exclude,
			self::PAGE			=> $this->_page,
			self::INCLUDES		=> $this->_include,
			self::EXPRESSION	=> $this->_expression,
			self::FILTER		=> $this->_filter);
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}