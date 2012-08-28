<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos Image
 *
 * @package    Eden
 * @category   image
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Image extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const RECIPE		= 'recipe';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_productId	= NULL;
	protected $_styleId		= NULL;
	protected $_include		= NULL;
	protected $_imageType	= NULL;
	
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
	 * Set product id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setProductId($productId) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_productId = $productId;
		return $this;
	}
	
	/**
	 * Set style id
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStyleId($styleId) {
		//Argument 1 must be a string or integer
		Eden_Zappos_Error::i()->argument(1, 'string', 'int');
		
		$this->_styleId = '["'.$styleId.'"]';
		return $this;
	}
	
	/**
	 * Include color id in reusult 
	 *
	 * @return this
	 */
	public function includeColorId() {
	
		$this->_include = '["colorId"]';
		return $this;
	}
	
	/**
	 * Include width in reusult 
	 *
	 * @return this
	 */
	public function includeWidth() {
		
		$this->_include	= '["width"]';
		return $this;
	}
	
	/**
	 * Include height in reusult 
	 *
	 * @return this
	 */
	public function includeHeight() {
		
		$this->_include	= '["height"]';
		return $this;
	}
	
	/**
	 * Include upload date in reusult 
	 *
	 * @return this
	 */
	public function includeUploadDate() {
		
		$this->_include	= '["uploadDate"]';
		return $this;
	}
	
	/**
	 * Include resolution id in reusult 
	 *
	 * @return this
	 */
	public function includeResolution() {
		
		$this->_include	= '["isHighResolution"]';
		return $this;
	}
	
	/**
	 * Include title in reusult 
	 *
	 * @return this
	 */
	public function includeTitle() {
		
		$this->_include	= '["title"]';
		return $this;
	}
	
	/**
	 * Set image type. An image Type is a particular angle shot 
	 * of an item. e.g. PAIR, LEFT, RIGHT, TOP and etc.
	 *
	 * @param string
	 * @return this
	 */
	public function setImageType($imageType) {
		//Argument 1 must be a string 
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_imageType = '["'.$imageType.'"]';
		return $this;
	}
	
	/**
	 * Set sizing transformation for an image
	 *
	 * @param string
	 * @return this
	 */
	public function setImageRecipe($imageRecipe) {
		//Argument 1 must be a string 
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		$this->_imageRecipe = '["'.$imageRecipe.'"]';
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
			self::PRODUCT_ID	=> $this->_productId,
			self::STYLE_ID		=> $this->_styleId,
			self::INCLUDES		=> $this->_include,
			self::TYPE			=> $this->_imageType,
			self::RECIPE		=> $this->_imageRecipe);
		
		return $this->_getResponse(self::URL_IMAGE, $query);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}