<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Relationships
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
	protected $_client_id	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($client_id) {
		//argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
			
		$this->_client_id 	= $client_id;
	}

	/* Public Methods
	-------------------------------*/

	/**
	 * Get very recent media from a geography subscription that you created.
	 * Note: you can only access Geographies that were explicitly created by your OAuth client.
	 * To backfill photos from the location covered by this geography, use the media search endpoint (http://instagram.com/developer/endpoints/media/).
	 * @param  Integer $geo_id Instagram Geography Object ID
	 * @param  Array $params Search filters (http://instagram.com/developer/endpoints/geographies/#get_geographies_media_recent)
	 * @return Array           List of media from given geography
	 */
	public function getRecent($geo_id, $params = array())
	{
		$url = $this->_buildurl(self::API_URL . "/geographies/{$geo_id}/media/recent", array_merge(array(
			'client_id' => $this->_client_id
		), $params));

		return $this->_get($url);
	}
}