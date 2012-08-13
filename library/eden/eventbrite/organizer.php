<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite Organizer
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Organizer extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW 		= 'https://www.eventbrite.com/json/organizer_new';
	const URL_UPDATE 	= 'https://www.eventbrite.com/json/organizer_update';
	const URL_EVENTS 	= 'https://www.eventbrite.com/json/organizer_list_events';
	
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
	 * Creates an organizer
	 * 
	 * @param string
	 * @param string|null
	 * @return array
	 */
	public function create($name, $description = NULL) {
		//Argument Test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string
		
		$query = array(
			'name' 			=> $name,
			'description'	=> $description);
		
		return $this->_getJsonResponse(self::URL_NEW, $query);
	}
		
	/**
	 * Returns all active organizer events
	 * 
	 * @param int
	 * @return array
	 */
	public function getEvents($id) {
		//Argument 1 must be an int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query = array('id'	=> $id);
		
		return $this->_getJsonResponse(self::URL_EVENTS, $query);
	}
	
	/**
	 * Updates an organizer
	 * 
	 * @param int
	 * @param string
	 * @param string|null
	 * @return array
	 */
	public function update($id, $name, $description = NULL) {
		//Argument Test
		Eden_Eventbrite_Error::i()
			->argument(1, 'int')				//Argument 1 must be an integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'null');	//Argument 3 must be a string
		
		$query = array(
			'id'			=> $id,
			'name' 			=> $name,
			'description'	=> $description);
		
		return $this->_getJsonResponse(self::URL_UPDATE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}