<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Analytics_Management extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_ANALYTICS_ACCOUNTS		= 'https://www.googleapis.com/analytics/v3/management/accounts';
	const URL_ANALYTICS_WEBPROPERTIES	= 'https://www.googleapis.com/analytics/v3/management/accounts/%s/webproperties';
	const URL_ANALYTICS_PROFILE			= 'https://www.googleapis.com/analytics/v3/management/accounts/%s/webproperties/%s/profiles';
	const URL_ANALYTICS_GOALS			= 'https://www.googleapis.com/analytics/v3/management/accounts/%s/webproperties/%s/profiles/%s/goals';
	const URL_ANALYTICS_SEGMENTS		= 'https://www.googleapis.com/analytics/v3/management/segments';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_startIndex		= NULL;
	protected $_maxResults		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Set start index
	 *
	 * @param integer
	 * @return this
	 */
	public function setStartIndex($startIndex) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_startIndex = $startIndex;
		
		return $this;
	}
	
	/**
	 * Set start index
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_maxResults = $maxResults;
		
		return $this;
	}
	
	/**
	 * Returns all accounts to which the user has access.
	 *
	 * @return array
	 */
	public function getAccounts() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,		//optional
			self::MAX_RESULTS	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(self::URL_ANALYTICS_ACCOUNTS, $query);
	}
	
	/**
	 * Returns web properties to which the user has access
	 *
	 * @param string
	 * @return array
	 */
	public function getWebProperties($accountId = self::ALL) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,		//optional
			self::MAX_RESULTS	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_WEBPROPERTIES, $accountId), $query);
	}
	
	/**
	 * Returns lists of profiles to which the user has access
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getProfiles($accountId = self::ALL, $webPropertyId = self::ALL) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string	
			
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,		//optional
			self::MAX_RESULTS	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_PROFILE, $accountId, $webPropertyId), $query);
	}
	
	/**
	 * Returns lists of goals to which the user has access
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getGoals($accountId = self::ALL, $webPropertyId = self::ALL, $profileId = self::ALL) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
			
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,		//optional
			self::MAX_RESULTS	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_GOALS, $accountId, $webPropertyId, $profileId), $query);
	}
	
	/**
	 * Returns lists of advanced segments to which the user has access
	 *
	 * @return array
	 */
	public function getSegments() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,		///optional
			self::MAX_RESULTS	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(self::URL_ANALYTICS_SEGMENTS, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}