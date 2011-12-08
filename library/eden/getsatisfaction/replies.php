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
class Eden_GetSatisfaction_Replies extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.getsatisfaction.com/replies.json';
	const URL_GET_TOPICS	= 'http://api.getsatisfaction.com/topics/%s/replies.json';
	const URL_GET_USERS		= 'http://api.getsatisfaction.com/people/%s/replies.json';
	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected $_validFilters = array(
		'best'		=> 'best',
		'star'		=> 'star_promoted',
		'company'	=> 'company_promoted',
		'flat'		=> 'flat_promotion');
	
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
	 * Get all replies to all topics in all public Get Satisfaction communities  
	 *
	 * @return this
	 */
	public function getList($filter = NULL) {
		//Argument 1 must be a string or null
		Eden_Tumblr_Error::get()->argument(1, 'string' ,'null');		
		
		$query = array();
		
		//if the filter is a short version of a valid filter
		if(isset($this->_validFilters[$filter])) {
			//make filter the long version
			$filter = $this->_validFilters[$filter];
		}
		
		//if filter is valid
		if(in_array($filter, $this->_validFilters)) {
			//if filter is flat promotion
			if($filter == 'flat_promotion') {
				//lets set type to filter
				$query['type'] = $filter;
			//it is not a flat promotion
			} else {
				//lets set filter to filter
				$query['filter'] = $filter;
			}
		}
		
		return $this->_getResponse(self::URL_GET_LIST, $query);
	}
	
	/**
	 * Get all replies from the specified topic  
	 *
	 * @param id is integer
	 * @param slug is a string
	 * @return this
	 */
	 public function getTopics($id = NULL, $slug = NULL, $filter = NULL) {
		//argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'integer' ,'null')	//Argument 2 must be a integer or null
			->argument(2, 'string' ,'null')		//Argument 1 must be a string or null
			->argument(3, 'string' ,'null');	//Argument 3 must be a string or null
			
		$query = array();
		//if the id is not empty
		if(!is_null($id)) {
			//lets set topic id to id
			$query['topic_id'] = $id;
		}
		
		//if the slug is not empty
		if(!is_null($slug)) {
			//lets  set slug to slug
			$query['slug'] = $slug;
		}
		
		//if the filter is a short version of a valid filter
		if(isset($this->_validFilters[$filter])) {
			//make filter the long version
			$filter = $this->_validFilters[$filter];
		}
		
		//if filter is valid
		if(in_array($filter, $this->_validFilters)) {
			//if filter is flat promotion
			if($filter == 'flat_promotion') {
				//lets set type to filter
				$query['type'] = $filter;
			//it is not a flat promotion
			} else {
				//lets set filter to filter
				$query['filter'] = $filter;
			}
		}
		
		return $this->_getResponse(self::URL_GET_TOPICS, $query);
	}
	
	/**
	 * Get all replies that a particular user has posted  
	 *
	 * @param id is integer
	 * @return this
	 */
	public function getUserReplies($id, $filter = NULL) {
		//argument testing
		Eden_Tumblr_Error::get()
			->argument(1, 'integer')			//Argument 1 must be a integer
			->argument(2, 'string' ,'null');	//Argument 2 must be a string or null
		
		$query = array('user_id' => $id);
		//if the filter is a short version of a valid filter
		if(isset($this->_validFilters[$filter])) {
			//make filter the long version
			$filter = $this->_validFilters[$filter];
		}
		
		//if filter is valid
		if(in_array($filter, $this->_validFilters)) {
			//if filter is flat promotion
			if($filter == 'flat_promotion') {
				//lets set type to filter
				$query['type'] = $filter;
			//it is not a flat promotion
			} else {
				//lets set filter to filter
				$query['filter'] = $filter;
			}
		}
		
		return $this->_getResponse(self::URL_GET_USERS, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}