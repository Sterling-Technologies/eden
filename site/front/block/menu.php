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
class Front_Block_Menu extends Eden_Block {
	/* Constants
	-------------------------------*/
	const REPO_URL 	= 'http://svn.openovate.com/edenv2/trunk/library';
	const REPO_USER = 'cblanquera';
	const REPO_PASS = 'gphead';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_path 	= NULL;
	protected $_root 	= NULL;
	
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
		$contents = $this->_getContents($this->_root);
		return array('contents' => $contents, 'current' => $this->_path, 'root' => $this->_root);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/menu.php');
	}
	
	protected function _getContents($path) {
		$response = $this->Eden_Curl()
			->setUrl(self::REPO_URL.$path)
			->setUserPwd(self::REPO_USER.':'.self::REPO_PASS)
			->setHttpAuth(CURLAUTH_BASIC)
			->setFollowLocation(true)
			->getResponse();
		
		$lines = explode("\n", $response);
		$folders = $files = array();
		foreach($lines as $line) {
			if(preg_match("/<li><a/", $line)) {
				$line = strip_tags(trim($line));
				if(preg_match("/\//", $line)) {
					$folders[] = str_replace('/', '', $line);
				} else if($line != '..') {
					$files[] = $line;
				}
			}
		}
		
		return array('folders' => $folders, 'files' => $files);
	}
}