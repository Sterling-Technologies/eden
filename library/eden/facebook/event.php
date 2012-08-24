<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Create Facebook Event
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Event extends Eden_Class {
	/* Constants
	-------------------------------*/	
	const OPEN 		= 'OPEN';
	const CLOSED 	= 'CLOSED';
	const SECRET 	= 'SECRET';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_id 		= 'me';
	protected $_post 	= array();
	protected $_venue	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $name, $start, $end) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string', 'int')
			->argument(4, 'string', 'int');	
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$this->_token 	= $token;
		$this->_post 	= array(
			'name'			=> $name,
			'start_time' 	=> $start,
			'end_time' 		=> $end);
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * sends the post to facebook
	 *
	 * @return int
	 */
	public function create() {
		//post variable must be array
		$post = $this->_post;
		
		if(!empty($this->_venue)) {
			$post['venue'] = json_encode($this->_venue);
		}
		
		//get the facebook graph url
		$url = Eden_Facebook_Graph::GRAPH_URL.$this->_id.'/events';
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
			->setPostFields(http_build_query($post))			//set post fields
			->getJsonResponse();								//get the json response
			
		return $response['id'];									//return the id
	}
	
	/**
	 * Sets the venue city
	 *
	 * @param string
	 * @return this
	 */
	public function setCity($city){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_venue['city'] = $city;
		return $this;
	}
	
	/**
	 * Sets the venue coordinates
	 *
	 * @param float
	 * @param float
	 * @return this
	 */
	public function setCoordinates($latitude, $longitude){
		Eden_Facebook_Error::i()->argument(1, 'float')->argument(2, 'float');
		
		$this->_venue['latitude'] = $latitude;
		$this->_venue['longitude'] = $longitude;
		return $this;
	}
	
	/**
	 * Sets the venue country
	 *
	 * @param string
	 * @return this
	 */
	public function setCountry($country){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_venue['country'] = $country;
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
	
	public function setId($id) {
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'numeric');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Sets the title of a post
	 *
	 * @param string
	 * @return this
	 */
	public function setLocation($location){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_post['location'] = $location;
		return $this;
	}
	
	/**
	 * Sets privacy to closed
	 *
	 * @return this
	 */
	public function setPrivacyClosed() {
		$this->_post['privacy'] = self::CLOSED;
		return $this;
	}
	
	/**
	 * Sets privacy to open
	 *
	 * @return this
	 */
	public function setPrivacyOpen() {
		$this->_post['privacy'] = self::OPEN;
		return $this;
	}
	
	/**
	 * Sets privacy to secret
	 *
	 * @return this
	 */
	public function setPrivacySecret() {
		$this->_post['privacy'] = self::SECRET;
		return $this;
	}
	
	/**
	 * Sets the venue state
	 *
	 * @param string
	 * @return this
	 */
	public function setState($state){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_venue['state'] = $state;
		return $this;
	}
	
	/**
	 * Sets the venue street
	 *
	 * @param string
	 * @return this
	 */
	public function setStreet($street){
		//Argument 1 must be a string
		Eden_Facebook_Error::i()->argument(1, 'string');
		
		$this->_venue['street'] = $street;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}