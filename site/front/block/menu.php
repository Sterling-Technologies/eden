<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */

/**
 * Pagination block
 */
class Front_Block_Menu extends Eden_Block {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_path 	= NULL;
	protected $_root 	= NULL;
	
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
	 * This Block has pagination we need to pass in the url
	 *
	 * @param array
	 * @return this
	 */
	public function setRoot($root) {
		$this->_root = $root;
		return $this;
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		$contents 	= $this->_getContents($this->_root);
		return array('contents' => $contents, 'current' => $this->_path, 'root' => $this->_root);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/menu.phtml');
	}
	
	protected function _getContents($path) {
		$request 	= front()->getRegistry();
		$library	= $request['path']['library'];
		$folder		= $this->Folder($library.$path);
		$files		= $folder->getFiles();
		$folders	= $folder->getFolders();
		return array('folders' => $folders, 'files' => $files);
	}
}