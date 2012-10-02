<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Tags
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Tags extends Eden_Instagram {
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
	 * Get information about a tag object
	 * @param  String $tag Tag name
	 * @return Array           Information on the tag object
	 */
	public function get($tag)
	{	
		$url = $this->_buildurl(self::API_URL . "/tags/{$tag_name}", array(
			'access_token' => $this->_access_token
		));

		return $this->_get($url);
	}

	/**
	 * Get a list of recently tagged media. Note that this media is ordered by when the media
	 * was tagged with this tag, rather than the order it was posted. Use the max_tag_id and
	 * min_tag_id parameters in the pagination response to paginate through these objects.
	 * @param  String $tag Tag name
	 * @param  Array $params Search filters (http://instagram.com/developer/endpoints/tags/#get_tags_media_recent)
	 * @return Array           List of recently tagged media
	 */
	public function getRecent($tag, $params = array())
	{	
		$url = $this->_buildurl(self::API_URL . "/tags/{$tag_name}", array_merge(array(
			'access_token' => $this->_access_token
		), $params));

		return $this->_get($url);
	}

	/**
	 * Search for tags by name. Results are ordered first as an exact match, then by popularity.
	 * @param  String $tag Tag to search
	 * @param  Array $params Search filters (http://instagram.com/developer/endpoints/tags/#get_tags_media_recent)
	 * @return Array           Information on the tag object
	 */
	public function search($tag)
	{	
		$url = $this->_buildurl(self::API_URL . "/tags/search", array(
			'access_token' => $this->_access_token,
			'q' => $tag
		));

		return $this->_get($url);
	}
}