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
	 * Returns all user subscription
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $userId), $this->_query);
	}
	
	/**
	 * Returns new user subscription
	 *
	 * @param string
	 * @return array
	 */
	public function getNewSubscription($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_NEW_SUBSCRIPTION, $userId), $this->_query);
	}
	
	/**
	 * Subscribe to a channel
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function subscribeToChannel($channel, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::CHANNEL, $channel)
			->parsePHP(dirname(__FILE__).'/template/subscribe.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $userId), $query);
	}
	
	/**
	 * Subscribe to a users activity
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function subscribeToUser($user, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::USER, $user)
			->parsePHP(dirname(__FILE__).'/template/subscribe.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_SUBSCRIPTION, $userId), $query);
	}
	
	/**
	 * Subscribe to a users activity
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function unsubscribe($subscriptionId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_UNSUBSCRIPTION, $userId, $subscriptionId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}