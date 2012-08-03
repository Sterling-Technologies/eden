<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * 
 *
 * @package    Eden
 * @category   
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Contacts_Block_Addgroups extends Eden_Block { 
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query	= array();
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($query) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'array');			
		
		$this->_query = $query;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Returns a template file
	 * 
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/addgroups.php');
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {

		return array(
			'title'			=> $this->_query['title'],
			'description'	=> $this->_query['description'],
			'info'			=> $this->_query['info']);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}