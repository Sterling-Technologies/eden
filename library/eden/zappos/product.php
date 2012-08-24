<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos Product
 *
 * @package    Eden
 * @category   product
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Product extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const SKU		= 'id';
	const UPC		= 'upc';
	const STOCK_ID	= 'stockId';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_upc			= NULL;
	protected $_stockId		= NULL;
	protected $_sku			= NULL;
	protected $_style		= NULL;
	
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
	 * Set SKU or product id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setSKU($sku) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_sku = $sku;
		return $this;
	}
	
	/**
	 * Set UPC
	 *
	 * @param string|int
	 * @return this
	 */
	public function setUPC($upc) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_upc = $upc;
		return $this;
	}
	
	/**
	 * Set stock id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStockId($stockId) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_stockId = $stockId;
		return $this;
	}
	
	/**
	 * Include style in the results
	 *
	 * @param string|int
	 * @return this
	 */
	public function includeStyle() {
		
		$this->_style = '["styles"]';
		return $this;
	}
	
	/**
	 * Include specific style in the results
	 *
	 * @param string
	 * @return this
	 */
	public function includeSpecific($style) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_style = '["'.$style.'"]';
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
			self::SKU		=> $this->_sku,
			self::INCLUDES	=> $this->_style,
			self::UPC		=> $this->_upc,
			self::STOCK_ID	=> $this->_stockId);
		
		return $this->_getResponse(self::URL_PRODUCT, $query);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}