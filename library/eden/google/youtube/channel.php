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
	const URL_YOUTUBE_REGION		= 'https://gdata.youtube.com/feeds/api/channelstandardfeeds/%s/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_startIndex	= NULL;
	protected $_maxResults	= NULL;
	protected $_time		= NULL;
	
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
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function search($queryString) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate parameters
		$query = array(
			self::QUERY			=> $queryString,
			self::START_INDEX	=> $this->_startIndex,	//optional
			self::MAX_RESULTS	=> $this->_maxResults,	//optional
			self::VERSION		=> self::VERSION_TWO);	
		
		return $this->_getResponse(self::URL_YOUTUBE_CHANNEL, $query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function getChannelFeeds($feeds) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		//if the input value is not allowed
		if(!in_array($feeds, array('most_viewed', 'most_subscribed'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_FEEDS_ONE) 
				->addVariable($feeds)
				->trigger();
		}
		
		//populate parameters
		$query = array(
			self::VERSION	=> self::VERSION_TWO,
			self::TIME		=> $this->_time);	
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CHANNEL_FEEDS, $feeds), $query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getChannelByRegion($regionId, $feeds) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//if the input value is not allowed
		if(!in_array($feeds, array('most_viewed', 'most_subscribed'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_FEEDS_TWO) 
				->addVariable($feeds)
				->trigger();
		}
		
		//populate parameters
		$query = array(self::VERSION => self::VERSION_TWO);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_REGION, $regionId, $feeds), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}