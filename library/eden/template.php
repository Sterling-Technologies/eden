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
		Eden_Template_Error::i()->argument(0, 'array', 'string');
		
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
		Eden_Template_Error::i()->argument(0, 'string');
		foreach($this->_data as $key => $value) {
			$string = str_replace($key, $value, $string);
		}
		
		return $string;
	}
	
	/**
	 * For PHP templates, this will transform the given document to an actual page or partial
	 *
	 * @param *string template file
	 * @return string
	 */
	public function parsePhp($____file) {
		Eden_Template_Error::i()->argument(0, $____file, 'string');
		
		extract($this->_data, EXTR_SKIP); 	// Extract the values to a local namespace
		ob_start();							// Start output buffering
		include $____file;					// Include the template file
		$____contents = ob_get_contents();	// Get the contents of the buffer
		ob_end_clean();						// End buffering and discard
		return $____contents;				// Return the contents
	}
	
	/**
	 * For non PHP templates, this will transform the given document to an actual page or partial
	 *
	 * @param *string template file
	 * @return string
	 */
	public function parseEngine($template) {
		Eden_Template_Error::i()->argument(0, 'string');
		
		$lines = explode("\n", $template);
		$count = count($lines);
		for($i = 0; $i < $count; $i++) {
			$patterns = array();
			
			//handle all the easy values
			preg_match_all("/{(.*?)}/", $lines[$i], $patterns);
			if(!empty($patterns[0]) && !empty($patterns[1])) {
				foreach($patterns[1] as $j => $key) {	
					$value = isset($this->_data[$key]) ? $this->_data[$key] : '';
					$lines[$i] = str_replace($patterns[0][$j], $value, $lines[$i]);
				}
			}
			
			preg_match_all("/<php:(.*?) \/>/", $lines[$i], $patterns);
			if(!empty($patterns[0]) && !empty($patterns[1])) {
				foreach($patterns[1] as $j => $key) {
					$value = isset($this->_data[$key]) ? $this->_data[$key] : '';
					$lines[$i] = str_replace($patterns[0][$j], $value, $lines[$i]);
				}
			}
			
			//handle advanced pattern
			preg_match_all("/<php:(.*?)>/", $lines[$i], $patterns);
			if(!empty($patterns[0]) && !empty($patterns[1])) {
				foreach($patterns[1] as $j => $key) {
					$subTemplate = array();
					$closePattern = str_replace('<php:'.$key.'>', '</php:'.$key.'>', $lines[$i]);
					unset($lines[$i]);
					$i++;
					while($i < $count && $lines[$i] != $closePattern) {
						$subTemplate[] = $lines[$i];
						
						unset($lines[$i]);
						$i++;
						
					}
					
					$lines[$i] = array();
					
					if(isset($this->_data[$key]) && is_array($this->_data[$key])) {
						foreach($this->_data[$key] as $value) {
							if(is_array($value)) {
								 $lines[$i][] = Eden_Template::i()
								 	->set($value)
									->parseEngine(implode("\n", $subTemplate));
							}
						}
					}
					
					$lines[$i] = implode("\n", $lines[$i]);	
				}
			}
		}
		
		return implode("\n", $lines);
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
	/* Get
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Magic
	-------------------------------*/
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}