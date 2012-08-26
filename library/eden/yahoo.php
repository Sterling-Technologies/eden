<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Yahoo API factory. This is a factory class with 
 * methods that will load up different Yahoo classes.
 *
 * @package    Eden
 * @category   Yahoo
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Yahoo extends Eden_Class {
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
	 * Returns FQL
	 *
	 * @return Eden_Yahoo_Yql
	 */
	public function yql() {
		return Eden_Yahoo_Yql::i();
	}
	
	/**
	 * Returns Yahoo Oauth
	 *
	 * @return Eden_Yahoo_Oauth
	 */
	public function oauth($key, $secret) { 
		return Eden_Yahoo_Oauth::i($key, $secret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}