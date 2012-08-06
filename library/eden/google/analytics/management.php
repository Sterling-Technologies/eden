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
	protected $_accountId		= '~all';
	protected $_webPropertyId	= '~all';
	protected $_profileId		= '~all';
	
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
	 * Account ID to retrieve web properties for
	 *
	 * @param string
	 * @return this
	 */
	public function setAccountId($accountId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_accountId = $accountId;
		
		return $this;
	}
	
	/**
	 * Web property ID for the profiles to retrieve
	 *
	 * @param string
	 * @return this
	 */
	public function setWebPropertyId($webPropertyId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_webPropertyId = $webPropertyId;
		
		return $this;
	}
	
	/**
	 * Profile ID to retrieve goals for.
	 *
	 * @param string
	 * @return this
	 */
	public function setProfileId($profileId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_profileId = $profileId;
		
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
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults);	
		
		return $this->_getResponse(self::URL_ANALYTICS_ACCOUNTS, $query);
	}
	
	/**
	 * Returns web properties to which the user has access
	 *
	 * @return array
	 */
	public function getWebProperties() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults);	
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_WEBPROPERTIES, $this->_accountId), $query);
	}
	
	/**
	 * Returns lists of profiles to which the user has access
	 *
	 * @return array
	 */
	public function getProfiles() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults);	
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_PROFILE, $this->_accountId, $this->_webPropertyId), $query);
	}
	
	/**
	 * Returns lists of goals to which the user has access
	 *
	 * @return array
	 */
	public function getGoals() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults);	
		
		return $this->_getResponse(sprintf(self::URL_ANALYTICS_GOALS, $this->_accountId, $this->_webPropertyId, $this->_profileId), $query);
	}
	
	/**
	 * Returns lists of advanced segments to which the user has access
	 *
	 * @return array
	 */
	public function getSegments() {
		//populate parameters
		$query = array(
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults);	
		
		return $this->_getResponse(self::URL_ANALYTICS_SEGMENTS, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}