<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos similarity
 *
 * @package    Eden
 * @category   similarity
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos_Similarity extends Eden_Zappos_Base {
	/* Constants
	-------------------------------*/
	const EMPHASIS	= 'emphasis';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_type		= NULL;
	protected $_limits		= NULL;
	protected $_styleId		= NULL;
	protected $_emphasis	= NULL;
	
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
	 * set similarity to visual search
	 *
	 * @return this
	 */
	public function setToVisualSearch() {
	
		$this->_type = 'visualSearch';
		return $this;
	}
	
	/**
	 * set similarity to more like this
	 *
	 * @return this
	 */
	public function setToMoreLikeThis() {
	
		$this->_type = 'moreLikeThis';
		return $this;
	}
	
	/**
	 * set style id
	 *
	 * @return this
	 */
	public function setStyleId($styleId) {
	
		$this->_styleId = $styleId;
		return $this;
	}
	
	/**
	 * set limits it results
	 *
	 * @return this
	 */
	public function setLimits($limits) {
	
		$this->_limits = $limits;
		return $this;
	}
	
	/**
	 * set emphasis
	 *
	 * @return this
	 */
	public function setEmphasis($emphasis) {
	
		$this->_emphasis = $emphasis;
		return $this;
	}
	
	/**
	 * get zapppos core values
	 *
	 * @return this
	 */
	public function getResponse() {
		//populate fields
		$query = array(
			self::TYPE 		=> $this->_type,
			self::LIMITS	=> $this->_limits,
			self::STYLE_ID	=> $this->_styleId,
			self::EMPHASIS	=> $this->_emphasis);
		
		return $this->_getResponse(self::URL_SIMILARITY, $query);
	
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}