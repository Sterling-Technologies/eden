<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require_once dirname(__FILE__).'/oauth2.php';
require_once dirname(__FILE__).'/template.php';
require_once dirname(__FILE__).'/google/error.php';
require_once dirname(__FILE__).'/google/base.php';
require_once dirname(__FILE__).'/google/oauth.php';
require_once dirname(__FILE__).'/google/calendar/acl.php';
require_once dirname(__FILE__).'/google/calendar/calendars.php';
require_once dirname(__FILE__).'/google/calendar/event.php';
require_once dirname(__FILE__).'/google/calendar/freebusy.php';
require_once dirname(__FILE__).'/google/calendar/list.php';
require_once dirname(__FILE__).'/google/calendar/settings.php'; 
require_once dirname(__FILE__).'/google/calendar.php';
require_once dirname(__FILE__).'/google/checkout/form.php';
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
require_once dirname(__FILE__).'/google/contacts.php';
require_once dirname(__FILE__).'/google/analytics/management.php';
require_once dirname(__FILE__).'/google/analytics/reporting.php';
require_once dirname(__FILE__).'/google/analytics/multichannel.php';
require_once dirname(__FILE__).'/google/analytics.php';
require_once dirname(__FILE__).'/google/plus/activity.php';
require_once dirname(__FILE__).'/google/plus/comment.php';
require_once dirname(__FILE__).'/google/plus/people.php';
require_once dirname(__FILE__).'/google/plus.php';
require_once dirname(__FILE__).'/google/maps/direction.php';
require_once dirname(__FILE__).'/google/maps/distance.php';
require_once dirname(__FILE__).'/google/maps/elevation.php';
require_once dirname(__FILE__).'/google/maps/geocoding.php';
require_once dirname(__FILE__).'/google/maps/image.php';
require_once dirname(__FILE__).'/google/maps.php';
require_once dirname(__FILE__)."/google/latitude/history.php";
require_once dirname(__FILE__)."/google/latitude/location.php";
require_once dirname(__FILE__)."/google/latitude.php";
require_once dirname(__FILE__).'/google/shortener.php';
require_once dirname(__FILE__)."/google/userinfo.php";
require_once dirname(__FILE__).'/google/youtube/activity.php';
require_once dirname(__FILE__).'/google/youtube/channel.php';
require_once dirname(__FILE__).'/google/youtube/comment.php';
require_once dirname(__FILE__).'/google/youtube/contacts.php';
require_once dirname(__FILE__).'/google/youtube/favorites.php';
require_once dirname(__FILE__).'/google/youtube/history.php';
require_once dirname(__FILE__).'/google/youtube/message.php';
require_once dirname(__FILE__).'/google/youtube/playlist.php';
require_once dirname(__FILE__).'/google/youtube/profile.php';
require_once dirname(__FILE__).'/google/youtube/ratings.php';
require_once dirname(__FILE__).'/google/youtube/search.php';
require_once dirname(__FILE__).'/google/youtube/subscription.php';
require_once dirname(__FILE__).'/google/youtube/upload.php';
require_once dirname(__FILE__).'/google/youtube/video.php';
require_once dirname(__FILE__).'/google/youtube.php';

/**
 * Google API factory. This is a factory class with 
 * methods that will load up different google classes.
 * Google classes are organized as described on their 
 * developer site: analytics, calendar ,contacts ,drive, plus and youtube.
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
	 * @param *string
	 * @param *url
	 * @param *string 
	 * @return Eden_Google_Oauth
	 */
	public function auth($clientId, $clientSecret, $redirect, $apiKey = NULL ) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'url')				//Argument 3 must be a url
			->argument(4, 'string', 'null');	//Argument 4 must be a string
		
		return Eden_Google_Oauth::i($clientId, $clientSecret, $redirect, $apiKey);
	}
	
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
	 * Returns google checkout methods
	 *
	 * @param *string 
	 * @return Eden_Google_Checkout_Form
	 */
	public function checkout($merchantId) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return Eden_Google_Checkout_Form::i($merchantId);
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
	
	/**
	 * Returns google shortener methods
	 *
	 * @param *string API key
	 * @param *string 
	 * @return Eden_Google_Plus
	 */
	public function shortener($key, $token) {
		//Argument Testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Google_Shortener::i($key, $token);
	}
	
	/**
	 * Returns google youtube methods
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Google_Youtube
	 */
	public function youtube($token, $developerId) {
		//Argument Testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Google_Youtube::i($token, $developerId);
	}
	
	/**
	 * Returns google latitude methods
	 *
	 * @return Eden_Google_Latitude
	 */
	public function latitude($api_key, $token) {
		return Eden_Google_Latitude::i($api_key, $token);
	}
	
	/**
	 * Returns google userinfo methods
	 *
	 * @return Eden_Google_Userinfo
	 */
	public function userinfo($token) {
		return Eden_Google_Userinfo::i($token);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}