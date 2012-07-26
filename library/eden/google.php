<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/google/error.php';
require_once dirname(__FILE__).'/google/base.php';
require_once dirname(__FILE__).'/google/calendar/acl.php';
require_once dirname(__FILE__).'/google/calendar/calendars.php';
require_once dirname(__FILE__).'/google/calendar/color.php';
require_once dirname(__FILE__).'/google/calendar/event.php';
require_once dirname(__FILE__).'/google/calendar/freebusy.php';
require_once dirname(__FILE__).'/google/calendar/list.php';
require_once dirname(__FILE__).'/google/calendar/settings.php';
require_once dirname(__FILE__).'/google/drive/about.php';
require_once dirname(__FILE__).'/google/drive/apps.php';
require_once dirname(__FILE__).'/google/drive/changes.php';
require_once dirname(__FILE__).'/google/drive/children.php';
require_once dirname(__FILE__).'/google/drive/files.php';
require_once dirname(__FILE__).'/google/drive/parent.php';
require_once dirname(__FILE__).'/google/drive/permissions.php';
require_once dirname(__FILE__).'/google/drive/revisions.php';

/**
 * Google API factory. This is a factory class with 
 * methods that will load up different google classes.
 * Google classes are organized as described on their 
 * developer site: calendar and drive.
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google extends Eden_Class {
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
	 * Returns google drive methods
	 *
	 * @param *string 
	 * @return Eden_Google_Drive
	 */
	public function drive($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Drive::i($token);
	}
	
	/**
	 * Returns google calendar methods
	 *
	 * @param *string 
	 * @return Eden_Google_Drive
	 */
	public function calendar($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Calendar::i($token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}