<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos values
 *
 * @package    Eden
 * @category   values
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Values extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_values	= NULL;
	
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
	 * set values id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setValuesId($values) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_values = $values;
		return $this;
	}
	
	/**
	 * set values to random
	 *
	 * @return this
	 */
	public function setRandomValues() {
	
		$this->_random = 'random';
		return $this;
	}
	
	/**
	 * get zapppos core values
	 *
	 * @return this
	 */
	public function getResponse() {
		
		return $this->_getResponse(self::URL_VALUE.$this->_values);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}