<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite user
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_User extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_GET 				= 'https://www.eventbrite.com/json/user_get';
	const URL_LIST_EVENTS 		= 'https://www.eventbrite.com/json/user_list_events';
	const URL_LIST_ORGANIZERS 	= 'https://www.eventbrite.com/json/user_list_organizers';
	const URL_LIST_TICKETS 		= 'https://www.eventbrite.com/json/user_list_tickets';
	const URL_LIST_VENUES 		= 'https://www.eventbrite.com/json/user_list_venues';
	const URL_NEW 				= 'https://www.eventbrite.com/json/user_new';
	const URL_UPDATE 			= 'https://www.eventbrite.com/json/user_update';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected static $_validDisplays = array('description', 'venue', 'logo', 'style', 'organizer', 'tickets');
	
	protected static $_validStatus = array('live', 'started', 'ended');
	
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
	 * Create a new user
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function add($user, $pass) {
		//argument test
		$error = Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a atring
			->argument(2, 'string');			//Argument 2 must be a string
		//if the string lenght of pass is less than 4
		if(strlen($pass) < 4){
			//show an error
			$error->setMessage(Eden_Eventbrite_Error::INVALID_PASSWORD)->trigger(); 	
		}
		
		$query = array('password' => $pass, 'user' => $user);
				
		return $this->_getJsonResponse(self::URL_NEW, $query);

	}
	
	/**
	 * Returns detail about the user
	 *
	 * @param int|string|null
	 * @return array
	 */
	public function getDetail($id = NULL) {
		//Argument 1 must be a integer, string or null
		Eden_Eventbrite_Error::i()->argument(1, 'int', 'string', 'null');
		
		$query = array();
		//if it is not empty
		if(is_int($id)) {
			//lets put it in query
			$query['user_id'] = $id;	
		//is it a string?
		} else if(is_string($id)) {
			//add it to query
			$query['email']	= $id;
		}
		
		return $this->_getJsonResponse(self::URL_GET, $query);
			
	}
	
	/**
	 * Returns a user's event list
	 *
	 * @param string|null
	 * @param string|array|null
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function getEvents($user = NULL, $hide = NULL, $status = NULL, $order = NULL) {
			//argument test		
		Eden_Eventbrite_Error::i()
			->argument(1, 'string', 'null')							//Argument 1 must be a string or null
			->argument(2, 'string', 'array', 'null')				//Argument 2 must be a string or null
			->argument(3, 'string', 'null')							//Argument 3 must be a string or null
			->argument(4, 'string', 'null');						//Argument 4 must be a string or null
										
		$query = array();
		//if user is not empty					
		if(!is_null($user)){
			//add it to our query
			$query['user'] = $user;
		}
		
		//if there is a hide
		if(!is_null($hide)) {
			//if hide is a string
			if(is_string($hide)){
				//lets may it an array
				$hide = explode(',', $hide);
			}
			//at this poit hide will be an array
			$displays = array();
			//for each hide
			foreach($hide as $display){
				//if this display is a valid display
				if(in_array($display, $this->_validDisplays)){
					//lets asdd this to our valid status list
					$displays[] = $display;
				}
			}
			//if we have at least one valid status
			if(!empty($displays)){
				//lets make hide into a string
				$hide = implode(',', $displays);
				//and add to query
				$query['do_not_display'] = $hide;
			}	
		}
		
		//if there is a status
		if(!is_null($status))  {
			//if status is a string
			if(is_string($status)) {
				//lets make it an array
				$status = explode(',', $status);
			}
			//at this point status will be an array
			$statuses = array();
			//for each status
			foreach($status as $event) {
				//if this status is a valid status
				if(in_array($status, $this->_validStatus)) {
					//lets add this to our valid status list 
					$statuses[] = $event;
				}
			}
			//if we have at least one valid status
			if(!empty($statuses)) {
				//lets make statuses into a string
				$status = implode(',', $events);
				//and add to query
				$query['event_statuses'] = $status;		
			}
		}
		//if order is equal to desc		
		if($order == 'desc') {
			//add it to our query
			$query['asc_or_desc'] = 'desc'; 
		}
									
		return $this->_getJsonResponse(self::URL_LIST_EVENTS, $query);										
	}
										
	/**
	 * Returns a user's oraganizations
	 *
	 * @return array
	 */
	public function getOrganizers() {
		return $this->_getJsonResponse(self::URL_LIST_ORGANIZERS);
	}
	
	/**
	 * Returns a user's ticket history
	 *
	 * @return array
	 */
	public function getTickets(){
		return $this->_getJsonResponse(self::URL_LIST_TICKETS);
	}
	
	/**
	 * Returns a user's venue list they have used before
	 *
	 * @return array
	 */
	public function getVenues() {
		return $this->_getJsonResponse(self::URL_LIST_VENUES);
	}
	
	/**
	 * Updates the current user
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function update($email = NULL, $pass = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string', 'null')			//Argument 1 must be a string or null
			->argument(2, 'string', 'null');		//Argument 2 must be a string or null
			
		$query =  array();
		//if email is not empty
		if(!is_null($email)){
			//add it to our query
			$query['new_email'] = $email;
		}
		//if pass is not empty and the string lenght is greater than equal to 4
		if(!is_null($pass) && strlen($pass) >= 4) {
			//add it to our query
			$query['new_password'] = $pass;
		}
		
		return $this->getJsonResponse(self::URL_UPDATE, $query);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
		
		
		
		
		
		
		