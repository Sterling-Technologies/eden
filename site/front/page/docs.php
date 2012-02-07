<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 */
class Front_Page_Docs extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden - Documentation';
	protected $_class = 'documentation';
	protected $_template = '/docs.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i(Eden_Registry $request = NULL) {
		return self::_getMultiple(__CLASS__, $request);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		
		$content = NULL;
		$file = $this->_request['request']['string'].'.phtml';
		if($file != $this->_template) {
			$page = $this->_request['path']['page'];
			if(!file_exists($page.$file)) {
				$file = '/soon.phtml';
			}
			$content = front()->template($page.$file);
		}
		$this->_body = array('content' => $content);
		return $this->_renderPage();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
