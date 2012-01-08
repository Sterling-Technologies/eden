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
class Eden_Twitter_Favorites extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_FAVORITES				= 'https://api.twitter.com/1/favorites.json';
	const URL_FAVORITE_STATUS			= 'https://api.twitter.com/1/favorites/create/%s.json';
	const URL_UNFAVORITE_STATUS			= 'https://api.twitter.com/1/favorites/destroy/%s.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($key, $secret) {
		return self::_getMultiple(__CLASS__, $key, $secret);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	 /**
	 * Returns the 20 most recent favorite statuses for the authenticating 
	 * user or user specified by the ID parameter in the requested format.
	 *
	 * @param id is string or integer
	 * @param since is integer
	 * @param page is integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function getList($id = NULL, $since = NULL, $page = NULL, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int', 'string', 'null')		//Argument 1 must be a string or integer
			->argument(2, 'int', 'null')				//Argument 1 must be an integer
			->argument(3, 'int', 'null')				//Argument 4 must be an integer
			->argument(4, 'boolean');					//Argument 4 must be a boolean

		$query = array();
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in our query	
			$query['id'] = $id;
		}
		//if it is not empty
		if(!is_null($since)) {
			//lets put it in our query	
			$query['since_id'] = $since;
		}
		//if it is not empty
		if(!is_null($page)) {
			//lets put it in our query	
			$query['page'] = $page;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		return $this->_getResponse(self::URL_GET_FAVORITES, $query);
	 }
	 /**
	 * Favorites the status specified in the ID parameter as the authenticating 
	 * user. Returns the favorite status when successful.
	 *
	 * @param id is integer
	 * @param entities is boolean
	 * @return $this
	 */
	 public function addFavorite($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')						//Argument 1 must be an integer
			->argument(2, 'boolean');					//Argument 2 must be a boolean

		$query = array('id' => $id);
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		$url = sprintf(self::URL_FAVORITE_STATUS, $id);
		return $this->_post($url, $query);
	 }
	 /**
	 * n-favorites the status specified in the ID parameter as the authenticating user.
	 *
	 * @param id is integer
	 * @return $this
	 */
	 public function removeFavorite($id) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int');						//Argument 1 must be na integer

		$query = array('id' => $id);
		
		$url = sprintf(self::URL_UNFAVORITE_STATUS, $id);
		return $this->_post($url, $query);
	 }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}