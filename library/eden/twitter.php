<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter API factory. This is a factory class with 
 * methods that will load up different twitter classes.
 * Twitter classes are organized as described on their 
 * developer site: account, block, direct message, favorites, friends, geo,
 * help, legal, list, local trends, notification, saved searches, search, spam,
 * suggestions, timelines, trends, tweets and users.
 *
 * @package    Eden
 * @category   Twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns twitter oauth method
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Oauth
	 */
	public function auth($key, $secret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Twitter_Oauth::i($key, $secret);
	}
	
	/**
	 * Returns twitter account method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Accounts
	 */
	public function account($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Accounts::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter block method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Block
	 */
	public function block($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Block::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter direct message method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Directmessage
	 */
	public function directMessage($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Directmessage::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter favorites method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Favorites
	 */
	public function favorites($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Favorites::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter friends method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Friends
	 */
	public function friends($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Friends::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter geo method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Geo
	 */
	public function geo($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Geo::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter help method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Help
	 */
	public function help($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Help::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter legal method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Legal
	 */
	public function legal($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Legal::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter list method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_List
	 */
	public function lists($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_List::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter localTrends method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_LocalTrends
	 */
	public function localTrends($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_LocalTrends::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter notification method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Notification
	 */
	public function notification($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Notification::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter saved method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Saved
	 */
	public function saved($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Saved::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter search method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Search
	 */
	public function search($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Search::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter spam method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Spam
	 */
	public function spam($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Spam::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter suggestions method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Suggestions
	 */
	public function suggestions($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Suggestions::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter timelines method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Timelines
	 */
	public function timelines($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Timelines::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter trends method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Trends
	 */
	public function trends($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Trends::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter tweets method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Tweets
	 */
	public function tweets($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Tweets::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns twitter users method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Twitter_Users
	 */
	public function users($requestKey, $requestSecret, $accessToken, $accessSecret) {
		//Argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Twitter_Users::i($requestKey, $requestSecret, $accessToken, $accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}