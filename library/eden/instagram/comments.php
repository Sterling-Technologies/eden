<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Comments
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Comments extends Eden_Instagram {
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
	 * Get a full list of comments on a media.
	 * Required scope: comments
	 * @param  Integer $media_id Instagram Media ID
	 * @return Array          Media comments
	 */
	public function get($media_id)
	{
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/comments", array(
			'access_token' => $this->_access_token
		));
		return $this->_get($url);
	}

	/**
	 * Create a comment on a media.
	 * Required scope: comments
	 * @param  Integer $media_id Instagram Media ID
	 * @param  Array $params Parameters of the comment (http://instagram.com/developer/endpoints/comments/#post_media_comments)
	 * @return Array          Response
	 */
	public function post($media_id, $params)
	{
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/comments");
		$params['access_token'] = $this->_access_token;
		
		return $this->_post($url, $params);
	}

	/**
	 * Delete a comment on a media.
	 * Required scope: comments
	 * @param  Integer $media_id Instagram Media ID
	 * @param  Integer $comment_id Instagram Comment ID
	 * @return Array          Response
	 */
	public function delete($media_id, $comment_id)
	{
		$url = $this->_buildurl(self::API_URL . "/media/{$media_id}/comments/{$comment_id}", array(
			'access_token' => $this->_access_token
		));

		return $this->_delete($url);
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}