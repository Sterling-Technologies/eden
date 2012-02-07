<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */

/**
 * The base class for any class that defines a view.
 * A view controls how templates are loaded as well as 
 * being the final point where data manipulation can occur.
 *
 * @package    Eden
 */
abstract class Front_Page extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta		= array();
	protected $_request 	= NULL;
	protected $_messages 	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct(Eden_Registry $request = NULL) {
		$this->_request = $request;
	}
	
	public function __toString() {
		try {
			$output = $this->render();
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
			
			return '';
		}
		
		if(is_null($output)) {
			return '';
		}
		
		return $output;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a string rendered version of the output
	 *
	 * @return string
	 */
	abstract public function render();
	
	/* Protected Methods
	-------------------------------*/
	protected function _setMessage($message, $type = NULL) {
		$this->_messages[] = array('type' => $type, 'message' => $message);
		
		return $this;
	}
	
	protected function _renderPage() {
		$page = $this->_request['path']['page'];
		
		$messages 	= $this->_request['message'];
		
		if(is_array($messages)) {
			foreach($messages as $message) {
				$this->_setMessage($message[0], $message[1]);
			}
		}
		
		$this->_body['messages'] = $this->_messages;
		
		$head = front()->template($page.'/_head.phtml');
		$body = front()->template($page.$this->_template, $this->_body);
		$foot = front()->template($page.'/_foot.phtml');
		
		return front()->template($page.'/_page.phtml', array(
			'meta' 			=> $this->_meta,
			'title'			=> $this->_title,
			'class'			=> $this->_class,
			'head'			=> $head,
			'body'			=> $body,
			'foot'			=> $foot));
	}
	
	/* Private Methods
	-------------------------------*/
}