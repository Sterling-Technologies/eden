<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Confirm Block
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Authorizenet_Block_Confirm extends Eden_Block {
	/* Constants
	-------------------------------*/
	const VERSION	= '3.1';
	const SUBMIT	= 'Submit Payment';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_login		= NULL;
	protected $_fingerprint	= NULL;
	protected $_description	= NULL;
	protected $_time		= NULL;
	protected $_sequence	= NULL;
	protected $_url			= NULL;
	protected $_action 		= NULL;
	protected $_test		= false;
	protected $_amount		= 0;
	protected $_version		= self::VERSION;
	protected $_submit 		= self::SUBMIT;

	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($login, $fingerprint, $amount, $description, $url) {
		//Argument Test
		Eden_Authorizenet_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string
			->argument(2, 'string')			//Argument 2 must be a string
			->argument(3, 'float', 'int')	//Argument 3 must be an integer or float
			->argument(4, 'string')			//Argument 4 must be a string
			->argument(5, 'string');		//Argument 5 must be a string
			
		$this->_login 		= $login;
		$this->_fingerprint = $fingerprint;
		$this->_amount 		= $amount;
		$this->_description = $description;
		$this->_url			= $url;
		
		$this->_time = time();
		$this->_sequence = '123'.$this->_time;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Set the URL the form will submit to
	 *
	 * @param string
	 * @return this
	 */
	public function setAction($action) {
		//Argument 1 must be as string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		$this->_action = $action;
		return $this;
	}
	
	/**
	 * Set the value of the submit button
	 *
	 * @param string
	 * @return this
	 */
	public function setButton($text) {
		//Argument 1 must be as string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		$this->_submit = $text;
		return $this;
	}
	
	/**
	 * Set the transaction sequence.
	 * Should be a unique set of characters
	 *
	 * @param string
	 * @return this
	 */
	public function setSequence($sequence) {
		//Argument 1 must be as string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		$this->_sequence = $sequence;
		return $this;
	}
	
	/**
	 * Returns a template file
	 * 
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/confirm.php');
	}
	
	/**
	 * Set the transaction time
	 *
	 * @param int
	 * @return this
	 */
	public function setTime($time) {
		//Argument 1 must be an integer
		Eden_Authorizenet_Error::i()->argument(1, 'int');
		$this->_time = $time;
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
			'login' 		=> $this->_login,
			'fingerprint' 	=> $this->_fingerprint,
			'amount' 		=> $this->_amount,
			'description' 	=> $this->_description,
			'time' 			=> $this->_time,
			'sequence' 		=> $this->_sequence,
			'action' 		=> $this->_url,
			'version' 		=> $this->_version,
			'test' 			=> $this->_test?'true':false,
			'submit' 		=> $this->_submit,);
	}
	
	/**
	 * Set the authorize.net API version
	 *
	 * @param string
	 * @return this
	 */
	public function setVersion($version) {
		//Argument 1 must be as string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		$this->_version = $version;
		return $this;
	}
	
}