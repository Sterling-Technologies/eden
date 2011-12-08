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
class Eden_GetSatisfaction_Topic extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST				= 'http://api.getsatisfaction.com/topics/%s';
	const URL_GET_ALL_TOPICS		= 'http://api.getsatisfaction.com/topics.json';
	const URL_GET_PARTICULAR		= 'http://api.getsatisfaction.com/companies/%s/topics.json';
	const URL_GET_SPECIFIC			= 'http://api.getsatisfaction.com/products/%s/topics.json';
	const URL_GET_TOPICS_TAG		= 'http://api.getsatisfaction.com/companies/%s/tags/%s/topics.json';
	const URL_GET_USER_TOPICS		= 'http://api.getsatisfaction.com/people/%s/topics.json';
	const URL_GET_USER_FOLLOWING	= 'http://api.getsatisfaction.com/people/%s/followed/topics.json';
	const URL_GET_PRODUCT_TOPICS	= 'http://api.getsatisfaction.com/products/%s/topics.json';
	
	const URL_SEARCH				= 'http://api.getsatisfaction.com?query=%s';
	
	const URL_LAST_ACTIVITY			= 'http://api.getsatisfaction.com?active_since=%s';
	const URL_USER_ID				= 'http://api.getsatisfaction.com?user=%s';
	const URL_COMPANY_ID			= 'http://api.getsatisfaction.com?company=%s';
	const URL_PRODUCT_NAME			= 'http://api.getsatisfaction.com?product=%s';
	const URL_TAG					= 'http://api.getsatisfaction.com?tag=%s';
	const URL_STATUS				= 'http://api.getsatisfaction.com?status=%s';
	const URL_UDC					= 'http://api.getsatisfaction.com?user_defined_code=%s';

	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected $_validSort = array(
		'created'	=> 'recently_created',
		'active'	=> 'recently_active',
		'replies'	=> 'most_replies',
		'toos'		=> 'most_me_toos',
		'priority'	=> 'priority',
		'answered'	=> 'answered');
	
	protected $_validStyle = array('question','problem','praise','idea','update');
	
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
	 * Get a specific topic 
	 *
	 * @param topic is a string
	 * @param slug is a string
	 * @param id is a integer
	 * @return this
	 */
	public function getList($topic = NULL, $slug = NULL, $id = NULL) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'string' ,'null')				//Argument 1 must be a string or null
			->argument(2, 'string' ,'null')				//Argument 2 must be a string or null
			->argument(3, 'integer' ,'null');			//Argument 3 must be a integer or null
			
		$query = array();
		//if it is not empty
		if(!is_null($topic)) {
			//lets put it in query
			$query['topic'] = $topic;
		}
		//if it is not empty
		if(!is_null($slug)) {
			//lets put it in query
			$query['slug'] = $slug;
		}
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in query
			$query['id'] = $id;
		}
		
		return $this->_getResponse(self::URL_GET_LIST, $query);
	}
	/**
	 * Get all topics in all public 
	 * Get Satisfaction communities 
	 *
	 * @return this
	 */
	public function getAll() {
		
		return $this->_getResponse(self::URL_GET_ALL_TOPICS);
	}
	/**
	 * Get all topics related to a specific 
	 * product in a particular community 
	 *
	 * @param id is a integer
	 * @param name is a string
	 * @return this
	 */
	public function getParticular($id = NULL, $name = NULL) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'integer', 'null')			//Argument 1 must be a integer or null
			->argument(2, 'string', 'null');			//Argument 2 must be a string or null
			
		$query = array();
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in query
			$query['company_id'] = $id;
		}
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$query['company_name'] = $name;
		}
		
		return $this->_getResponse(self::URL_GET_PARTICULAR, $query);
	}
	/**
	 * Get all topics related to a specific 
	 * product in a particular community  
	 * 
	 * @param id is a integer
	 * @param product is a string
	 * @param name is a string
	 * @return this
	 */
	public function getSpecific($id, $product, $name = NULL) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'integer')			//Argument 1 must be a integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string');			//Argument 3 must be a string
			
		$query = array('company_id' => $id, 'product_name' => $product);
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$query['company_name'] = $name;
		}
		
		return $this->_getResponse(self::URL_GET_SPECIFIC, $query);
	}
	/**
	 * Get all topics tagged with a specific 
	 * tag within a particular community 
	 * 
	 * @param id is a integer
	 * @param product is a string
	 * @param name is a string
	 * @return this
	 */
	public function getTopicsTag($id, $tag, $name = NULL) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'integer')			//Argument 1 must be a integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string');			//Argument 3 must be a string
			
		$query = array('company_id' => $id, 'product_name' => $product);
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$query['company_name'] = $name;
		}
		
		return $this->_getResponse(self::URL_GET_TOPICS_TAG, $query);
	}
	/**
	 * Get all topics that a particular user has posted  
	 * (*there is a question about how these numbers are calculated)
	 * 
	 * @param id is a integer
	 * @return this
	 */
	public function getUserTopics($id) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'integer');			//Argument 1 must be a integer
			
		$query = array('id' => $id);
		
		return $this->_getResponse(self::URL_GET_USER_TOPICS, $query);
	}
	/**
	 * Get all topics that a particular user is following
	 * 
	 * @param id is a integer
	 * @return this
	 */
	public function getUserFollowing($id) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'integer');			//Argument 1 must be a integer
			
		$query = array('id' => $id);
		
		return $this->_getResponse(self::URL_GET_TOPICS_TAG, $query);
	}
	/**
	 * Get all topics identified with a specific product
	 * 
	 * @param name is a string
	 * @return this
	 */
	public function getProductTopics($name) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'string');			//Argument 1 must be a string
			
		$query = array('product_name' => $name);
		
		return $this->_getResponse(self::URL_GET_PRODUCT_TOPICS, $query);
	}
	 /**
	 * Search for a particular string
	 * 
	 * @param searh is a string
	 * @return this
	 */
	public function search($search) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'string');			//Argument 1 must be a string
			
		$query = array('searh' => $searh);
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	/**
	 * Sort 
	 * 
	 * @return this
	 */
	public function sort($sort = NULL) {
		//Argument Test
		Eden_Tumblr_Error::get()
			->argument(1, 'string');			//Argument 1 must be a string
			
		$query = array();
		//if the sort is a short version of a valid sort
		if(isset($this->_validSort[$sort])) {
			//make sort the long version
			$sort = $this->_validSort[$sort];
			//lets set sort to sort
			$query['sort'] = $sort;
		}
		
		return $this->_getResponse(self::URL_TOPICS_CREATED);
	}
	//////////////////////////////////////////////////////
	public function sortStyle($style) {
		//Argumement
		Eden_Tumblr_Error::get()
			->argument(1, 'string');
			
		$query = array();
		//if the style is a short version of a valid style
		if(isset($this->_validStyle[$style])) {
			//make style the long style
			$sort = $this->_validStyle[$style];
			//lets set style to style
			$query['style'] = $style;
		}
	}
	
	/**
	 * Filter by the time of the last activity in 
	 * the community. Time is set in seconds since epoch. 
	 * 
	 * @return this
	 */
	 public function filterLastActivity() {
	
		return $this->_getResponse(self::URL_LAST_ACTIVITY);
	 }
	/**
	 * Filter by user ID 
	 * 
	 * @return this
	 */
	 public function filterUser() {
	
		return $this->_getResponse(self::URL_USER_ID);
	 }
	/**
	 * Filter by company ID  
	 * 
	 * @return this
	 */
	 public function filterCompany() {
	
		return $this->_getResponse(self::URL_COMPANY_ID);
	 }
	/**
	 * Filter by product name   
	 * 
	 * @return this
	 */
	 public function filterProduct() {
	
		return $this->_getResponse(self::URL_PRODUCT_NAME);
	 }
	/**
	 * Filter by tag   
	 * 
	 * @return this
	 */
	 public function filterTag() {
	
		return $this->_getResponse(self::URL_TAG);
	 }
	/**
	 * Filter by status   
	 * 
	 * @return this
	 */
	 public function filterStatus() {
	
		return $this->_getResponse(self::URL_STATUS);
	 }
	 /**
	 * Filter by User Defined Code   
	 * 
	 * @return this
	 */
	 public function filterUdc() {
	
		return $this->_getResponse(self::URL_UDC);
	 }
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}