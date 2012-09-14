<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Create Facebook post
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Post extends Eden_Class {
	/* Constants
	-------------------------------*/	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_id		= 'me';
	protected $_post	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $message) {
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');	
			
		$this->_token 	= $token;
		$this->_post['message'] = $message;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * sends the post to facebook
	 *
	 * @return this
	 */
	public function create() {
		//get the facebook graph url
		$url = Eden_Facebook_Graph::GRAPH_URL.$this->_id.'/feed';
		$query = array('access_token' => $this->_token);
		$url .= '?'.http_build_query($query);
		
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
			
		return $response;									//return the id
	}
	
	/**
	 * Sets media description
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
	 * Sets anicon for this post
	 *
	 * @param string
	 * @return this
	 */
	public function setIcon($url){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'url');
		
		$this->_post['icon'] = $url;
		return $this;
	}
	
	public function setId($id) {
		Eden_Facebook_Error::i()->argument(1, 'numeric');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * sets the link to your post
	 *
	 * @param string
	 * @return this
	 */
	public function setLink($url) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'url');
		
		$this->_post['link'] = $url;
		return $this;
	}
	
	/**
	 * sets the picture to your post
	 *
	 * @param string
	 * @return this
	 */
	public function setPicture($url) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'url');
		
		$this->_post['picture'] = $url;
		return $this;
	}
	
	/**
	 * Sets the title of a post
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_post['title'] = $title;
		return $this;
	}
	
	/**
	 * sets the video to your post
	 *
	 * @param string
	 * @return this
	 */
	public function setVideo($url) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'url');
		
		$this->_post['video'] = $url;
		return $this;	
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}