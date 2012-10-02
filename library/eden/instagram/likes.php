<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Likes
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Likes extends Eden_Instagram {
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
	 * Get a list of users who have liked this media
	 * @param  Integer $media_id Media ID
	 * @return Array           List of users
	 */
	public function get($media_id)
	{	
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/likes", array(
			'access_token' => $this->_access_token
		));

		return $this->_get($url);
	}

	/**
	 * Set a like on this media by the currently authenticated user.
	 * @param  Integer $media_id Media ID
	 * @return Array           Response
	 */
	public function like($media_id)
	{
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/likes");
		return $this->_post($url, array(
			'access_token' => $this->_access_token
		));
	}

	/**
	 * Set a like on this media by the currently authenticated user.
	 * @param  Integer $media_id Media ID
	 * @return Array           Response
	 */
	public function unlike($media_id)
	{
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/likes");

		return $this->_delete($url);
	}
}