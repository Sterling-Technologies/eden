<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square page updates
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Pageupdates extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_PAGEUPDATES_ADD 		= 'https://api.foursquare.com/v2/pageupdates/add'; 
	const URL_PAGEUPDATES_LIST		= 'https://api.foursquare.com/v2/pageupdates/list';
	const URL_PAGEUPDATES_DELETE	= 'https://api.foursquare.com/v2/pageupdates/%s/delete';
	const URL_PAGEUPDATES_LIKE		= 'https://api.foursquare.com/v2/pageupdates/%s/like';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_pageId			= NULL;
	protected $_groupId			= NULL;
	protected $_venueId			= NULL;
	protected $_shout			= NULL;
	protected $_campaignId		= NULL;
	protected $_photoId			= NULL;
	protected $_broadcast		= NULL;
	
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
	 * The page to associate the with broadcast.
	 * 
	 * @param string
	 * @return this
	 */
	public function setPageId($pageId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_pageId  = $pageId; 
		
		return $this;
	} 
	
	/**
	 * The venue group from which to broadcast an update.
	 * 
	 * @param string
	 * @return this
	 */
	public function setGroupId($groupId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_groupId  = $groupId; 
		
		return $this;
	}
	
	/**
	 * Venue ID indicated which venues to broadcast from.
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueId($venueId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_venueId  = $venueId; 
		
		return $this;
	}
	
	/**
	 * Text associated with the broadcast. 160 characters max.
	 * 
	 * @param string
	 * @return this
	 */
	public function setShout($shout) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_shout  = $shout; 
		
		return $this;
	}
	
	/**
	 * An optional special to attach to the broadcast.
	 * 
	 * @param string
	 * @return this
	 */
	public function setCampaignId($campaignId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_campaignId  = $campaignId; 
		
		return $this;
	}
	
	/**
	 * An optional special to attach to the broadcast.
	 * 
	 * @param string
	 * @return this
	 */
	public function setPhotoId($photoId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_photoId  = $photoId; 
		
		return $this;
	}
	
	/**
	 * Additional places to send the broadcast to. 
	 * Accepts list of values: 
	 * facebook - share on facebook
	 * twitter	- share on twitter
	 * private	- just create the update without broadcasting to anyone
	 * 
	 * @param string
	 * @return this
	 */
	public function setBroadcast($broadcast) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		//if the input value is not allowed
		if(!in_array($broadcast, array('facebook', 'twitter', 'private'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_PAGEUPDATES_BROADCAST) 
				->addVariable($broadcast)
				->trigger();
		}
		
		$this->_broadcast  = $broadcast; 
		
		return $this;
	}
	
	/**
	 * Allows you to get the page's venues.
	 *  
	 * @param string The page id for which venues are being requested.
	 * @return array
	 */
	public function addPage() {
		
		$query = array(
			'pageId'		=> $this->_pageId,		//optional	
			'groupId'		=> $this->_groupId,		//optional
			'venueId'		=> $this->_venueId,		//optional 
			'shout'			=> $this->_shout,		//optional
			'campaignId'	=> $this->_campaignId,	//optional
			'photoId'		=> $this->_photoId,		//optional
			'broadcast'		=> $this->_broadcast);	//optional
			
		return $this->_post(self::URL_PAGEUPDATES_ADD, $query);
	}
	
	/**
	 * Returns a list of page updates created by the current user.
	 *  
	 * @return array
	 */
	public function getList() {
			
		return $this->_getResponse(self::URL_PAGEUPDATES_LIST);
	}
	
	/**
	 * Delete a page update created by the current user.
	 *  
	 * @param string The ID of the update to delete.
	 * @return array
	 */
	public function delete($pageId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_getResponse(sprintf(self::URL_PAGEUPDATES_DELETE, $pageId));
	}
	
	/**
	 * Causes the current user to 'like' a page update. 
	 * If there is a campaign associated with the update, 
	 * the like will propagate to the special as well.
	 *  
	 * @param string The ID of the update to like.
	 * @return array
	 */
	public function like($pageId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_getResponse(sprintf(self::URL_PAGEUPDATES_LIKE, $pageId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}