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
class Eden_GetSatisfaction_Company extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.getsatisfaction.com/companies.json';
	const URL_GET_USER		= 'http://api.getsatisfaction.com/people/%s/companies.json';
	const URL_GET_PRODUCT	= 'http://api.getsatisfaction.com/products/%s/companies.json';
	const URL_GET_COMPANY	= 'http://api.getsatisfaction.com/companies/%s/last_activity_at.json';
	const URL_SEARCH		= 'http://api.getsatisfaction.com?query=%s.json';
	
	
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
	 * Get all the public Get Satisfaction communities   
	 *
	 * @param show is string
	 * @param sort is string
	 * @return this
	 */
	public function getList($show = NULL, $sort = NULL) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'string' ,'null')		//Argument 1 must be a string or null
			->argument(2, 'string' ,'null');	//Argument 2 must be a string or null
		
		$query = array();
		
		//if the show is a short version of a valid show
		if(isset($this->_validShow[$show])) {
			//make show the long version
			$filter = $this->_validShow[$show];
			//lets set show to show
			$query['show'] = $show;

		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validSort[$sort])) {
			//make filter the long version
			$filter = $this->_validSort[$sort];
			//lets set sort to sort
			$query['sort'] = $sort;

		}
		
		return $this->_getResponse(self::URL_GET_LIST, $query);
	}
	
	/**
	 * Get all the public Get Satisfaction 
	 * communities created by the specified user 
	 *
	 * @param name is string
	 * @param id is integer
	 * @param show is string
	 * @param sort is string
	 * @return this
	 */
	public function getUser($name = NULL, $id = NULL, $show = NULL, $sort = NULL) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'string' ,'null')		//Argument 1 must be a string or null
			->argument(2, 'integer' ,'null')	//Argument 2 must be a integer or null
			->argument(3, 'string' ,'null')		//Argument 3 must be a string or null
			->argument(4, 'string' ,'null');	//Argument 2 must be a string or null
		
		$query = array();
		
		//if name is not empty
		if(!is_null($name)) {
			//lets set user name to user
			$query['user_name'] = $name;
		}
		//if id is not empty
		if(!is_null($id)) {
			//lets set user id to id
			$query['user_id'] = $id;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validShow[$show])) {
			//make show the long version
			$filter = $this->_validShow[$show];
			//lets set show to show
			$query['show'] = $show;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validSort[$sort])) {
			//make filter the long version
			$filter = $this->_validSort[$sort];
			//lets set sort to sort
			$query['sort'] = $sort;
		}
		
		return $this->_getResponse(self::URL_GET_USER, $query);
	}
	
	/**
	 * Get all the public Get Satisfaction communities  
	 * related to the specified product 
	 *
	 * @param name is string
	 * @param id is integer
	 * @param show is string
	 * @param sort is string
	 * @return this
	 */
	public function getUser($name = NULL, $id = NULL, $show = NULL, $sort = NULL) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'string' ,'null')		//Argument 1 must be a string or null
			->argument(2, 'integer' ,'null')	//Argument 2 must be a integer or null
			->argument(3, 'string' ,'null')		//Argument 3 must be a string or null
			->argument(4, 'string' ,'null');	//Argument 2 must be a string or null
		
		$query = array();
		
		//if name is not empty
		if(!is_null($name)) {
			//lets set user name to user
			$query['user_name'] = $name;
		}
		//if id is not empty
		if(!is_null($id)) {
			//lets set user id to id
			$query['user_id'] = $id;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validShow[$show])) {
			//make show the long version
			$filter = $this->_validShow[$show];
			//lets set show to show
			$query['show'] = $show;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validSort[$sort])) {
			//make filter the long version
			$filter = $this->_validSort[$sort];
			//lets set sort to sort
			$query['sort'] = $sort;
		}
		
		return $this->_getResponse(self::URL_GET_PRODUCT, $query);
	}
	
	/**
	 * Get the date and time of the last activity 
	 * in the specified community  
	 *
	 * @param name is string
	 * @param id is integer
	 * @param show is string
	 * @param sort is string
	 * @return this
	 */
	public function getUser($name = NULL, $id = NULL, $show = NULL, $sort = NULL) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'string' ,'null')		//Argument 1 must be a string or null
			->argument(2, 'integer' ,'null')	//Argument 2 must be a integer or null
			->argument(3, 'string' ,'null')		//Argument 3 must be a string or null
			->argument(4, 'string' ,'null');	//Argument 2 must be a string or null
		
		$query = array();
		
		//if name is not empty
		if(!is_null($name)) {
			//lets set user name to user
			$query['user_name'] = $name;
		}
		//if id is not empty
		if(!is_null($id)) {
			//lets set user id to id
			$query['user_id'] = $id;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validShow[$show])) {
			//make show the long version
			$filter = $this->_validShow[$show];
			//lets set show to show
			$query['show'] = $show;
		}
		
		//if the show is a short version of a valid show
		if(isset($this->_validSort[$sort])) {
			//make filter the long version
			$filter = $this->_validSort[$sort];
			//lets set sort to sort
			$query['sort'] = $sort;
		}
		
		return $this->_getResponse(self::URL_GET_COMPANY, $query);
	}
	
	/**
	 * Search for a particular string 
	 *
	 * @param search is string
	 * @return this
	 */
	public function search($search) {
		//Argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'string');		//Argument 1 must be a string
		
		$query = array('search' => $search);
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}