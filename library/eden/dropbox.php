<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/dropbox/error.php';
require_once dirname(__FILE__).'/dropbox/oauth.php';
require_once dirname(__FILE__).'/dropbox/base.php';
require_once dirname(__FILE__).'/dropbox/accounts.php';
require_once dirname(__FILE__).'/dropbox/files.php';
require_once dirname(__FILE__).'/dropbox/fileoperations.php';

/**
 * Dropbox API factory. This is a factory class with 
 * methods that will load up different asiapay classes.
 * Dropbox classes are organized as described on their 
 * developer site: accounts ,files and file operations.
 *
 * @package    Eden
 * @category   dropbox
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Dropbox extends Eden_Class {
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
	 * Returns dropbox accounts
	 *
	 * @param *string
	 * @param *string
	 * @param *string
	 * @param *string
	 * @return Eden_Dropbox_Accounts
	 */
	public function accounts($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Dropbox_Accounts::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns dropbox files
	 *
	 * @param *string
	 * @param *string
	 * @param *string
	 * @param *string
	 * @return Eden_Dropbox_Files
	 */
	public function files($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Dropbox_Files::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns dropbox file operation
	 *
	 * @param *string
	 * @param *string
	 * @param *string
	 * @param *string
	 * @return Eden_Dropbox_FileOperations
	 */
	public function fileOperations($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		return Eden_Dropbox_FileOperations::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}