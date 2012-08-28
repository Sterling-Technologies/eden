<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter favorites
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Favorites extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_FAVORITES		= 'https://api.twitter.com/1/favorites.json';
	const URL_FAVORITE_STATUS	= 'https://api.twitter.com/1/favorites/create/%s.json';
	const URL_UNFAVORITE_STATUS	= 'https://api.twitter.com/1/favorites/destroy/%s.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/ 
	/**
	 * Favorites the status specified in the ID parameter as
	 * the authenticating user.
	 *
	 * @param int the tweet ID
	 * @param bool
	 * @return array
	 */
	public function add($id, $entities = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')	//Argument 1 must be an integer
			->argument(2, 'bool');	//Argument 2 must be a boolean

		$query = array('id' => $id);
		
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
		$url = sprintf(self::URL_FAVORITE_STATUS, $id);
		return $this->_post($url, $query);
	}
	
	/**
	 * Returns the 20 most recent favorite statuses for the authenticating 
	 * user or user specified by the ID parameter in the requested format.
	 *
	 * @param bool
	 * @param string|int|null
	 * @param int|null
	 * @param int|null
	 * @return array
	 */
	public function getList($entities = false, $id = NULL, $since = NULL, $page = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'bool')					//Argument 1 must be a boolean
			->argument(2, 'int', 'string', 'null')	//Argument 2 must be a string, integer or null
			->argument(3, 'int', 'null')			//Argument 3 must be an integer or null
			->argument(4, 'int', 'null');			//Argument 4 must be an integer or null
			
		$query = array();
		
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		
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
		
		return $this->_getResponse(self::URL_GET_FAVORITES, $query);
	 }
	 
	/**
	 * Un-favorites the status specified in the ID 
	 * parameter as the authenticating user. 
	 *
	 * @param int the tweet ID
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be na integer
		Eden_Twitter_Error::i()->argument(1, 'int');						

		$query = array('id' => $id);
		
		$url = sprintf(self::URL_UNFAVORITE_STATUS, $id);
		return $this->_post($url, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}