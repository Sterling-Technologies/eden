<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos statistics
 *
 * @package    Eden
 * @category   statistics
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Statistics extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const LOCATION	= 'location';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_statistics	= NULL;
	protected $_filter		= NULL;
	
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
	 * Get statistics latest styles
	 *
	 * @param string
	 * @return this
	 */
	public function getLatestStyles() {
		
		$this->_statistics = 'latestStyles';
		return $this;
	}
	
	/**
	 * Get statistics top styles
	 *
	 * @param string
	 * @return this
	 */
	public function getTopStyles() {
		
		$this->_statistics = 'topStyles ';
		return $this;
	}
	
	/**
	 * Filter by brand name
	 *
	 * @param string
	 * @return this
	 */
	public function filterByBrandName($brandName) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
	
		$this->_filter = '{"brand":{"name":"'.$brandName.'"}}';
		return $this;
	}
	
	/**
	 * Filter by brand id
	 *
	 * @param string
	 * @return this
	 */
	public function filterByBrandId($brandId) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
	
		$this->_filter = '{"brand":{"id":"'.$brandid.'"}}';
		return $this;
	}
	
	/**
	 * Filter by product type
	 *
	 * @param string
	 * @return this
	 */
	public function filterByProductType($productValue) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_filter = '{"categorization":{"productType":"'.$productValue.'"}}';
		return $this;
	}
	
	/**
	 * Filter by category type
	 *
	 * @param string
	 * @return this
	 */
	public function filterByCategoryType($productValue) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_filter = '{"categorization":{"categoryType":"'.$productValue.'"}}';
		return $this;
	}
	
	/**
	 * Filter by sub category type
	 *
	 * @param string
	 * @return this
	 */
	public function filterBySubCategoryType($productValue) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_filter = '{"categorization":{"subcategoryType":"'.$productValue.'"}}';
		return $this;
	}
	
	/**
	 * Filter male
	 *
	 * @return this
	 */
	public function filterByMale() {
	
		$this->_filter = '{"gender":"M"}';
		return $this;
	}
	
	/**
	 * Filter female
	 *
	 * @return this
	 */
	public function filterByFemale() {
	
		$this->_filter = '{"gender":"F"}';
		return $this;
	}
	
	/**
	 * Filter unisex
	 *
	 * @return this
	 */
	public function filterByUnisex() {
	
		$this->_filter = '{"gender":"U"}';
		return $this;
	}
	
	/**
	 * filter by zip location
	 *
	 * @param string
	 * @return this
	 */
	public function setZipLocation($locationValue) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_location = '{"zip":"'.$locationValue.'"}';
		return $this;
	}
	
	/**
	 * filter by state location
	 *
	 * @param string
	 * @return this
	 */
	public function setStateLocation($locationValue) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_location = '{"state":"'.$locationValue.'"}';
		return $this;
	}
	
	/**
	 * Search Image
	 *
	 * @return this
	 */
	public function getResponse() {
		//populate fields
		$query = array(
			self::TYPE		=> $this->_statistics,
			self::FILTER	=> $this->_filter,
			self::LOCATION	=> $this->_location);
		
		return $this->_getResponse(self::URL_STATISTICS, $query);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}