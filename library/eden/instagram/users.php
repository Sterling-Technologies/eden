<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Users
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Users extends Eden_Instagram {
	/* Constants
	-------------------------------*/
	const API_URL			= 'https://api.instagram.com/v1';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_access_token	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($access_token) {
		//argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
			
		$this->_access_token 	= $access_token;
	}

	/* Public Methods
	-------------------------------*/

	/**
	 * Get basic information about a user.
	 * @param  Integer $user_id User's Instagram User ID
	 * @return Array          User's Information
	 */
	public function get($user_id)
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * See the authenticated user's feed.
	 * @return Array User's Instagram feed
	 */
	public function feed()
	{
		$url = $this->_buildurl(self::API_URL . "/users/self/feed", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Get the most recent media published by a user.
	 * @param  Integer $user_id User's Instagram User ID
	 * @param  Array $params  Parameters to define the result set (http://instagram.com/developer/endpoints/users/#get_users_media_recent)
	 * @return Array          Results
	 */
	public function recent($user_id, $params = array())
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/media/recent", array_merge(array(
			'access_token' => $this->_access_token
		), $params));
		return $this->_get($url);
	}

	/**
	 * See the authenticated user's list of media they've liked. Note that this list is ordered by the order in which the user liked the media.
	 * Private media is returned as long as the authenticated user has permission to view that media. Liked media lists are only available
	 * for the currently authenticated user.
	 * @return Array	User's liked media
	 */
	public function liked()
	{
		$url = $this->_buildurl(self::API_URL . "/users/self/media/liked", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Search for a user by name
	 * @param  String $query Query string to search by
	 * @param  Integer $count Number of results to return
	 * @return Array        Results
	 */
	public function search($query, $count)
	{
		$url = $this->_buildurl(self::API_URL . "/users/search", array(
			'access_token' => $this->_access_token,
			'q' => $query,
			'count' => $count
		));
		return $this->_get($url);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}