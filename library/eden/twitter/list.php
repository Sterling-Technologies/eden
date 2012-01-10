<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Twitter_List extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_ALL_LIST			= 'https://api.twitter.com/1/lists/all.json';
	const URL_GET_STATUS		= 'https://api.twitter.com/1/lists/statuses.json';




	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	 /**
	 * Returns all lists the authenticating or specified user 
	 * subscribes to, including their own.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function getList($id = NULL, $name = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int','string','null')			//Argument 1 must be a string or integer
			->argument(2, 'int','string','null');			//Argument 2 must be a string or integer
			
		$query = array();
		
		//if it is not empty
		if(!is_null($id)) {
			//if it is integer
			if(is_int($id)) {
				//lets put it in our query	
				$query['user_id'] = $id;
			}
			//if it is string
			if(is_string($id)) {
				//lets put it in our query	
				$query['screen_name'] = $id;
			}
		}
		//if it is not empty
		if(!is_null($name)) {
			//if it is string
			if(is_string($name)) {
				//lets put it in our query	
				$query['screen_name'] = $name;
			}
			//if it is integer
			if(is_int($name)) {
				//lets put it in our query	
				$query['user_name'] = $name;
			}
		}
			
		return $this->_getResponse(self::URL_ALL_LIST, $query);
	 } 
	 /**
	 * Returns tweet timeline for members of the specified list.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 
	 public function getStatus($id, $slug, $ownerName = NULL, $ownerId = NULL, $since = NULL, $max = NULL, $perpage = NULL, $entities = NULL, $rts = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')							//Argument 1 must be a string or integer
			->argument(2, 'string')					//Argument 2 must be a string or integer
			->argument(3, 'int','string','null')			//Argument 2 must be a string or integer
			->argument(4, 'int','null')						//Argument 2 must be a string or integer
			->argument(5, 'int','null')						//Argument 2 must be a string or integer
			->argument(6, 'int','null')						//Argument 2 must be a string or integer
			->argument(7, 'int','null')						//Argument 2 must be a string or integer
			->argument(8, 'boolean','null')					//Argument 2 must be a string or integer
			->argument(9, 'boolean','null');				//Argument 2 must be a string or integer
				
		$query = array('list_id' => $id,
					   'slug' => $slug);
		//if it is not empty
		if(!is_null($ownerName)) {
			//lets put it in our query	
			$query['owner_name'] = $ownerName;
		}
		//if it is not empty
		if(!is_null($ownerId)) {
			//lets put it in our query	
			$query['owner_id'] = $ownerId;
		}
		//if it is not empty
		if(!is_null($since)) {
			//lets put it in our query	
			$query['since_id'] = $since;
		}
		//if it is not empty
		if(!is_null($max)) {
			//lets put it in our query	
			$query['max_id'] = $max;
		}
		//if it is not empty
		if(!is_null($perpage)) {
			//lets put it in our query	
			$query['per_page'] = $perpage;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if rts
		if($rts) {
			$query['rts'] = 1;
		}
			
		return $this->_getResponse(self::URL_GET_STATUS, $query);
	 }
	 */
	
	
	
	
	
	
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}