<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter notification
 *
 * @package    Eden
 * @category   Twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Notification extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_FOLLOW	= 'https://api.twitter.com/1/notifications/follow.json';
	const URL_LEAVE		= 'https://api.twitter.com/1/notifications/leave.json';
	
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
	 * Enables device notifications for updates 
	 * from the specified user. Returns the 
	 * specified user when successful.
	 *
	 * @param string|null
	 * @param integer|null
	 * @return array
	 */
	public function follow($name = NULL, $id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')	//Argument 1 must be a string or null
			->argument(2, 'int', 'null');	//Argument 2 must be a integer or null
		
		$query  = array();
		
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$query['screen_name'] = $name;
		}
		
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		
		$url = sprintf(self::URL_FOLLOW, $name);
		return $this->_post($url,$query);
	}
	
	/**
	 * Disables notifications for updates from the
	 * specified user to the authenticating user. 
	 * Returns the specified user when successful.
	 *
	 * @param string|null
	 * @param integer|null
	 * @return array
	 */
	public function leave($name = NULL, $id = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')	//Argument 1 must be a string or null
			->argument(2, 'int', 'null');	//Argument 2 must be a integer or null
		
		$query  = array();
		
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$query['screen_name'] = $name;
		}
		
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in query
			$query['user_id'] = $id;
		}
		
		$url = sprintf(self::URL_LEAVE, $name);
		return $this->_post($url,$query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}