<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos review
 *
 * @package    Eden
 * @category   review
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_AutoComplete extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_term	= NULL;
	
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
	 * set term
	 *
	 * @param string
	 * @return this
	 */
	public function setTerm($term) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
	
		$this->_term = $term;
		return $this;
	}
	
	/**
	 * Search Brand
	 *
	 * @return this
	 */
	public function getResponse() {
		//populate fields
		$query = array(self::TERM => $this->_term);
		
		return $this->_getResponse(self::URL_REVIEW, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}