<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google youtube channel
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Channel extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_CHANNEL		= 'https://gdata.youtube.com/feeds/api/channels';
	const URL_YOUTUBE_CHANNEL_FEEDS	= 'https://gdata.youtube.com/feeds/api/channelstandardfeeds/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query 		= NULL;
	protected $_startIndex	= NULL;
	protected $_maxResults	= NULL;
	protected $_feeds		= NULL;
	protected $_time		= NULL;
	protected $_regionId	= NULL;
	protected $_version		= '2';
	
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
	 * Set the keyword yoy want to search
	 *
	 * @param string
	 * @return this
	 */
	public function setQuery($query) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query = $query;
		
		return $this;
	}
	
	/**
	 * Country acronyms
	 *
	 * @param string
	 * @return this
	 */
	public function setRegionId($regionId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_regionId = $regionId;
		
		return $this;
	}
	
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
	 * Returns all feeds this day
	 *
	 * @return this
	 */
	public function setToday() {
		$this->_time = 'today';
		
		return $this;
	}
	
	/**
	 * Returns all feeds this week
	 *
	 * @return this
	 */
	public function setThisWeek() {
		$this->_time = 'this_week';
		
		return $this;
	}
	
	/**
	 * Returns all feeds this month
	 *
	 * @return this
	 */
	public function setThisMonth() {
		$this->_time = 'this_month';
		
		return $this;
	}
	
	/**
	 * Returns all feeds 
	 *
	 * @return this
	 */
	public function setToAllTime() {
		$this->_time = 'all_time';
		
		return $this;
	}
	
	/**
	 * Returns most frequently watched YouTube channels
	 *
	 * @return this
	 */
	public function setByMostViewed() {
		$this->_feeds = 'most_viewed';
		
		return $this;
	}
	
	/**
	 * Returns the channels with the most subscribers or the most 
	 * new subscribers during a given time period.
	 *
	 * @return this
	 */
	public function setByMostSubscribed() {
		$this->_feeds = 'most_subscribed';
		
		return $this;
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getlist() {
		//populate parameters
		$query = array(
			self::QUERY			=> $this->_query,
			self::START_INDEX	=> $this->_startIndex,
			self::MAX_RESULTS	=> $this->_maxResults,
			self::VERSION		=> $this->_version);	
		
		return $this->_getResponse(self::URL_YOUTUBE_CHANNEL, $query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getChannelFeeds() {
		//populate parameters
		$query = array(
			self::VERSION	=> $this->_version,
			self::TIME		=> $this->_time);	
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CHANNEL_FEEDS, $this->_feeds), $query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getChannelByRegion() {
		//populate parameters
		$query = array(self::VERSION => $this->_version);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_REGION, $this->_regionId, $this->_feeds), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}