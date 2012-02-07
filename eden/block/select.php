<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Drop down list
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Block_Select extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_attributes	= array();
	protected $_list		= array();
	protected $_value 		= NULL;
	protected $_first		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct(array $list) {
		$this->_list = $list;
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
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		return array(
			'list'			=> $this->_list,
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