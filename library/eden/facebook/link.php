<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Create Facebook link
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Link extends Eden_Class {
	/* Constants
	-------------------------------*/	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_id 		= 'me';
	protected $_post 	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $url) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'url');	
		
		$this->_token 	= $token;
		$this->_post 	= array('link' => $url);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * sends the post to facebook
	 *
	 * @return int
	 */
	public function create() {
		//get the facebook graph url
		$url 		= Eden_Facebook_Graph::GRAPH_URL.$this->_id.'/links';
		$query 		= array('access_token' => $this->_token);
		$url 		.= '?'.http_build_query($query);
		
		//send it into curl
		$response = Eden_Curl::i()
			->setUrl($url)										//sets the url
			->setConnectTimeout(10)								//sets connection timeout to 10 sec.
			->setFollowLocation(true)							//sets the follow location to true 
			->setTimeout(60)									//set page timeout to 60 sec
			->verifyPeer(false)									//verifying Peer must be boolean
			->setUserAgent(Eden_Facebook_Auth::USER_AGENT)		//set facebook USER_AGENT
			->setHeaders('Expect')								//set headers to EXPECT
			->setPost(true)										//set post to true
			->setPostFields(http_build_query($this->_post))		//set post fields
			->getJsonResponse();								//get the json response
        	if (array_key_exists('error', $response)) {
            		throw Eden_Facebook_Error::i($response['error']['message']);
        	}			
		return $response['id'];									//return the id
	}
	
	/**
	 * Sets a picture caption
	 *
	 * @param string
	 * @return this
	 */
	public function setCaption($caption){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_post['caption'] = $caption;
		return $this;
	}
	
	/**
	 * Sets description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_post['description'] = $description;
		return $this;
	}
	
	/**
	 * Set the profile id
	 *
	 * @param int|string
	 * @return this
	 */
	public function setId($id) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'int', 'string');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Sets the link title
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_post['name'] = $name;
		return $this;
	}
	
	/**
	 * Sets a picture
	 *
	 * @param string
	 * @return this
	 */
	public function setPicture($picture){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'url');
		
		$this->_post['picture'] = $picture;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}