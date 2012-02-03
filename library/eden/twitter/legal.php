<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter legal
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Legal extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_PRIVACY	= 'https://api.twitter.com/1/legal/privacy.json';
	const URL_TERMS		= 'https://api.twitter.com/1/legal/tos.json';
	
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
	 * Returns Twitter's Privacy Policy 
	 * in the requested format.
	 *
	 * @return string
	 */
	public function getPrivacy() {
		return $this->_getResponse(self::URL_PRIVACY);
	}
	
	/**
	 * Returns the Twitter Terms of Service in 
	 * the requested format. These are not the 
	 * same as the Developer Rules of the Road.
	 *
	 * @return string
	 */
	public function getTerms() {
		return $this->_getResponse(self::URL_TERMS);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}