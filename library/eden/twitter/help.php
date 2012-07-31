<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter help
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Help extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_TEST			= 'https://api.twitter.com/1/help/test.json';
	const URL_CONFIGURATION	= 'https://api.twitter.com/1/help/configuration.json';
	const URL_LANGUAGES		= 'https://api.twitter.com/1/help/languages.json';
	
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
	 * Returns the current configuration used by 
	 * Twitter including twitter.com slugs which 
	 * are not usernames, maximum photo resolutions,
	 * and t.co URL lengths.
	 *
	 * @return array
	 */
	public function setConfiguration() {
		return $this->_getResponse(self::URL_CONFIGURATION);
	}
	
	/**
	 * Returns the list of languages supported by 
	 * Twitter along with their ISO 639-1 code.
	 *
	 * @return array
	 */
	public function setLanguages() {
		return $this->_getResponse(self::URL_LANGUAGES);
	}
	
	/**
	 * Returns the string "ok" in the requested
	 * format with a 200 OK HTTP status code.
	 *
	 * @return string
	 */
	public function setTest() {
		return $this->_getResponse(self::URL_TEST);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}