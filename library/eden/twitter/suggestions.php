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
	const URL_SUGGESTION		= 'https://api.twitter.com/1/users/suggestions.json';
	const URL_GET_CATEGORY		= 'https://api.twitter.com/1/users/suggestions/twitter.json';
	const URL_GET_RECENT_STATUS	= 'https://api.twitter.com/1/users/suggestions/funny/members.json';

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

		$this->_query['slug'] = $slug;
		
		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in our query	
			$this->_query['lang'] = $lang;
		}
		
		return $this->_getResponse(self::URL_GET_CATEGORY, $this->_query);
	}
	
	/**
	 * Access the users in a given category of the Twitter 
	 * suggested user list and return their most recent 
	 * status if they are not a protected user.
	 *
	 * @param string
	 * @return array
	 */
	public function getRecentStatus($slug) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');			

		$this->_query['slug'] = $slug;
	
		return $this->_getResponse(self::URL_GET_RECENT_STATUS, $this->_query);
	}
	
	/**
	 * Access to Twitter's suggested user list.
	 *
	 * @param string|null
	 * @return array
	 */
	public function getSuggestion($lang = NULL) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string', 'null');			

		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in our query	
			$this->_query['lang'] = $lang;
		}

		return $this->_getResponse(self::URL_SUGGESTION, $this->_query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}