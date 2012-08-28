<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/oauth.php';
require_once dirname(__FILE__).'/getsatisfaction/error.php';
require_once dirname(__FILE__).'/getsatisfaction/base.php';
require_once dirname(__FILE__).'/getsatisfaction/company.php';
require_once dirname(__FILE__).'/getsatisfaction/detail.php';
require_once dirname(__FILE__).'/getsatisfaction/oauth.php';
require_once dirname(__FILE__).'/getsatisfaction/people.php';
require_once dirname(__FILE__).'/getsatisfaction/product.php';
require_once dirname(__FILE__).'/getsatisfaction/reply.php';
require_once dirname(__FILE__).'/getsatisfaction/replies.php';
require_once dirname(__FILE__).'/getsatisfaction/tag.php';
require_once dirname(__FILE__).'/getsatisfaction/topic.php';

/**
 * Get Satisfaction API factory. This is a factory class with 
 * methods that will load up different Get Satisfaction classes.
 * Get Satisfaction classes are organized as described on their 
 * developer site: company, detail, oauth, people, post, product,
 * replies, tag, topics. 
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Getsatisfaction Company
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Company
	 */
	public function company($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Company::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction Detail
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Detail
	 */
	public function detail($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Detail::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction OAuth
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Oauth
	 */
	public function auth($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Oauth::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction People
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_People
	 */
	public function people($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_People::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction post
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Post
	 */
	public function post($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Post::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction Product
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Product
	 */
	public function product($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Product::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction Replies
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Replies
	 */
	public function replies($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Replies::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}

	/**
	 * Returns Getsatisfaction reply
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Reply
	 */
	public function reply($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Reply::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
		
	/**
	 * Returns Getsatisfaction Tags
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Tag
	 */
	public function tag($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Tag::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/**
	 * Returns Getsatisfaction Topics
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Topic
	 */
	public function topic($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Getsatisfaction_Topic::i(
			$consumerKey, 
			$consumerSecret, 
			$accessToken, 
			$accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
