<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Base class for any class that defines an output block.
 * A block is a default and customizable piece of output.
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
abstract class Eden_Block extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_blockRoot = NULL;
	
	/* Private Properties
	-------------------------------*/
	private static $_global = array();
	
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __toString() {
		try {
			return (string) $this->render();
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
		}
		
		return '';
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * returns location of template file
	 *
	 * @return string
	 */
	abstract public function getTemplate();
	
	/**
	 * returns variables used for templating
	 *
	 * @return array
	 */
	abstract public function getVariables();
	
	/**
	 * Transform block to string
	 *
	 * @param array
	 * @return string
	 */
	public function render() {
		return Eden_Template::i()->set($this->getVariables())->parsePhp($this->getTemplate());
	}
	
	/**
	 * For one file Eden, you can set the default
	 * location of Eden's template to another location.
	 *
	 * @param string
	 * @return this
	 */
	public function setBlockRoot($root) {
		Eden_Error::i()->argument(1, 'folder');
		self::$_blockRoot = $root;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getGlobal($value) {
		if(in_array($value, self::$_global)) {
			return false;
		}
		
		self::$_global[] = $value;
		return $value;
	}
	
	/* Private Methods
	-------------------------------*/
}