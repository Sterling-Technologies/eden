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
class Eden_Block_Search extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_name	= NULL;
	protected $_keyword	= NULL;
	protected $_query 	= array();
	protected $_url 	= NULL;
	protected $_class	= NULL;
	protected $_title	= NULL;
	
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
	 * Sets keyword
	 *
	 * @param string
	 * @return this 
	 */
	public function setKeyword($keyword) {
		Front_Error::i()->argument(1, 'string', 'null');
		$this->_keyword = $keyword;
		
		return $this;
	}
	
	/**
	 * This Block has pagination we need to pass in the GET query
	 *
	 * @param array
	 * @return this
	 */
	public function setQuery(array $query) {
		$this->_query = $query;
		return $this;
	}
	
	/**
	 * This Block has pagination we need to pass in the url
	 *
	 * @param array
	 * @return this
	 */
	public function setUrl($url) {
		$this->_url = $url;
		return $this;
	}
	
	/**
	 * Sets class for each page link
	 *
	 * @param array
	 * @return this
	 */
	public function setClass($class) {
		$this->_class = $class;
		return $this;
	}
	
	
	/**
	 * Sets a label
	 *
	 * @param array
	 * @return this
	 */
	public function setLabel($label) {
		$this->_label = $label;
		return $this;
	}
	
	/**
	 * Sets a label
	 *
	 * @param array
	 * @return this
	 */
	public function setName($name) {
		$this->_name = $name;
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
			'name'		=> $this->_name, 
			'class'		=> $this->_class,
			'label'		=> $this->_title,
			'url'		=> $this->_url,
			'query' 	=> $this->_query,
			'keyword' 	=> $this->_keyword);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/search.php');
	}
}