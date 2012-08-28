<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite event
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Event extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_COPY 				= 'https://www.eventbrite.com/json/event_copy';
	const URL_GET 				= 'https://www.eventbrite.com/json/event_get';
	const URL_LIST_ATTENDEES 	= 'https://www.eventbrite.com/json/event_list_attendees';
	const URL_LIST_DISCOUNTS 	= 'https://www.eventbrite.com/json/event_list_discounts';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_validDisplays = array('profile','answers','address');
	 
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
	 * Copies the event to a new one
	 *
	 * @param number
	 * @param string
	 * @return array
	 */
	public function copy($id, $name) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'numeric')	//Argument 1 must be numeric
			->argument(2, 'string');	//Argument 2 must be a string
		
		$query = array('id' => $id, 'name' => $name);
		
		return $this->_getJsonResponse(self::URL_COPY, $query);
	}
	
	/**
	 * Returns event attendees
	 *
	 * @param number
	 * @param number
	 * @param number
	 * @param string|null
	 * @param bool
	 * @return array
	 */
	public function getAttendees($id, $count = 50, $page = 1, $display = NULL, $barcodes = false) {
		//argument test
		$error = Eden_Eventbrite_Error::i()
			->argument(1, 'numeric')			//Argument 1 must be numeric
			->argument(2, 'numeric')			//Argument 2 must be numeric
			->argument(3, 'numeric')			//Argument 3 must be numeric
			->argument(4, 'string', 'null')		//Argument 4 must be a string
			->argument(5, 'bool');				//Argument 4 must be a boolean
		
		$query = array('id' => $id, 'count' => $count, 'page' => $page);
		
		if(!is_null($display) && in_array($display, $this->_validDisplays)) {
			$query['do_not_display'] = $display;
		}
		
		if($barcodes) {
			$query['show_full_barcodes'] = $barcodes;
		}
		
		return $this->_getJsonResponse(self::URL_LIST_ATTENDEES, $query);
	}
	
	/**
	 * Returns the event details
	 *
	 * @param number
	 * @return array
	 */
	public function getDetail($id) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');	
		
		$query = array('id' => $id);
		
		return $this->_getJsonResponse(self::URL_GET, $query);
	}
	
	/**
	 * Returns any event discounts
	 *
	 * @param number
	 * @return array
	 */
	public function getDiscounts($id) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');	
		
		$query = array('id' => $id);
		
		return $this->_getJsonResponse(self::URL_LIST_DISCOUNTS, $query);
	}
	
	/**
	 * Returns the search class
	 *
	 * @return Eden_Eventbrite_Event_Set
	 */
	public function search() {
		return Eden_Eventbrite_Event_Search::i($this->_user, $this->_api);
	}
	
	/**
	 * Returns the set class
	 *
	 * @return Eden_Eventbrite_Event_Set
	 */
	public function set() {
		return Eden_Eventbrite_Event_Set::i($this->_user, $this->_api);
	}
			
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}