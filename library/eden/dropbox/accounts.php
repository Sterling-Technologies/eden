<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Dropbox Accounts
 *
 * @package    Eden
 * @category   dropbox
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Dropbox_Accounts extends Eden_Dropbox_Base {
	/* Constants
	-------------------------------*/
	const DROPBOX_ACCOUNTS = 'https://api.dropbox.com/1/account/info';
	
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
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Retrieves information about the user's account.
	 *
	 * @return array
	 */
	public function getUser() {
		
		return $this->_getResponse(self::DROPBOX_ACCOUNTS);
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}