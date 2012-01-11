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
class Front_Block_Log extends Eden_Block {
	/* Constants
	-------------------------------*/
	const REPO_URL 	= 'http://svn.openovate.com/edenv2/trunk/library';
	const REPO_USER = 'cblanquera';
	const REPO_PASS = 'gphead';
	const REPO_LOG	= 'svn log --username %s --password %s --xml --non-interactive --verbose %s 2>&1';
	
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
		exec(sprintf(self::REPO_LOG, self::REPO_USER, self::REPO_PASS, self::REPO_URL), $log);
		$log = implode("\n", $log);
		$log = simplexml_load_string($log);
		$history = array();
		foreach($log->logentry as $entry) {
			$history[] = array(
				'revision'	=> $entry->attributes()->revision,
				'author' 	=> $entry->author,
				'date'		=> date('F d, Y g:iA', strtotime($entry->date)),
				'message' 	=> $entry->msg
			);
		}
		
		return array('history' => $history);
	}
	
	/**
	 * Returns a template file
	 * 
	 * @param array data
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/log.php');
	}
}