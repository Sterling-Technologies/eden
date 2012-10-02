<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Media
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Media extends Eden_Instagram {
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
	
	public function __construct($access_token = null)
	{
		if( !is_null($access_token) ) {
			$this->_access_token 	= $access_token;
		}
	}

	/* Public Methods
	-------------------------------*/

	/**
	 * Get information about a media object. Note: if you authenticate with an OAuth Token,
	 * you will receive the user_has_liked key which quickly tells you whether the current user has liked this media item.
	 * @param  Integer $media_id Instagram Media ID
	 * @return Array          Media Information
	 */
	public function get($media_id)
	{
		$params = array();
		if( !empty($this->_access_token) ) {
			$params['access_token'] = $this->_access_token;
		}

		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}", $params);
		return $this->_get($url);
	}

	/**
	 * Search for media in a given area.
	 * @param Array $params Parameters for the media search (http://instagram.com/developer/endpoints/media/#get_media_search)
	 * @return Array Media search results
	 */
	public function search($params = array())
	{
		if( !empty($this->_access_token) ) {
			$params['access_token'] = $this->_access_token;
		}

		$url = $this->_buildurl(self::API_URL . "/media/search", $params);
		return $this->_get($url);
	}

	/**
	 * Get a list of what media is most popular at the moment.
	 * @return Array          Results
	 */
	public function popular()
	{
		$params = array();
		if( !empty($this->_access_token) ) {
			$params['access_token'] = $this->_access_token;
		}

		$url = $this->_buildurl(self::API_URL . "/media/popular", $params);
		return $this->_get($url);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}