<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */ 

/**
 * Google youtube subscription
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Subscription extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_SUBSCRIPTION		= 'https://gdata.youtube.com/feeds/api/users/%s/subscriptions';
	const URL_YOUTUBE_NEW_SUBSCRIPTION	= 'https://gdata.youtube.com/feeds/api/users/%s/newsubscriptionvideos';
	const URL_YOUTUBE_UNSUBSCRIPTION	= 'https://gdata.youtube.com/feeds/api/users/%s/subscriptions/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId 			= 'default';
	protected $_channel 		= NULL;
	protected $_user	 		= NULL;
	protected $_subscriptionId	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_token			= $token; 	
		$this->_developerId 	= $developerId; 
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Set user id
	 *
	 * @param string
	 * @return this
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * Set subscription id
	 *
	 * @param string
	 * @return this
	 */
	public function setSubscriptionId($subscriptionId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_subscriptionId = $subscriptionId;
		
		return $this;
	}
	
	/**
	 * Set Channel
	 *
	 * @param string
	 * @return this
	 */
	public function setChannel($channel) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_channel = $channel;
		
		return $this;
	}
	
	/**
	 * Set User name
	 *
	 * @param string
	 * @return this
	 */
	public function setUser($user) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_user = $user;
		
		return $this;
	}
	
	/**
	 * Returns all user subscription
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $this->_userId), $query);
	}
	
	/**
	 * Returns new user subscription
	 *
	 * @return array
	 */
	public function getNewSubscription() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_NEW_SUBSCRIPTION, $this->_userId), $query);
	}
	
	/**
	 * Subscribe to a channel
	 *
	 * @return array
	 */
	public function subscribeToChannel() {
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::CHANNEL, $this->_channel)
			->parsePHP(dirname(__FILE__).'/template/subscribe.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $this->_userId), $query);
	}
	
	/**
	 * Subscribe to a users activity
	 *
	 * @return array
	 */
	public function subscribeToUser() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::USER, $this->_user)
			->parsePHP(dirname(__FILE__).'/template/subscribe.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $this->_userId), $query);
	}
	
	/**
	 * Subscribe to a users activity
	 *
	 * @return array
	 */
	public function unsubscribe() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_UNSUBSCRIPTION, $this->_userId, $this->_subscriptionId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}