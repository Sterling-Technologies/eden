<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square setting
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Settings extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_SETTINGS_LIST 	= 'https://api.foursquare.com/v2/settings/all';
	const URL_SETTINGS_CHANGE 	= 'https://api.foursquare.com/v2/settings/%s/set';
	
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
	
	public function __construct($token) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the settings of the acting user.
	 *  
	 * @return this
	 */
	public function getSettings() {
		
		return $this->_getResponse(self::URL_SETTINGS_LIST);
	}
	
	/**
	 * Change a setting for the given user.
	 * 
	 * @param string Name of setting to change, sendToTwitter,  
	 * sendMayorshipsToTwitter, sendBadgesToTwitter, sendToFacebook, 
	 * sendMayorshipsToFacebook, sendBadgesToFacebook, receivePings, receiveCommentPings.
	 * @param integer 1 for true, and 0 for false.
	 * @return array
	 */
	public function changeSettings($settingId, $value) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')	//argument 1 must be a string
			->argument(2, 'int');	//argument 2 must be a integer
		
		//if the input value is not allowed
		if(!in_array($settingId, array('sendToTwitter', 'sendMayorshipsToTwitter', 'sendBadgesToTwitter', 'sendToFacebook', 
			'sendMayorshipsToFacebook', 'sendBadgesToFacebook', 'receivePings', 'receiveCommentPings'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_SETTING) 
				->addVariable($settingId)
				->trigger();
		}
		
		$this->_query['value'] 		= $value;
		$this->_query['SETTING_ID'] = $settingId;
		
		return $this->_post(sprintf(self::URL_SETTINGS_CHANGE, $settingId), $this->_query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}