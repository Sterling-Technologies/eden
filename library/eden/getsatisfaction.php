<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/getsatisfaction/error.php';
require_once dirname(__FILE__).'/getsatisfaction/base.php';
require_once dirname(__FILE__).'/getsatisfaction/company.php';
require_once dirname(__FILE__).'/getsatisfaction/detail.php';
require_once dirname(__FILE__).'/getsatisfaction/oauth.php';
require_once dirname(__FILE__).'/getsatisfaction/people.php';
require_once dirname(__FILE__).'/getsatisfaction/product.php';
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
 * @category   tool
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
	 * @return Eden_Getsatisfaction_Company
	 */
	public function company($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Company::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction Detail
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Detail
	 */
	public function detail($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Detail::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction OAuth
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Oauth
	 */
	public function oauth($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Oauth::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction People
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_People
	 */
	public function people($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_People::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction post
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Post
	 */
	public function post($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Post::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction Product
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Product
	 */
	public function product($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Product::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction Replies
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Replies
	 */
	public function replies($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Replies::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction Tags
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Tag
	 */
	public function tag($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Tag::i($user, $user);
	}
	
	/**
	 * Returns Getsatisfaction Topics
	 *
	 * @param string
	 * @param string
	 * @return Eden_Getsatisfaction_Topic
	 */
	public function topic($key, $secret) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Getsatisfaction_Topic::i($user, $user);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}