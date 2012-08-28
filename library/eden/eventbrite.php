<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/oauth2.php';
require_once dirname(__FILE__).'/eventbrite/error.php';
require_once dirname(__FILE__).'/eventbrite/base.php';
require_once dirname(__FILE__).'/eventbrite/oauth.php';
require_once dirname(__FILE__).'/eventbrite/discount.php';
require_once dirname(__FILE__).'/eventbrite/event.php';
require_once dirname(__FILE__).'/eventbrite/organizer.php';
require_once dirname(__FILE__).'/eventbrite/payment.php';
require_once dirname(__FILE__).'/eventbrite/ticket.php';
require_once dirname(__FILE__).'/eventbrite/user.php';
require_once dirname(__FILE__).'/eventbrite/venue.php';
require_once dirname(__FILE__).'/eventbrite/event/search.php';
require_once dirname(__FILE__).'/eventbrite/event/set.php';

/**
 * Eventbrite API factory. This is a factory class with 
 * methods that will load up different Eventbrite classes.
 * Eventbrite classes are organized as described on their 
 * developer site: discount, event, organizer, payment,
 * ticket, user, venue. We also added a search class and 
 * set class with advanced options for searching and 
 * creating events.
 *
 * @package    Eden
 * @category   tool
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Eventbrite Oauth
	 *
	 * @param string client ID
	 * @param string app secret
	 * @return Eden_Eventbrite_Discount
	 */
	public function auth($clientId, $appSecret, $redirect) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string', 'int')
			->argument(2, 'string')
			->argument(3, 'string');
			
		return Eden_Eventbrite_Oauth::i((string) $clientId, $appSecret, $redirect);
	}
	
	/**
	 * Returns Eventbrite Discount
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Discount
	 */
	public function discount($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Discount::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Event
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Event
	 */
	public function event($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Event::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Organizer
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Organizer
	 */
	public function organizer($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Organizer::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Payment
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Payment
	 */
	public function payment($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Payment::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Search
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Venue
	 */
	public function search($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Event_Search::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Set
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Venue
	 */
	public function set($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Event_Set::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Ticket
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Ticket
	 */
	public function ticket($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Ticket::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite User
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_User
	 */
	public function user($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_User::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Venue
	 *
	 * @param string
	 * @param string|null
	 * @return Eden_Eventbrite_Venue
	 */
	public function venue($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		return Eden_Eventbrite_Venue::i($user, $api);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}