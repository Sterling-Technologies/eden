<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/oauth.php';
require_once dirname(__FILE__).'/tumblr/error.php';
require_once dirname(__FILE__).'/tumblr/base.php';
require_once dirname(__FILE__).'/tumblr/oauth.php';
require_once dirname(__FILE__).'/tumblr/blog.php';
require_once dirname(__FILE__).'/tumblr/user.php';

/**
 * Tumblr API factory. This is a factory class with 
 * methods that will load up different tumblr classes.
 * Tumblr classes are organized as described on their 
 * developer site: blog and user.
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Tumblr extends Eden_Class {
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
	 * Returns tumblr auth method
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Tumblr_Oauth
	 */
	public function auth($key, $secret) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Tumblr_Oauth::i($key, $secret);
	}
	
	/**
	 * Returns tumblr blog method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Tumblr_Blog
	 */
	public function blog($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Tumblr_Blog::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns tumblr blog method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Eden_Tumblr_User
	 */
	public function user($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Tumblr_User::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}