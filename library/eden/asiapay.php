<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/template.php'; 
require_once dirname(__FILE__).'/asiapay/error.php';
require_once dirname(__FILE__).'/asiapay/base.php';
require_once dirname(__FILE__).'/asiapay/client.php';
require_once dirname(__FILE__).'/asiapay/directclient.php';

/**
 * Asiapay API factory. This is a factory class with 
 * methods that will load up different asiapay classes.
 * Asiapay classes are organized as described on their 
 * developer site: client and directclient.
 *
 * @package    Eden
 * @category   asiapay
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Asiapay extends Eden_Class {
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
	 * Returns asiapay client post
	 *
	 * @param *string
	 * @param *boolean
	 * @return Eden_Asiapay_Client
	 */
	public function clientPost($merchantId, $test = true, $hash = NULL) {
		
		//argument test
		Eden_Asiapay_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'bool')				//Argument 2 must be a boolean
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		return Eden_Asiapay_Client::i($merchantId, $test, $hash);
	}
	
	/**
	 * Returns asiapay direct client
	 *
	 * @param *string
	 * @param *boolean
	 * @return Eden_Asiapay_Directclient
	 */
	public function directClient($merchantId, $test = true, $hash = NULL) {
		//argument test
		Eden_Asiapay_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'bool')		//Argument 2 must be a boolean
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		return Eden_Asiapay_Directclient::i($merchantId, $test, $hash);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}