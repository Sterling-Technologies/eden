<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Drop down list for timezones
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Block_Timezones extends Eden_Block {
	/* Constants
	-------------------------------*/
	const GMT 		= 1;
	const UTC 		= 2;
	const OFFSET 	= 3;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array();
	protected $_value 		= NULL;
	protected $_first		= NULL;
	
	protected $_use 		= self::GMT;
	protected $_format 		= 'F d, Y g:iA';
	protected $_interval 	= 30;
	protected $_prefix 		= NULL;
	
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
	 * Sets select tag attributes
	 *
	 * @param array|string
	 * @param scalar|null
	 * @return this
	 */
	public function setAttributes($attributes, $value = NULL) {
		Eden_Error::i()
			->argument(1, 'string', 'array')
			->argument(2, 'scalar', 'null');
		
		if(is_string($attributes)) {
			$this->_attributes[$attributes] = $value;
			return $this;
		}
		
		$this->_attributes = $attributes;
		return $this;
	}
	
	/**
	 * Sets the selected state on a value
	 *
	 * @param scalar|null
	 * @return this
	 */
	public function setValue($value) {
		Eden_Error::i()->argument(1, 'scalar', 'null');
		$this->_value = $value;
		return $this;
	}
	
	/**
	 * Sets the first option
	 *
	 * @param string
	 * @return this
	 */
	public function setFirst($label) {
		Eden_Error::i()->argument(1, 'scalar', 'null');
		$this->_first = $label;
		return $this;
	}
	
	/**
	 * Sets the date format
	 *
	 * @param string
	 * @return this
	 */
	public function setFormat($format) {
		Eden_Error::i()->argument(1, 'string');
		$this->_format = $format;
		return $this;
	}
	
	/**
	 * Sets interval of timezones shown
	 *
	 * @param int
	 * @return this
	 */
	public function setInterval($interval) {
		Eden_Error::i()->argument(1, 'int');
		$this->_interval = $interval;
		return $this;
	}
	
	/**
	 * Use offset as the value
	 *
	 * @return this
	 */
	public function useOffset() {
		$this->_use = self::OFFSET;
		return $this;
	}
	
	/**
	 * Use UTC as the value
	 *
	 * @param string
	 * @return this
	 */
	public function useUTC($prefix = Eden_Timezone::UTC) {
		$this->_use = self::UTC;
		$this->_prefix = $prefix;
		return $this;
	}
	
	/**
	 * Use GMT as the value
	 *
	 * @param string
	 * @return this
	 */
	public function useGMT($prefix = Eden_Timezone::GMT) {
		$this->_use = self::GMT;
		$this->_prefix = $prefix;
		return $this;
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		//get the default time zone
		//it doesn't really matter which 
		//zone we choose
		$timezones = Eden_Timezone::i(date_default_timezone_get());
		
		//choose a value format
		switch($this->_use) {
			case self::OFFSET:
				$timezones = $timezones->getOffsetDates($this->_format, $this->_interval);
				break;
			case self::UTC:
				$timezones = $timezones->getUTCDates($this->_format, $this->_interval, $this->_prefix);
				break;
			case self::GMT:
			default:
				$timezones = $timezones->getGMTDates($this->_format, $this->_interval, $this->_prefix);
				break;
		}
		
		return array(
			'list'		=> $timezones,
			'first'			=> $this->_first,
			'attributes'	=> $this->_attributes,
			'value'			=> $this->_value); 
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).self::$_blockRoot.'/select.phtml');
	}
}