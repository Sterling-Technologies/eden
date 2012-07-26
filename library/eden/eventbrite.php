<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/eventbrite/error.php';
require_once dirname(__FILE__).'/eventbrite/base.php';
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
	 * Returns Eventbrite Discount
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Discount
	 */
	public function discount($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Discount::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Event
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Event
	 */
	public function event($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Event::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Organizer
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Organizer
	 */
	public function organizer($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Organizer::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Payment
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Payment
	 */
	public function payment($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Payment::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Search
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Venue
	 */
	public function search($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Event_Search::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Set
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Venue
	 */
	public function set($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Event_Set::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Ticket
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Ticket
	 */
	public function ticket($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Ticket::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite User
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_User
	 */
	public function user($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_User::i($user, $api);
	}
	
	/**
	 * Returns Eventbrite Venue
	 *
	 * @param string
	 * @param string
	 * @return Eden_Eventbrite_Venue
	 */
	public function venue($user, $api) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Eventbrite_Venue::i($user, $api);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}