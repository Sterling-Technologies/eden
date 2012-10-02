<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Locations
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Locations extends Eden_Instagram {
	/* Constants
	-------------------------------*/
	const API_URL			= 'https://api.instagram.com/v1';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_access_token	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($access_token) {
		//argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
			
		$this->_access_token 	= $access_token;
	}

	/* Public Methods
	-------------------------------*/

	/**
	 * Get information about a location object
	 * @param  Integer $location_id Instagram location object ID
	 * @return Array           Information on the location object
	 */
	public function get($location_id)
	{	
		$url = $this->_buildurl(self::API_URL . "/locations/{$location_id}", array(
			'access_token' => $this->_access_token
		));

		return $this->_get($url);
	}

	/**
	 * Get a list of recent media objects from a given location.
	 * @param  Integer $location_id Instagram location object ID
	 * @param  Array $params List filters (http://instagram.com/developer/endpoints/locations/#get_locations_media_recent)
	 * @return Array           List of media from given location
	 */
	public function getRecent($location_id, $params = array())
	{	
		$url = $this->_buildurl(self::API_URL . "/location/{$location_id}/media/recent", array_merge(array(
			'access_token' => $this->_access_token
		), $params));

		return $this->_get($url);
	}

	/**
	 * Search for a location by geographic coordinate.
	 * @param  Array $params Search filters (http://instagram.com/developer/endpoints/locations/#get_locations_search)
	 * @return Array           Information on the tag object
	 */
	public function search($params)
	{	
		$url = $this->_buildurl(self::API_URL . "/locations/search", array_merge(array(
			'access_token' => $this->_access_token
		), $params));

		return $this->_get($url);
	}
}