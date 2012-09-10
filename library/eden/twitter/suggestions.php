<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter suggestion
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Suggestions extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_CATEGORY		= 'https://api.twitter.com/1.1/users/suggestions/%s.json';
	const URL_FAVORITES			= 'https://api.twitter.com/1.1/favorites/list.json';
	const URL_SUGGESTIONS		= 'https://api.twitter.com/1/users/suggestions/%s/members.json';

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
	 * Access the users in a given category of the 
	 * Twitter suggested user list.
	 *
	 * @param string
	 * @param string|null
	 * @return array
	 */
	public function getCategory($slug, $lang = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string 
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null 

		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in our query	
			$this->_query['lang'] = $lang;
		}
		
		return $this->_getResponse(sprintf(self::URL_GET_CATEGORY, $slug), $this->_query);
	}
	
	/**
	 * Returns the 20 most recent Tweets favorited by the authenticating or specified user.
	 *
	 * @param string|integer|null
	 * @return array
	 */
	public function getFavorites($id = NULL) {
		//Argument 1 must be a string , integer or null
		Eden_Twitter_Error::i()->argument(1, 'string', 'int', 'null');				

		//if it is integet
		if(is_int($id)) {
			//lets put it in our query	
			$this->_query['user_id'] = $id;
		}
		
		//if it is string
		if(is_string($id)) {
			//lets put it in our query	
			$this->_query['screen_name'] = $id;
			
		}
		
		return $this->_getResponse(self::URL_FAVORITES, $this->_query);
	}
	
	/**
	 * Access the users in a given category of the Twitter suggested user list 
	 * and return their most recent status if they are not a protected user.
	 *
	 * @param string
	 * @return array
	 */
	public function getUserByStatus($slug) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_SUGGESTIONS, $slug));
	}
	
	/**
	 * Set count
	 *
	 * @param integer
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be a integer
		Eden_Twitter_Error::i()->argument(1, 'int');				

		$this->_query['count'] = $count;
	
		return $this;
	}
	
	/**
	 * Set Since Id
	 *
	 * @param integer
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be a integer
		Eden_Twitter_Error::i()->argument(1, 'int');				

		$this->_query['since_id'] = $sinceId;
	
		return $this;
	}
	
	/**
	 * Set Max Id
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxId($maxId) {
		//Argument 1 must be a integer
		Eden_Twitter_Error::i()->argument(1, 'int');				

		$this->_query['max_id'] = $maxId;
	
		return $this;
	}
	
	/**
	 * The entities node will be omitted when set to false
	 *
	 * @return this
	 */
	public function includeEntities() {				
		$this->_query['include_entities'] = false;
	
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}