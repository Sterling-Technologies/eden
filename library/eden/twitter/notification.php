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
 * @category   twitter
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
	 * @param string|int user ID or screen name
	 * @return array
	 */
	public function follow($id) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');	
		
		$query  = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
		
		return $this->_post(self::URL_FOLLOW, $query);
	}
	
	/**
	 * Disables notifications for updates from the
	 * specified user to the authenticating user. 
	 * Returns the specified user when successful.
	 *
	 * @param string|int user ID or screen name
	 * @return array
	 */
	public function leave($id) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');	
		
		$query  = array();
		
		//if it is integer
		if(is_int($id)) {
			//lets put it in our query
			$query['user_id'] = $id;
		//else it is string
		} else {
			//lets put it in our query
			$query['screen_name'] = $id;
		}
		
		return $this->_post(self::URL_LEAVE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}