<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Pagination block
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Block_Social extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_url 	= NULL;
	protected $_buttons	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct() {
	}
	
	/* Public Methods
	-------------------------------*/
	
	public function setUrl($url) {
		$this->_url = $url;
		return $this;
	}
	
	public function addButton($button, $layout = 'pill', $url = NULL) {
		$this->_buttons[] = array(
			'button'	=> $button,
			'layout'	=> $layout,
			'url'		=> $url);
		
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
			'buttons'		=> $this->_buttons,
			'url'			=> $this->_url);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/social.phtml');
	}
}