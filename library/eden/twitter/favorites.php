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
	const URL_GET_FAVORITES		= 'https://api.twitter.com/1.1/favorites/list.json';
	const URL_FAVORITE_STATUS	= 'https://api.twitter.com/1.1/favorites/create.json';
	const URL_UNFAVORITE_STATUS	= 'https://api.twitter.com/1.1/favorites/destroy.json';

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
	 * @param int The numerical ID of the desired status.
	 * @return array
	 */
	public function addFavorites($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_query['id'] = $id;
		
		return $this->_post(self::URL_FAVORITE_STATUS, $this->_query);
	}
	
	/**
	 * Returns the 20 most recent favorite statuses for the authenticating 
	 * user or user specified by the ID parameter in the requested format.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_GET_FAVORITES, $this->_query);
	 }
	 
	/**
	 * Un-favorites the status specified in the ID 
	 * parameter as the authenticating user. 
	 *
	 * @param int The numerical ID of the desired status.
	 * @return array
	 */
	public function remove($id) {
		//Argument 1 must be na integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_query['id'] = $id;
		
		return $this->_post(self::URL_UNFAVORITE_STATUS, $this->_query);
	}
	
	/**
	 * The ID of the user for whom to return results for. Either an 
	 * id or screen_name is required for this method. 
	 *
	 * @param int|string
	 * @return this
	 */
	public function setUserId($id) {
		//Argument 1 must be na integer
		Eden_Twitter_Error::i()->argument(1, 'int', 'string');
		
		//if id is integer
		if(is_int($id)) {
			$this->_query['user_id'] = $id;
		} else {
			$this->_query['screen_name'] = $id;
		}
		
		return $this;
	}
	
	/**
	 * Specifies the number of records to retrieve. Must be less than
	 * or equal to 200. Defaults to 20.
	 *
	 * @param int|string
	 * @return this
	 */
	public function setCount($count) {
		//Argument 1 must be na integer
		Eden_Twitter_Error::i()->argument(1, 'int', 'string');
		$this->_query['count'] = $count;
		
		return $this;
	}
	
	/**
	 * Returns results with an ID greater than (that is, more recent than) the specified ID. 
	 * There are limits to the number of Tweets which can be accessed through the API. If 
	 * the limit of Tweets has occured since the since_id, the since_id will be forced 
	 * to the oldest ID available.
	 *
	 * @param integer
	 * @return this
	 */
	public function setSinceId($sinceId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['since_id'] = $sinceId;
		
		return $this;
	}
	
	/**
	 * Returns results with an ID less than (that is, older than) or 
	 * equal to the specified ID.
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxId($maxId) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['max_id'] = $maxId;
		
		return $this;
	}
	
	/**
	 * Specifies the page of results to retrieve.
	 *
	 * @param integer
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be an integer 
		Eden_Twitter_Error::i()->argument(1, 'int');
		$this->_query['page'] = $page;
		
		return $this;
	}
	
	/**
	 * When set to either true, t or 1, each tweet will include a node called "entities,". 
	 * This node offers a variety of metadata about the tweet in a discreet structure, 
	 * including: user_mentions, urls, and hashtags. While entities are opt-in on 
	 * timelines at present, they will be made a default component of output in the 
	 * future. See Tweet Entities for more detail on entities.
	 *
	 * @return this
	 */
	public function includeEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}