<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square list
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_List extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST_ADD 					= 'https://api.foursquare.com/v2/lists/add';
	const URL_LIST_UPDATE				= 'https://api.foursquare.com/v2/lists/%s/update';
	const URL_LIST_SUGGEST_PHOTO 		= 'https://api.foursquare.com/v2/lists/%s/suggestphoto';
	const URL_LIST_SUGGEST_TIPS 		= 'https://api.foursquare.com/v2/lists/%s/suggesttip';
	const URL_LIST_SUGGEST_VENUES		= 'https://api.foursquare.com/v2/lists/%s/suggestvenues';
	const URL_LIST_ADD_ITEM				= 'https://api.foursquare.com/v2/lists/%s/additem';
	const URL_LIST_DELETE_ITEM			= 'https://api.foursquare.com/v2/lists/%s/deleteitem';
	const URL_LIST_UPDATE_ITEM			= 'https://api.foursquare.com/v2/lists/%s/updateitem';
	const URL_LIST_MOVE_ITEM			= 'https://api.foursquare.com/v2/lists/%s/moveitem';
	const URL_LIST_FOLLOWERS 			= 'https://api.foursquare.com/v2/lists/%s/followers';
	const URL_LIST_FOLLOW				= 'https://api.foursquare.com/v2/lists/%s/follow';
	const URL_LIST_UNFOLLOW				= 'https://api.foursquare.com/v2/lists/%s/unfollow';
	const URL_LIST_SHARE				= 'https://api.foursquare.com/v2/lists/%s/share';
	
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
	
	public function __construct($token) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Where to broadcast this list. Send twitter if you want to send to twitter, 
	 * facebook if you want to send to facebook, or twitter,facebook if 
	 * you want to send to both.
	 * 
	 * @param string
	 * @return this
	 */
	public function broadcast($broadcast) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		
		//if the input value is not allowed
		if(!in_array($broadcast, array('facebook', 'twitter'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_BROADCAST_LIST) 
				->addVariable($broadcast)
				->trigger();
		}
		$this->_query['broadcast'] = $broadcast;
		
		return $this;
	}
	
	/**
	 * A personal note to include with the share.
	 * 
	 * @param string
	 * @return this
	 */
	public function setMessage($message) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');			
		$this->_query['message'] = $message;
		
		return $this;
	}
	
	/**
	 * The url of the homepage of the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['url'] = $url;
		
		return $this;
	}
	
	/**
	 * Move itemId before beforeId.
	 * 
	 * @param string
	 * @return this
	 */
	public function setBeforeId($beforeId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['beforeId'] = $beforeId;
		
		return $this;
	}
	
	/**
	 * Move itemId after afterId.
	 * 
	 * @param string
	 * @return this
	 */
	public function setAfterId($afterId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['afterId'] = $afterId;
		
		return $this;
	}
	
	/**
	 * If the target is a user-created list, this will create 
	 * a public tip on the venue. If the target is /userid/todos, 
	 * the text will be a private note that is only visible to the author.
	 * 
	 * @param string
	 * @return this
	 */
	public function setText($text) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['text'] = $text;
		
		return $this;
	}
	
	/**
	 * Used in conjuction with listId, the id of an item on that list that we wish to copy to this list.
	 * 
	 * @param string
	 * @return this
	 */
	public function setItemId($itemId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['itemId'] = $itemId;
		
		return $this;
	}
	
	/**
	 * Used in conjuction with itemId, the id for a user created or 
	 * followed list as well as one of USER_ID/tips, USER_ID/todos, or USER_ID/dones.
	 * 
	 * @param string
	 * @return this
	 */
	public function setListId($listId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['listId'] = $listId;
		
		return $this;
	}
	
	/**
	 * Used to add a tip to a list. Cannot be used in conjunction with the text and url fields.
	 * 
	 * @param string
	 * @return this
	 */
	public function setTipId($tipId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['tipId'] = $tipId;
		
		return $this;
	}
	
	/**
	 * A venue to add to the list.
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueId($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['venueId'] = $venueId;
		
		return $this;
	}
	
	/**
	 * The description of the list.
	 * 
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	/**
	 * If present and a non-empty value, updates the List name.
	 * 
	 * @param string
	 * @return this
	 */
	public function setListName($name) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['name'] = $name;
		
		return $this;
	}
	
	
	/**
	 * Set to can be edited by friends.
	 * 
	 * @return this
	 */
	public function setCollaborative() {
		$this->_query['collaborative'] = true;
		
		return $this;
	}
	
	/**
	 * The id of a photo that should be set as the list photo.
	 * 
	 * @param string
	 * @return this
	 */
	public function setPhotoId($photoId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['photoId'] = $photoId;
		
		return $this;
	}
	
	/**
	 * Allows users to create a new list. 
	 * 
	 * @param string The name of the list.
	 * @return array
	 */
	public function addlist($name) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['name'] = $name;
		
		return $this->_post(self::URL_LIST_ADD, $this->_query);
	}	
	
	/**
	 * Returns a count and items of users following this list. 
	 * 
	 * @param string Id for a user-created list
	 * @return array
	 */
	public function getFollowers($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_LIST_FOLLOWERS, $listId));
	}
	
	/**
	 * Suggests photos that may be appropriate for this item.  
	 * 
	 * @param string Id for a user-created list
	 * @param string Id of item on this list.
	 * @return array
	 */
	public function suggestPhoto($listId, $itemId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_getResponse(sprintf(self::URL_LIST_SUGGEST_PHOTO, $listId), $this->_query);
	}
	
	/**
	 * Suggests tips that may be appropriate for this item.  
	 * 
	 * @param string Id for a user-created list
	 * @param string Id of item on this list.
	 * @return array
	 */
	public function suggestTips($listId, $itemId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_getResponse(sprintf(self::URL_LIST_SUGGEST_TIPS, $listId), $this->_query);
	}
	
	/**
	 * Suggests venues may be appropriate for this item.  
	 * 
	 * @param string Id for a user-created list
	 * @return array
	 */
	public function suggestVenues($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_LIST_SUGGEST_VENUES, $listId));
	}
	
	/**
	 * Allows you to add an item to a list. All fields are optional, but exactly 
	 * one of the following must be specified: venueId, tipId, listId and itemId
	 * 
	 * @param string Id for a user-created list
	 * @return array
	 */
	public function addItem($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_LIST_ADD_ITEM, $listId), $this->_query);
	}
	
	/**
	 * Allows you to update items on user-created lists. 
	 * 
	 * @param string Id for a user-created list
	 * @param string The id of an item on this list.
	 * @return array
	 */
	public function updateItem($listId, $itemId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_post(sprintf(self::URL_LIST_UPDATE_ITEM, $listId), $this->_query);
	}
	
	/**
	 * Allows you to delete an item from a list. 
	 * 
	 * @param string Id for a user-created list or followed list or one of 
	 * USER_ID/tips, USER_ID/todos, or USER_ID/dones.
	 * @param string Id of the item to delete.
	 * @return array
	 */
	public function deleteItem($listId, $itemId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_post(sprintf(self::URL_LIST_DELETE_ITEM, $listId), $this->_query);
	}
	
	/**
	 * Allows you to move an item on a list. One of beforeId or afterId must be specified. 
	 * 
	 * @param string Id for a user-created list 
	 * @param string Id of the item to delete.
	 * @return array
	 */
	public function moveItem($listId, $itemId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_post(sprintf(self::URL_LIST_MOVE_ITEM, $listId), $this->_query);
	}
	
	/**
	 * Allows you to follow a list. 
	 * 
	 * @param string Id for a user-created list 
	 * @return array
	 */
	public function followList($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_LIST_FOLLOW, $listId));
	}
	
	/**
	 * Allows you to unfollow a list. 
	 * 
	 * @param string Id for a user-created list 
	 * @return array
	 */
	public function unfollowList($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_LIST_UNFOLLOW, $listId));
	}
	
	/**
	 * Share a user-created list to twitter or facebook. 
	 * 
	 * @param string Id for a user-created list 
	 * @return array
	 */
	public function shareList($listId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['itemId'] = $itemId;
		
		return $this->_post(sprintf(self::URL_LIST_SHARE, $listId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}