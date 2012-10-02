<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Relationships
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Relationships extends Eden_Instagram {
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
			->argument(1, 'string');	//Argument 1 must be a string

		$this->_access_token 	= $access_token;
	}

	/* Public Methods
	-------------------------------*/
	
	/**
	 * Get the list of users this user follows
	 * Required scope: relationships
	 * @param  Integer $user_id User ID to get follow list
	 * @return Array          Array of users the user follows
	 */
	public function follows($user_id)
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/folows", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Get the list of users this user is followed by.
	 * Required scope: relationships
	 * @param  Integer $user_id User ID to get followed by list
	 * @return Array          Array of users that is following the user
	 */
	public function followedby($user_id)
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/followed-by", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * List the users who have requested this user's permission to follow.
	 * Required scope: relationships
	 * @param  Integer $user_id User ID to get requested by list
	 * @return Array          Array of users that has requested to follow this user
	 */
	public function requestedby($user_id)
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/requested-by", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Get information about a relationship to another user.
	 * Required scope: relationships
	 * @param  Integer $user_id User ID to return relationship information with
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function relationship($user_id)
	{
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/relationship", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Make current user follow another user
	 * Required scope: relationships
	 * @param  Integer $user_id User to follow
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function follow($user_id)
	{
		return $this->_postRelationship('follow', $user_id);
	}

	/**
	 * Unfollow another user
	 * Required scope: relationships
	 * @param  Integer $user_id User to unfollow
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function unfollow($user_id)
	{
		return $this->_postRelationship('unfollow', $user_id);
	}

	/**
	 * Block another user
	 * Required scope: relationships
	 * @param  Integer $user_id User to block
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function block($user_id)
	{
		return $this->_postRelationship('block', $user_id);
	}

	/**
	 * Unblock another user
	 * Required scope: relationships
	 * @param  Integer $user_id User to unblock
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function unblock($user_id)
	{
		return $this->_postRelationship('unblock', $user_id);
	}

	/**
	 * Approve another user's follow request
	 * Required scope: relationships
	 * @param  Integer $user_id User to approve
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function approve($user_id)
	{
		return $this->_postRelationship('approve', $user_id);
	}

	/**
	 * Deny another user's follow request
	 * Required scope: relationships
	 * @param  Integer $user_id User to deny
	 * @return Array          Request response, with outgoing_status (follows, requested, none)
	 * or incoming_status (followed by, requested by, blocked by you, none)
	 */
	public function deny($user_id)
	{
		return $this->_postRelationship('deny', $user_id);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/

	/**
	 * Function called by relationship-action methods above (follow/unfollow/block/unblock/approve/deny)
	 * @param  String $action  Type of action
	 * @param  Integer $user_id Instagram User ID to implement action on
	 * @return ARray          Request response
	 */
	private function _postRelationship($action, $user_id)
	{	
		$url = $this->_buildurl(self::API_URL . "/users/{$user_id}/relationship", array(
			'access_token' => $this->_access_token
		));

		return $this->_post($url, array(
			'action' => $action
		));
	}
}