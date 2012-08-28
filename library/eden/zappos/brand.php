<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos brand
 *
 * @package    Eden
 * @category   brand
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Brand extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_brandId	= NULL;
	
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
	 * set brand id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setBrandId($brandId) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_brandId = $brandId;
		return $this;
	}
	
	/**
	 * Search Brand
	 *
	 * @return this
	 */
	public function getResponse() {
		
		return $this->_getResponse(self::URL_BRAND.$this->_brandId);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}