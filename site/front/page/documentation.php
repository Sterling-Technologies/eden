<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 */
class Front_Page_Documentation extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden - Documentation';
	protected $_class = 'documentation';
	protected $_template = '/documentation.php';
	
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
		$file = $this->_request['request']['string'].'.php';
		if($file != '/documentation.php') {
			$template = $this->_request['path']['template'];
			if(!file_exists($template.$file)) {
				$file = '/soon.php';
			}
			$content = front()->template($template.$file);
		}
		$this->_body = array('content' => $content);
		return $this->_renderPage();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
