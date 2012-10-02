<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Subscriptions
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Subscriptions extends Eden_Class {
	/* Constants
	-------------------------------*/
	const API_URL			= 'https://api.instagram.com/v1/subscriptions';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_client_id 		= NULL;
	protected $_client_secret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($client_id, $client_secret) {
		//argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_client_id 	= $client_id;
		$this->_client_secret 	= $client_secret;
	}

	/* Public Methods
	-------------------------------*/
	public function subscribe($object, $aspect, $callback_url)
	{
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string');

		$url 		= self::API_URL;
		$verify_token = sha1($this->_client_id.$object.$callback_url);
		$post = array(
			'client_id' => $this->_client_id,
			'client_secret' => $this->_client_secret,
			'object' => $object,
			'aspect' => $aspect,
			'verify_token' => $verify_token,
			'callback_url' => $callback_url
		);

		//send it off
		$results = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setPost(true)
			->setPostFields(http_build_query($post))
			->getResponse();
		
		return $verify_token;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}