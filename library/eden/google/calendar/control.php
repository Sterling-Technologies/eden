<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Class for adding Event on Google Calendar
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Calendar_Control extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_type	= NULL;
	protected $_value	= NULL;
	protected $_role	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	public function setType($type) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_type = $type;
		
		return $this;
	}
	
	public function setValue($value) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_value = $value;
		
		return $this;
	}
	
	public function seRole($role) {
			Eden_Google_Error::i()->argument(1, 'string');
			$this->_role= $role
			
			return $this;
	}
	
	public function create() {
		$query = array(
			'scope' 	=> array(
				'type'		=> $this->_type,
				'value'		=> $this->_value),
			'role'		=> $this->_role);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}