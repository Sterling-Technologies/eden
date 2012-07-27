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
	/**
	 * Creates the venue
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function create($organizer, $venue, $country, $region) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string', 'int')	//Argument must be a string
			->argument(2, 'string')			//Argument msut be a string
			->argument(3, 'string')			//Argument must be a string
			->argument(4, 'string');		//Argument must be a string
			
		
		$query = array(
			'organizer_id'  => $organizer,
			'venue'			=> $venue,
			'country'		=> $country,
			'region'		=> $region);
		
		$query = array_merge($query, $this->_query);
		
		return $this->_getJsonResponse(self::URL_NEW, $query);	
	}
	
	/**
	 * Set Address
	 *
	 * @param string
	 * @param string|null
	 * @return this
	 */
	public function setAddress($address, $address2 = NULL) {
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$this->_query['address'] = $address;
		
		if(!is_null($address2)) {
			$this->_query['address2'] = $address2;
		}
		
		return $this;
	}
	
	/**
	 * Set city
	 *
	 * @param string
	 * @return this
	 */
	public function setCity($city) {
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['city'] = $city;
		return $this;
	}
	
	/**
	 * Set Country
	 *
	 * @param string
	 * @return this
	 */
	public function setCountry($country) {
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['country_code'] = $country;
		return $this;
	}
	
	/**
	 * Set postal
	 *
	 * @param string
	 * @return this
	 */
	public function setPostal($code) {
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['postal_code'] = $code;
		return $this;
	}
	
	/**
	 * Set Region
	 *
	 * @param string
	 * @return this
	 */
	public function setRegion($region) {
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['region'] = $region;
		return $this;
	}
	
	/**
	 * Updates the venue
	 *
	 * @param int
	 * @param string
	 * @return array
	 */
	public function update($id, $venue) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'int')		//Argument must be a integer
			->argument(2, 'string');	//Argument must be a string
			
		$query = array('id' => $id, 'venue' => $venue);
		$query = array_merge($query, $this->_query);
		
		return $this->getJsonResponse(self::URL_UPDATE, $query);	
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}










