<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite venue
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Venue extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW = 'https://www.eventbrite.com/json/venue_new';
	const URL_UPDATE = 'https://www.eventbrite.com/json/venue_update';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
		/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function add($organizer, $venue, $country, $region, $address1 = NULL, $address2 = NULL, $city = NULL, $postal = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')					//Argument must be a string
			->argument(2, 'string')					//Argument msut be a string
			->argument(3, 'string')					//Argument must be a string
			->argument(4, 'string')					//Argument must be a string
			->argument(5, 'string', 'null')			//Argument must be a string or null
			->argument(6, 'string', 'null')			//Argument must be a string or null
			->argument(7, 'string', 'null')			//Argument must be a string or null
			->argument(8, 'string', 'null');		//Argument must be a string or null
			
		$query = array(
			'organizer_id'  => $organizer,
			'venue'			=> $venue,
			'country'		=> $country_code,
			'region'		=> $region);
		
		//if address1 is not empty
		if(!is_null($address1)) {
			//add it to our query
			$query['adress'] = $address1;
		}
		
		//if address2 is not empty
		if(!is_null($address2)) {
			//add it to our query
			$query['adress_2'] = $address2;
		}
		
		//if city is not empty
		if(!is_null($city)) {
			//add it to our query
			$query['city'] = $city;
		}
		
		//if postal is not empty
		if(!is_null($postal)) {
			//add it to our query
			$query['postal_code'] = $postal;			
		}
		
		return $this->_getJsonResponse(self::URL_NEW, $query);	
	}
	
	public function update($id, $venue, $address1 = NULL, $address2 = NULL, $city = NULL, $region = NULL, $postal = NULL, $country = NULL){
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'int')					//Argument must be a integer
			->argument(2, 'string')					//Argument must be a string
			->argument(3, 'string', 'null')			//Argument must be a string or null
			->argument(4, 'string', 'null')			//Argument must be a string or null
			->argument(5, 'string', 'null')			//Argument must be a string or null
			->argument(6, 'string', 'null')			//Argument must be a string or null
			->argument(7, 'string', 'null');		//Argument must be a string or null
			
		$query = array(
			'id' 	=> $id,
			'venue' => $venue);
		//if address1 is not empty
		if(!is_null($address1)) {
			//add it to our query
			$query['adress'] = $address1;
		}
		//if address2 is not empty
		if(!is_null($adress2)) {
			//add it to our query
			$query['adress_2'] = $address2;	
		}
		//if city is not empty
		if(!is_null($city)) {
			//add it to our query
			$query['city'] = $city;
		}
		//if postal is not empty
		if(!is_null($postal)) {
			//add it to our query
			$query['postal_code'] = $postal;	
		}
		
		//if country is not a empty
		if(!is_null($country)) {
			//add it to our query
			$query['country_code'] = $country;
		}
	
		return $this->getJsonResponse(self::URL_UPDATE, $query);	
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}










