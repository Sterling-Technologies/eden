<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/type/abstract.php';
require_once dirname(__FILE__).'/type/error.php';
require_once dirname(__FILE__).'/array.php';

/**
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_String extends Eden_Type_Abstract {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_preMethods = array(
		'addslashes',				'addcslahses',
		'bin2hex',					'chunk_split',
		'convert_uudecode',			'convert_uuencode',
		'crypt',					'html_entity_decode',
		'htmlentities',				'htmlspecialchars_decode',
		'htmlspecialchars',			'lcfirst',
		'ltrim',					'md5',
		'nl2br',					'quoted_printable_decode',
		'quoted_printable_encode',	'quotemeta',
		'rtrim',					'sha1',
		'sprintf',					'str_pad',
		'str_repeat',				'str_rot13',
		'str_shuffle',				'strip_tags',
		'stripcslashes',			'stripslashes',
		'strpbrk',					'stristr',
		'strrev',					'strstr',
		'strtok',					'strtolower',
		'strtoupper',				'strtr',
		'substr_replace',			'substr',
		'trim',						'ucfirst',
		'ucwords',					'vsprintf',
		'wordwrap',					'count_chars',
		'hex2bin',					'strlen',
		'strpos',					'substr_compare',
		'substr_count');
	
	protected static $_postMethods = array('str_ireplace', 'str_replace', 'explode');
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($data) {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		return self::_getMultiple(__CLASS__, $data);
	}
	
	/* Magic
	-------------------------------*/
	public function __toString() {
		return $this->_data;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the string
	 *
	 * @param bool whether to get the modified or original version
	 * @return string
	 */
	public function getValue($modified = true) {
		if($modified instanceof Eden_Boolean) {
			$modified = $modified->getValue();
		}
		
		//argument 1 must be a bool
		Eden_Error_Validate::get()->argument(0, 'bool');
		
		return $modified ? $this->_data : $this->_original;
	}
	
	/**
	 * Camelizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function camelize($prefix = '-') {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		$this->_data = str_replace($prefix, ' ', $this->_data);
		$this->_data = str_replace(' ', '', ucwords($this->_data));
		
		$this->_data = strtolower(substr($name, 0, 1)).substr($name, 1);
		
		return $this;
	}
	
	/**
	 * Uncamelizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function uncamelize($prefix = '-') {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		$this->_data = strtolower(preg_replace("/([A-Z])/", $prefix."$1", $this->_data));
		
		return $this;
	}
	
	/**
	 * Transforms a string with caps and 
	 * space to a lower case dash string 
	 *
	 * @return this
	 */
	public function dasherize() {
		$this->_data = preg_replace("/[^a-zA-Z0-9_-\s]/i", '', $this->_data);
		$this->_data = str_replace(' ', '-', trim($this->_data));
		$this->_data = preg_replace("/-+/i", '-', $this->_data);
		$this->_data = strtolower($this->_data);
		
		return $this;
	}
	
	/**
	 * Titlizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function titlize($prefix = '-') {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		$this->_data = ucwords(str_replace($prefix, ' ', $this->_data));
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getPreMethod($name) {
		if(in_array($name, self::$_preMethods)) {
			return $name;
		}
		
		if(in_array('str'.$name, self::$_preMethods)) {
			return 'str'.$name;
		}
		
		if(in_array('str_'.$name, self::$_preMethods)) {
			return 'str_'.$name;
		}
		
		return false;
	}
	
	protected function _getPostMethod($name) {
		if(in_array($name, self::$_postMethods)) {
			return $name;
		}
		
		if(in_array('str'.$name, self::$_postMethods)) {
			return 'str'.$name;
		}
		
		if(in_array('str_'.$name, self::$_postMethods)) {
			return 'str_'.$name;
		}
		
		return false;
	}
	
	protected function _getReferenceMethod($name) {
		return false;
	}
	
	/* Private Methods
	-------------------------------*/
}