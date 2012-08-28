<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 * General available methods for common templating procedures
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Template extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_data = array();
	
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
	 * Sets template variables
	 *
	 * @param array|string
	 * @param mixed
	 * @return this
	 */
	public function set($data, $value = NULL) {
		Eden_Template_Error::i()->argument(1, 'array', 'string');
		
		if(is_array($data)) {
			$this->_data = $data;
			return $this;
		}
		
		$this->_data[$data] = $value;
		
		return $this;
	}
	
	/**
	 * Simple string replace template parser
	 *
	 * @param *string template file
	 * @return string
	 */
	public function parseString($string) {
		Eden_Template_Error::i()->argument(1, 'string');
		foreach($this->_data as $key => $value) {
			$string = str_replace($key, $value, $string);
		}
		
		return $string;
	}
	
	/**
	 * For PHP templates, this will transform the given document to an actual page or partial
	 *
	 * @param *string template file or PHP template string
	 * @param bool whether to evaluate the first argument
	 * @return string
	 */
	public function parsePhp($____file, $___evalString = false) {
		Eden_Template_Error::i()
			->argument(1, $____file, 'string')
			->argument(2, $___evalString, 'bool');
		
		extract($this->_data, EXTR_SKIP); 	// Extract the values to a local namespace
		
		if($___evalString) {
			return eval('?>'.$___file.'<?php;');
		}
		
		ob_start();							// Start output buffering
		include $____file;					// Include the template file
		$____contents = ob_get_contents();	// Get the contents of the buffer
		ob_end_clean();						// End buffering and discard
		return $____contents;				// Return the contents
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Template Errors
 */
class Eden_Template_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}