<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 */
class Front_Page_Index extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta = array();
	protected $_body = array();
	protected $_title = 'Eden';
	protected $_class = 'documentation';
	protected $_template = '/index.phtml';
	protected $_session = false;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		return $this->_renderPage();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
