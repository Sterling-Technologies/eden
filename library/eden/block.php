<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Base class for any class that defines an output block.
 * A block is a default and customizable piece of output.
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: abstract.php 5 2010-01-08 22:21:29Z blanquera $
 */
abstract class Eden_Block extends Eden_Class {
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
	 * returns variables used for templating
	 *
	 * @return array
	 */
	abstract public function getVariables();
	
	/**
	 * returns location of template file
	 *
	 * @return string
	 */
	abstract public function getTemplate();
	
	/**
	 * Transform block to string
	 *
	 * @param array
	 * @return string
	 */
	public function render() {
		return Eden_Template::i()->set($this->getVariables())->parsePhp($this->getTemplate());
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}