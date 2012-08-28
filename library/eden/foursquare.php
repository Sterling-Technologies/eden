<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require_once dirname(__FILE__).'/oauth2.php';
require_once dirname(__FILE__).'/foursquare/error.php';
require_once dirname(__FILE__).'/foursquare/base.php';
require_once dirname(__FILE__).'/foursquare/oauth.php';
require_once dirname(__FILE__).'/foursquare/campaign.php';
require_once dirname(__FILE__).'/foursquare/checkins.php';
require_once dirname(__FILE__).'/foursquare/events.php';
require_once dirname(__FILE__).'/foursquare/list.php';
require_once dirname(__FILE__).'/foursquare/pages.php';
require_once dirname(__FILE__).'/foursquare/pageupdates.php';
require_once dirname(__FILE__).'/foursquare/photos.php';
require_once dirname(__FILE__).'/foursquare/settings.php';
require_once dirname(__FILE__).'/foursquare/specials.php';
require_once dirname(__FILE__).'/foursquare/tips.php';
require_once dirname(__FILE__).'/foursquare/updates.php';
require_once dirname(__FILE__).'/foursquare/users.php';
require_once dirname(__FILE__).'/foursquare/venue.php';
require_once dirname(__FILE__).'/foursquare/venuegroups.php';

/**
 * foursquare API factory. This is a factory class with 
 * methods that will load up different google classes.
 * Foursquare classes are organized as described on their 
 * developer site: campaign, checkins, events, list, pages
 * pageupdates, photos, settings, tips, updates, users, venue 
 * and venuegroups.
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare extends Eden_Class {
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
	 * Returns foursquare oauth
	 *
	 * @param *string
	 * @param *string
	 * @param *string
	 * @return Eden_Foursquare_Oauth
	 */
	public function auth($clientId, $clientSecret,$redirect) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		return Eden_Foursquare_Oauth::i($clientId, $clientSecret, $redirect);
	}
	
	/**
	 * Returns foursquare campaign
	 *
	 * @param *string
	 * @return Eden_Foursquare_Campaign
	 */
	public function campaign($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Campaign::i($token);
	}
	
	/**
	 * Returns foursquare campaign
	 *
	 * @param *string
	 * @return Eden_Foursquare_Checkins
	 */
	public function checkins($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Checkins::i($token);
	}
	
	/**
	 * Returns foursquare events
	 *
	 * @param *string
	 * @return Eden_Foursquare_Events
	 */
	public function events($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Events::i($token);
	}
	
	/**
	 * Returns foursquare lists
	 *
	 * @param *string
	 * @return Eden_Foursquare_List
	 */
	public function lists($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_List::i($token);
	}
	
	/**
	 * Returns foursquare pages
	 *
	 * @param *string
	 * @return Eden_Foursquare_Pages
	 */
	public function pages($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Pages::i($token);
	}
	
	/**
	 * Returns foursquare pageUpdates
	 *
	 * @param *string
	 * @return Eden_Foursquare_Pageupdates
	 */
	public function pageUpdates($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Pageupdates::i($token);
	}
	
	/**
	 * Returns foursquare photos
	 *
	 * @param *string
	 * @return Eden_Foursquare_Photos
	 */
	public function photos($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Photos::i($token);
	}
	
	/**
	 * Returns foursquare settings
	 *
	 * @param *string
	 * @return Eden_Foursquare_Settings
	 */
	public function settings($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Settings::i($token);
	}
	
	/**
	 * Returns foursquare specials
	 *
	 * @param *string
	 * @return Eden_Foursquare_Specials
	 */
	public function specials($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Specials::i($token);
	}
	
	/**
	 * Returns foursquare tips
	 *
	 * @param *string
	 * @return Eden_Foursquare_Tips
	 */
	public function tips($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Tips::i($token);
	}
	
	/**
	 * Returns foursquare updates
	 *
	 * @param *string
	 * @return Eden_Foursquare_Updates
	 */
	public function updates($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Updates::i($token);
	}
	
	/**
	 * Returns foursquare users
	 *
	 * @param *string
	 * @return Eden_Foursquare_Users
	 */
	public function users($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Users::i($token);
	}
	
	/**
	 * Returns foursquare venue
	 *
	 * @param *string
	 * @return Eden_Foursquare_Venue
	 */
	public function venue($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Venue::i($token);
	}
	
	/**
	 * Returns foursquare venueGroups
	 *
	 * @param *string
	 * @return Eden_Foursquare_Venuegroups
	 */
	public function venueGroups($token) {
		//Argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return Eden_Foursquare_Venuegroups::i($token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}