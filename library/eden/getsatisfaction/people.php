<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  
 *
 * @package    Eden
 * @category   Get Satisfaction
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_GetSatisfaction_People extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.getsatisfaction.com/people.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected $_validShow = array('public','not_hidden','private','not_hidden');
	
	protected $_validSort = array(
								  'created' => 'recently_created',
								  'active'	=> 'recently_active',
								  'alpha'	=> 'alpha');
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * People with accounts in communities at Get Satisfaction
	 *
	 * @return this
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_GET_LIST);
	}
	
	/**
	 * Goes to page 3 of the people list, showing 10 people. 
	 * (A limit of 30 is max.)
	 *
	 * @return this
	 */
	public function getList($page, $limit = NULL) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'integer')			//Argument 1 must be a string
			->argument(2, 'integer' ,'null');	//Argument 2 must be a string or null
		
		$query = array();
		
		return $this->_getResponse(self::URL_GET_LIST);
	}
	
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}