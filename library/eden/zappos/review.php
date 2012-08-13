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
class Eden_Zappos_Review extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const START_ID		= 'startId';
	const START_DATE	= 'startDate';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_productId	= NULL;
	protected $_page		= NULL;
	protected $_startId		= NULL;
	protected $_startDate	= NULL;
	
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
	 * set product id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setProductId($productId) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_productId = $productId;
		return $this;
	}
	
	/**
	 * set page
	 *
	 * @param string|int
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_page = $page;
		return $this;
	}
	
	/**
	 * set start id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStartId($startId) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_startId = $startId;
		return $this;
	}
	
	/**
	 * set start Date
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStartDate($startDate) {
		//Argument 1 must be a string or int
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
	
		$this->_startDate = $startDate;
		return $this;
	}
	
	/**
	 * Search Brand
	 *
	 * @return this
	 */
	public function getResponse() {
		//populate fields
		$query = array(
			self::PRODUCT_ID	=> $this->_productId,
			self::PAGE			=> $this->_page,
			self::START_ID		=> $this->_startId,
			self::START_DATE	=> $this->_startDate);
		
		return $this->_getResponse(self::URL_REVIEW, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}