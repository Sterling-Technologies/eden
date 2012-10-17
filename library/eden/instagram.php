<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram API factory. This is a factory class with 
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Instagram Auth Instance
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Instagram_Auth
	 */
	public function auth($client_id, $client_secret) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Instagram_Auth::i($client_id, $client_secret);
	}

	/**
	 * Returns Instagram Users Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Users
	 */
	public function users($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
		
		return Eden_Instagram_Users::i($access_token);
	}

	/**
	 * Returns Instagram Relationships Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Relationships
	 */
	public function relationships($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');	//Argument 1 must be a string
		
		return Eden_Instagram_Relationships::i($access_token);
	}

	/**
	 * Returns Instagram Media Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Media
	 */
	public function media($access_token = null) {
		return Eden_Instagram_Media::i($access_token);
	}

	/**
	 * Returns Instagram Comments Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Comments
	 */
	public function comments($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');	//Argument 1 must be a string
		
		return Eden_Instagram_Comments::i($access_token);
	}

	/**
	 * Returns Instagram Subscriptions Instance
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Instagram_Subscriptions
	 */
	public function subscriptions($client_id, $client_secret) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');		//Argument 2 must be a string
		
		return Eden_Instagram_Subscriptions::i($client_id, $client_secret);
	}

	/**
	 * Returns Instagram Likes Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Likes
	 */
	public function likes($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
		
		return Eden_Instagram_Likes::i($access_token);
	}

	/**
	 * Returns Instagram Tags Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Tags
	 */
	public function tags($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
		
		return Eden_Instagram_Tags::i($access_token);
	}

	/**
	 * Returns Instagram Locations Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Locations
	 */
	public function locations($access_token) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
		
		return Eden_Instagram_Locations::i($access_token);
	}

	/**
	 * Returns Instagram Geographies Instance
	 *
	 * @param *string 
	 * @return Eden_Instagram_Geographies
	 */
	public function geographies($client_id) {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string');		//Argument 1 must be a string
		
		return Eden_Instagram_Geographies::i($client_id);
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _post($url, $post_fields = array())
	{
		$response = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setPost(true)
			->setPostFields(http_build_query($post_fields))
			->getJsonResponse();

		return $response;
	}

	protected function _get($url)
	{
		$response = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->getJsonResponse();

		return $response;
	}

	protected function _delete($url)
	{
		$response = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setCustomDelete()
			->getJsonResponse();
			
		return $response;
	}


	protected function _buildurl($url, $params)
	{
		$url .= '?' . http_build_query($params);
		return $url;
	}

	/* Private Methods
	-------------------------------*/
}