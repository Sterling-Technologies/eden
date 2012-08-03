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
require_once dirname(__FILE__).'/google/calendar.php';
require_once dirname(__FILE__).'/google/drive/about.php';
require_once dirname(__FILE__).'/google/drive/apps.php';
require_once dirname(__FILE__).'/google/drive/changes.php';
require_once dirname(__FILE__).'/google/drive/children.php';
require_once dirname(__FILE__).'/google/drive/files.php';
require_once dirname(__FILE__).'/google/drive/parent.php';
require_once dirname(__FILE__).'/google/drive/permissions.php';
require_once dirname(__FILE__).'/google/drive/revisions.php';
require_once dirname(__FILE__).'/google/drive.php';
require_once dirname(__FILE__).'/google/contacts/batch.php';
require_once dirname(__FILE__).'/google/contacts/data.php';
require_once dirname(__FILE__).'/google/contacts/groups.php';
require_once dirname(__FILE__).'/google/contacts/photo.php';
require_once dirname(__FILE__).'/google/contacts/block/addcontacts.php';
require_once dirname(__FILE__).'/google/contacts/block/addgroups.php';
require_once dirname(__FILE__).'/google/contacts.php';
require_once dirname(__FILE__).'/google/analytics/management.php';
require_once dirname(__FILE__).'/google/analytics.php';
require_once dirname(__FILE__).'/google/plus/activity.php';
require_once dirname(__FILE__).'/google/plus/comment.php';
require_once dirname(__FILE__).'/google/plus/people.php';
require_once dirname(__FILE__).'/google/plus.php';

/**
 * Google API factory. This is a factory class with 
 * methods that will load up different google classes.
 * Google classes are organized as described on their 
 * developer site: analytics, calendar ,contacts ,drive and plus.
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
	 * Returns google analytics methods
	 *
	 * @param *string 
	 * @return Eden_Google_Analytics
	 */
	public function analytics($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Analytics::i($token);
	}
	
	/**
	 * Returns google calendar methods
	 *
	 * @param *string 
	 * @return Eden_Google_Calendar
	 */
	public function calendar($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Calendar::i($token);
	}
	
	/**
	 * Returns google contacts methods
	 *
	 * @param *string 
	 * @return Eden_Google_Contacts
	 */
	public function contacts($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Contacts::i($token);
	}
	
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
	 * Returns google maps methods
	 *
	 * @param *string 
	 * @return Eden_Google_Maps
	 */
	public function maps($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Maps::i($token);
	}
	
	/**
	 * Returns google plus methods
	 *
	 * @param *string 
	 * @return Eden_Google_Plus
	 */
	public function plus($token) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Plus::i($token);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}