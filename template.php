<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * General available methods for common templating procedures
 *
 * @package    Eden
 * @subpackage template
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: template.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets template variables
	 *
	 * @param array|string
	 * @param mixed
	 * @return this
	 */
	public function setData($data, $value = NULL) {
		Eden_Error_Validate::get()->argument(0, 'array', 'string');
		
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
		Eden_Error_Validate::get()->argument(0, 'array', 'string');
		
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
		Eden_Error_Validate::get()->argument(0, 'array', 'string');
		
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
								 $lines[$i][] = Eden_Template::get()
								 	->setData($value)
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