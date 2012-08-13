<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square updates detail
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Updates extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_UPDATES_NOTIFICATION 	= 'https://api.foursquare.com/v2/updates/notifications';
	const URL_UPDATES_MARK_AS_READ	= 'https://api.foursquare.com/v2/updates/marknotificationsread';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_limit = NULL;
	
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
	 * Maximum number of results to return, up to 99. 
	 * Notifications are grouped over time, so there will 
	 * usually be fewer than 99 results available at any given 
	 * time. offset 0 Used to page through results. Only the 99 most 
	 * recent notifications are visible, so offset must be no more 
	 * than 99 - limit.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_limit = $limit;
		
		return $this;
	}
	
	/**
	 * Retrieve a user's notification tray notifications
	 * 
	 * @return this
	 */
	public function getNotification() {
		
		$query = array('limit'	=> $this->_limit);	//optional
		
		return $this->_getResponse(self::URL_UPDATES_NOTIFICATION, $query);
	}	 
	
	/**
	 * Mark notification tray notifications as read up, to a certain timestamp.
	 * 
	 * @param string|integer The timestamp of the most recent notification that the user viewed.
	 * @return this
	 */
	public function markAsRead($highWatermark) {
		//argument 1 must be a string or integer
		Eden_Foursquare_Error::i()->argument(1, 'string', 'int');
		
		$highWatermark = strtotime($highWatermark);
		
		$query = array('highWatermark'	=> $highWatermark);	//optional
		
		return $this->_post(self::URL_UPDATES_MARK_AS_READ, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}