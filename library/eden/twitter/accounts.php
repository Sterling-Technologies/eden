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
class Eden_Twitter_Accounts extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_LIMIT_STATUS			= 'https://api.twitter.com/1/account/rate_limit_status.json';
	const URL_VERIFY_CREDENTIALS	= 'https://api.twitter.com/1/account/verify_credentials.json';
	const URL_END_SESSION			= 'https://api.twitter.com/1/account/end_session.json';
	const URL_UPDATE_PROFILE		= 'https://api.twitter.com/1/account/update_profile.json';
	const URL_UPDATE_BACKGROUND		= 'https://api.twitter.com/1/account/update_profile_background_image.json';
	const URL_UPDATE_PROFILE_COLOR	= 'https://api.twitter.com/1/account/update_profile_colors.json';
	


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
	 * Returns the remaining number of API requests available to the 
	 * requesting user before the API limit is reached for the current hour.
	 *
	 * @return $this
	 */
	 public function getLimit() {
			
		return $this->_getResponse(self::URL_LIMIT_STATUS);
	 } 
	 /**
	 * Returns an HTTP 200 OK response code and a representation of the requesting user 
	 * if authentication was successful; returns a 401 status code and an error message if not. 
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function getCredentials($entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'boolean')			//Argument 1 must be a string or integer
			->argument(2, 'boolean');			//Argument 2 must be a string or integer
			
		$query = array();
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
			
		return $this->_getResponse(self::URL_VERIFY_CREDENTIALS, $query);
	 }
	 /**
	 * Ends the session of the authenticating user, returning a null cookie. 
	 * Use this method to sign users out of client-facing applications like widgets.
	 *
	 * @return $this
	 */
	 public function logOut() {
			
		return $this->_post(self::URL_END_SESSION);
	 }
	 /**
	 * Sets values that users are able to set under the "Account" tab 
	 * of their settings page. Only the parameters specified will be updated.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function updateProfile($name = NULL, $url = NULL, $location = NULL, $description = NULL, $entities = NULL, $status = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string or integer
			->argument(2, 'string')			//Argument 1 must be a string or integer
			->argument(3, 'string')			//Argument 1 must be a string or integer
			->argument(4, 'string')			//Argument 1 must be a string or integer
			->argument(5, 'boolean')			//Argument 1 must be a string or integer
			->argument(8, 'boolean');			//Argument 2 must be a string or integer
			
		$query = array();
		//if it is not empty
		if(!is_null($name) && $name <= 20) {
			//lets put it in query
			$query['name'] = $name;
		}
		//if it is not empty
		if(!is_null($url) && $url <= 100) {
			//lets put it in query
			$query['url'] = $url;
		}
		//if it is not empty
		if(!is_null($location) && $location <= 30) {
			//lets put it in query
			$query['location'] = $location;
		}
		//if it is not empty
		if(!is_null($description) && $description <= 160) {
			//lets put it in query
			$query['description'] = $description;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
			
		return $this->_post(self::URL_UPDATE_PROFILE, $query);
	 }
	 /**
	 * Sets values that users are able to set under the "Account" tab 
	 * of their settings page. Only the parameters specified will be updated.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function updateBackground($image = NULL, $tile = NULL, $entities = NULL, $status = NULL, $use = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string 
			->argument(2, 'string')			//Argument 1 must be a string 
			->argument(3, 'boolean')		//Argument 1 must be a boolean
			->argument(4, 'boolean')		//Argument 1 must be a boolean
			->argument(5, 'boolean');		//Argument 1 must be a boolean
			
		$query = array();
		//if it is not empty
		if(!is_null($image)) {
			//lets put it in query
			$query['image'] = $image;
		}
		//if it is not empty
		if(!is_null($tile)) {
			//lets put it in query
			$query['tile'] = $tile;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
		//if status
		if($use) {
			$query['use'] = 1;
		}
			
		return $this->_post(self::URL_UPDATE_BACKGROUND, $query);
	 }
	 /**
	 * Sets values that users are able to set under the "Account" tab 
	 * of their settings page. Only the parameters specified will be updated.
	 *
	 * @param name is string
	 * @param size is integer
	 * @return $this
	 */
	 public function updateColor($background = NULL, $link = NULL, $border = NULL, $fill = NULL, $text = NULL, $entities = false, $status = false) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string 
			->argument(2, 'string')			//Argument 1 must be a string 
			->argument(3, 'string')			//Argument 1 must be a string
			->argument(4, 'string')			//Argument 1 must be a string
			->argument(5, 'string')			//Argument 1 must be a string
			->argument(6, 'boolean')		//Argument 1 must be a boolean
			->argument(7, 'boolean');		//Argument 1 must be a boolean
			
		$query = array();
		//if it is not empty
		if(!is_null($background)) {
			//lets put it in query
			$query['profile_background_color'] = $background;
		}
		//if it is not empty
		if(!is_null($link)) {
			//lets put it in query
			$query['profile_link_color'] = $link;
		}
		//if it is not empty
		if(!is_null($border)) {
			//lets put it in query
			$query['profile_sidebar_border_color'] = $border;
		}
		//if it is not empty
		if(!is_null($fill)) {
			//lets put it in query
			$query['profile_sidebar_fill_color'] = $fill;
		}
		//if it is not empty
		if(!is_null($text)) {
			//lets put it in query
			$query['profile_text_color '] = $text;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
		//if status
		if($status) {
			$query['skip_status'] = 1;
		}
			
		return $this->_post(self::URL_UPDATE_PROFILE_COLOR, $query);
	 }
	 
	 
	




























	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	 
	 
}