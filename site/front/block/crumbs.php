<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Pagination block
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: form.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Front_Block_Crumbs extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_path 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * This Block has pagination we need to pass in the url
	 *
	 * @param array
	 * @return this
	 */
	public function setPath($path) {
		$this->_path = $path;
		return $this;
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		$crumbs = array(array('link' => '/', 'name' => 'API'));
		if(trim($this->_path)) {
			$pathArray = explode('/', $this->_path);
			array_shift($pathArray);
			$current = NULL;
			foreach($pathArray as $path) {
				$current .= '/'.$path;
				$crumbs[] = array('link' => $current, 'name' => $path);
			}
		}
		
		return array('crumbs' => $crumbs);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/crumbs.php');
	}
}