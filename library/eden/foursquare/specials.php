<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square special
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Specials extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_SPECIAL_ADD			= 'https://api.foursquare.com/v2/specials/add';
	const URL_SPECIAL_GET			= 'https://api.foursquare.com/v2/specials/list';
	const URL_SPECIAL_SEARCH		= 'https://api.foursquare.com/v2/specials/search';
	const URL_SPECIAL_GET_DETAIL	= 'https://api.foursquare.com/v2/specials/%s/configuration';
	const URL_SPECIAL_FLAG			= 'https://api.foursquare.com/v2/specials/%s/flag';
	const URL_SPECIAL_RETIRE		= 'https://api.foursquare.com/v2/specials/%s/retire';
	
	/* Public Properties
	-------------------------------*/
	protected $_venueId		= NULL;
	protected $_status		= NULL;
	protected $_name		= NULL;
	protected $_finePrint	= NULL;
	protected $_count1		= NULL;
	protected $_count2		= NULL;
	protected $_count3		= NULL;
	protected $_offerId		= NULL;
	protected $_cost		= NULL;
	protected $_type		= NULL;
	protected $_text		= NULL;
	
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set venue Id
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueId($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_venueId = $venueId;
		
		return $this;
	}
	
	/**
	 * Set specials to return: pending, active, expired, all
	 * 
	 * @param string
	 * @return this
	 */
	public function setStatus($status) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		
		//if the input value is not allowed
		if(!in_array($status, array('pending', 'active', 'expired', 'all'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_STATUS) 
				->addVariable($status)
				->trigger();
		}
		
		$this->_status = $status;
		
		return $this;
	}
	
	/**
	 * A name for the special.
	 * 
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_name = $name;
		
		return $this;
	}
	
	/**
	 * Additional text about why the user has flagged this special
	 * 
	 * @param string
	 * @return this
	 */
	public function setText($text) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_text = $text;
		
		return $this;
	}
	
	/**
	 * Maximum length of 200 characters. Fine print, 
	 * shown in small type on the special detail page.
	 * 
	 * @param string
	 * @return this
	 */
	public function setFinePrint($finePrint) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_finePrint = $finePrint;
		
		return $this;
	}
	
	/**
	 * Count for frequency, count, regular, swarm, friends, and flash specials
	 * 
	 * @param integer
	 * @return this
	 */
	public function count1($count1) {
		//argument 1 must be a integer
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_count1 = $count1;
		
		return $this;
	}
	
	/**
	 * Secondary count for regular, flash specials
	 * 
	 * @param integer
	 * @return this
	 */
	public function count2($count2) {
		//argument 1 must be a integer
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_count2 = $count2;
		
		return $this;
	}
	
	/**
	 * Tertiary count for flash specials
	 * 
	 * @param integer
	 * @return this
	 */
	public function count3($count3) {
		//argument 1 must be a integer
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_count3 = $count3;
		
		return $this;
	}
	
	/**
	 * Maximum length of 16 characters.
	 * Internal id in your 3rd party system.
	 * 
	 * @param integer 
	 * @return this
	 */
	public function setOfferId($offerId) {
		//argument 1 must be a integer
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_offerId = $offerId;
		
		return $this;
	}
	
	/**
	 * The amount of money the user must spend to use this 
	 * special in dollars and cents. For example, 5.50 meaning 5 dollars and 50 cents.
	 * 
	 * @param integer|float
	 * @return this
	 */
	public function setCost($cost) {
		//argument 1 must be a integer or float
		Eden_Foursquare_Error::i()->argument(1, 'int', 'float');						
		$this->_cost = $cost;
		
		return $this;
	}
	
	/**
	 * The type of special to mayor
	 * unlocked only for the mayor
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToMayor() {					
		$this->_type = 'mayor';
		
		return $this;
	}
	
	/**
	 * The type of special to frequency
	 * unlocked every count1 check-ins
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToFrequency() {					
		$this->_type = 'frequency';
		
		return $this;
	}
	
	/**
	 * The type of special to count
	 * unlocked on the count1th check-in (all-time)
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToCount() {					
		$this->_type = 'count';
		
		return $this;
	}
	
	/**
	 * The type of special to regular
	 * unlocked if you have checked in at least count1 times in the last count2 days
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToRegular() {					
		$this->_type = 'regular';
		
		return $this;
	}
	
	/**
	 * The type of special to swarm
	 * unlocked if there are count1 people here right now (but only for the first count1 people)
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToSwarm() {					
		$this->_type = 'swarm';
		
		return $this;
	}
	
	/**
	 * The type of special to swarm
	 * unlocked if at least count1 friends check in together.
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToFriends() {					
		$this->_type = 'friends';
		
		return $this;
	}
	
	/**
	 * The type of special to flash
	 * first-come first-serve; unlocked for the first count1 
	 * people to check in between count2 and count3 (given in 
	 * minutes since midnight, local time) each day. In all cases, 
	 * the user must be at the venue (checked in within the last 3 hours, 
	 * and not having checked in anywhere else since then) to unlock a special.
	 * 
	 * @param string
	 * @return this
	 */
	public function setTypeToFlash() {					
		$this->_type = 'flash';
		
		return $this;
	}
	
	/**
	 * Allows you to create a new special.
	 *  
	 * @param string Maximum length of 200 characters.
	 * @param string Maximum length of 200 characters. Special text that is shown when the user has unlocked the special.
	 * @return this
	 */
	public function createSpecial($text, $unlockedText) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$query = array(
			'text' 			=> $text,
			'unlockedText'	=> $unlockedText,
			'name'			=> $this->_name,		//optional
			'finePrint'		=> $this->_finePrint,	//optional
			'count1'		=> $this->_count1,		//optional
			'count2'		=> $this->_count2,		//optional
			'count3'		=> $this->_count3,		//optional
			'type'			=> $this->_type,		//optional
			'offerId'		=> $this->_offerId,		//optional
			'cost'			=> $this->_cost);		//optional
		
		return $this->_post(self::URL_SPECIAL_ADD, $query);
	}
	
	/**
	 * List available specials.
	 *  
	 * @return this
	 */
	public function getSpecial() {
		
		$query = array(
			'venueId' 	=> $this->_venueId,	//optional
			'status'	=> $this->_status);		//optional
		
		return $this->_getResponse(self::URL_SPECIAL_GET, $query);
	}
	 
	/**
	 * Returns a list of specials near the current location. 
	 *  
	 * @param string|integer|float Longtitude
	 * @param string|integer|float Latitude
	 * @return this
	 */
	public function search($longtitude, $latitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string, integer or float
			->argument(2, 'string', 'int', 'float');	//argument 2 must be a string, integer or float
		
		$query = array(
			'll' 		=> $longtitude.',',$latitude,
			'radius'	=> $this->_radius,				//optional
			'limit'		=> $this->_limit);				//optional
		
		return $this->_getResponse(self::URL_SPECIAL_SEARCH, $query);
	}
	
	/**
	 * Get special configuration details.
	 *  
	 * @param string The ID of the special to retrieve configuration details for.
	 * @return this
	 */
	public function getSpecialDetail($specialId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return $this->_getResponse(sprintf(self::URL_SPECIAL_GET_DETAIL, $specialId));
	}
	
	/**
	 * Allows users to indicate a Special is improper in some way. 
	 *  
	 * @param string The ID of the special being flagged
	 * @param string The id of the venue running the special.
	 * @param string One of not_redeemable, not_valuable, other
	 * @return this
	 */
	public function flag($specialId, $venueId, $problem) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string		
		
		//if the input value is not allowed
		if(!in_array($problem, array('not_redeemable', 'not_valuable', 'other'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_PROBLEM_SPECIAL) 
				->addVariable($problem)
				->trigger();
		}
		
		//populate fields
		$query = array(
			'venueId'	=> $venueId,
			'problem'	=> $problem,
			'text'		=> $this->_text);	//optional
		
		return $this->_post(sprintf(self::URL_SPECIAL_FLAG, $specialId), $query);
	}
	
	/**
	 * Retire a special. Retired specials will not show up in the list 
	 * of specials and cannot be assigned to a group. Also ends any 
	 * active campaigns associated with the special.
	 *  
	 * @param string The ID of the special to retire
	 * @return this
	 */
	public function retire($specialId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');			
		
		return $this->_post(sprintf(self::URL_SPECIAL_RETIRE, $specialId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}