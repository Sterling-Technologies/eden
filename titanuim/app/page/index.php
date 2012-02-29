<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 */
class App_Page_Index extends App_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_template = '/index.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$page = $this->_request['path']['page'];
		return app()->template($page.$this->_template, $this->_body);
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _updateMailboxes($account) {
		
	}
	
	/* Private Methods
	-------------------------------*/
}
