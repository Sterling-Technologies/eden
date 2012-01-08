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
class Eden_Twitter_Suggestions extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_SUGGESTION			= 'https://api.twitter.com/1/users/suggestions.json';
	const URL_GET_CATEGORY			= 'https://api.twitter.com/1/users/suggestions/twitter.json';
	const URL_GET_RECENT_STATUS		= 'https://api.twitter.com/1/users/suggestions/funny/members.json';

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
	 * Access to Twitter's suggested user list.
	 *
	 * @param lang is string
	 * @return $this
	 */
	 public function getSuggestion($lang = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null');			//Argument 1 must be a string or integer

		$query = array();
		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in our query	
			$query['lang'] = $lang;
		}

		return $this->_getResponse(self::URL_SUGGESTION, $query);
	 }
	 /**
	 * Access the users in a given category of the 
	 * Twitter suggested user list..
	 *
	 * @param slug is string
	 * @param lang is integer
	 * @return $this
	 */
	 public function getCategory($slug, $lang = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')				//Argument 1 must be a string 
			->argument(2, 'string', 'null');			//Argument 1 must be a string 

		$query = array('slug' => $slug);
		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in our query	
			$query['lang'] = $lang;
		}
	
		
		return $this->_getResponse(self::URL_GET_CATEGORY, $query);
	 }
	 /**
	 * Access the users in a given category of the Twitter suggested user 
	 * list and return their most recent status if they are not a protected user.
	 *
	 * @param slug is string
	 * @return $this
	 */
	 public function getRecentStatus($slug) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null');			//Argument 1 must be a string

		$query = array('slug' => $slug);
	
		return $this->_getResponse(self::URL_GET_RECENT_STATUS, $query);
	 }
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}