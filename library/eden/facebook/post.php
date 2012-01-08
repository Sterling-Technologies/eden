<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Facebook post
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Facebook_Post extends Eden_Class {
	/* Constants
	-------------------------------*/	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token 		= NULL;
	protected $_message		= NULL;
	protected $_link		= NULL;
	protected $_picture		= NULL;
	protected $_video		= NULL;
	protected $_title		= NULL;
	protected $_description	= NULL;
	protected $_icon		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($token) {
		return self::_getMultiple(__CLASS__, $token);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($token) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');	
			
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * sets the message to your post
	 *
	 * @param string
	 * @return this
	 */
	public function setMessage($message) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_message = $message;
		return $this;
	}
	
	public function setTitle($title){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_title = $title;
		return $this;
	}
	
	public function setDescription($description){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_description = $description;
		return $this;
	}
	
	public function setIcon($url){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_icon = $url;
		return $this;
	}
	
	/**
	 * sets the link to your post
	 *
	 * @param string
	 * @param string|null
	 * @param string|null
	 * @return this
	 */
	public function setLink($url) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_link = $url;
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
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_picture = $url;
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
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_video = $url;
		return $this;	
	}
	
	/**
	 * sends the post to facebook
	 *
	 * @return this
	 */
	public function send() {
		//post variable must be array
		$post = array();
		
		//if there is a name set it into post
		if($this->_title) {
			$post['name'] = $this->_title;
		}
		
		if($this->_icon) {
			$post['icon'] = $this->_icon;
		}
		
		//if there is a description set it into post
		if($this->_description) {
			$post['description'] = $this->_description;
		}
		
		//if there is a message set it into post
		if($this->_message) {
			$post['message'] = $this->_message;
		}
		
		//if there is a link set it into post
		if($this->_link) {
			$post['link'] = $this->_link;
		}
		
		//if there is a picture set it into post
		if($this->_picture) {
			$post['picture'] = $this->_picture;
		}
		
		//if there is a video set it into post
		if($this->_video) {
			$post['source'] = $this->_video;
		}
		
		print_r($post);
		
		//get the facebook graph url
		$url = Eden_Facebook_Graph::GRAPH_URL.$id.'/feed';
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
			->when(!empty($post))								//if post is not empty
			->setPost(true)										//set post to true
			->setPostFields(http_build_query($post))			//set post fields
			->endWhen()											//endif/endwhen
			->getJsonResponse();								//get the json response
		print_r($response);
		return $response['id'];									//return the id
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}