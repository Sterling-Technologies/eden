<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google youtube video
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Video extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_FEEDS		= 'https://gdata.youtube.com/feeds/api/standardfeeds/%s';
	const URL_YOUTUBE_CATEGORY	= 'https://gdata.youtube.com/feeds/api/videos';
	const URL_YOUTUBE_REGION	= 'http://gdata.youtube.com/feeds/api/standardfeeds/%s/%s';
	const URL_YOUTUBE_FAVORITES	= 'http://gdata.youtube.com/feeds/api/users/%s/favorites';
	const URL_YOUTUBE_GET		= 'https://gdata.youtube.com/feeds/api/videos/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_feeds 		= 'most_popular';
	
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
	 * Returns the most highly rated YouTube videos.
	 *
	 * @return this
	 */
	public function filterByTopRated() {
		$this->_feeds = 'top_rated';
		
		return $this;
	}
	
	/**
	 * Returns videos most frequently flagged as favorite videos.
	 *
	 * @return this
	 */
	public function filterByTopFavorites() {
		$this->_feeds = 'top_favorites';
		
		return $this;
	}
	
	/**
	 * Returns YouTube videos most frequently shared on Facebook and Twitter.
	 *
	 * @return this
	 */
	public function filterByMostShared() {
		$this->_feeds = 'most_shared';
		return $this;
	}
	
	/**
	 * Returns the most popular YouTube videos, 
	 *
	 * @return this
	 */
	public function filterByMostPopular() {
		$this->_feeds = 'most_popular';
		return $this;
	}
	
	/**
	 * Returns videos most recently submitted to YouTube.
	 *
	 * @return this
	 */
	public function filterByMostRecent() {
		$this->_feeds = 'most_recent';
		return $this;
	}
		
	/**
	 * Returns YouTube videos that have received the most comments.
	 *
	 * @return this
	 */
	public function filterByMostDiscussed() {
		$this->_feeds = 'most_discussed';
		return $this;
	}
	
	/**
	 * Returns YouTube videos that receive the most video responses.
	 *
	 * @return this
	 */
	public function filterByMostResponded() {
		$this->_feeds = 'most_responded';
		return $this;
	}
	
	/**
	 * Returns videos recently featured on the YouTube home page or featured videos tab.
	 *
	 * @return this
	 */
	public function filterByRecentFeatured() {
		$this->_feeds = 'recently_featured';
		return $this;
	}
	
	/**
	 * Returns lists trending videos as seen on YouTube Trends,
	 *
	 * @return this
	 */
	public function filterByOnTheWeb() {
		$this->_feeds = 'on_the_web';
		return $this;
	}
	
	/**
	 * Returns a specific videos
	 *
	 * @param string
	 * @return array
	 */
	public function getSpecific($videoId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
	
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_GET, $videoId));
	}
	
	/**
	 * Returns a collection of videos of users favorites.
	 *
	 * @return array
	 */
	public function getFavorites() {
		
		$this->_query[self::VERSION] = self::VERSION_TWO;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FAVORITES, $this->_feeds), $this->_query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getList() {
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FEEDS, $this->_feeds));
	}
	
	/**
	 * Returns a collection of videos from category.
	 *
	 * @param string
	 * @return array
	 */
	public function getListByCategory($category) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::CATEGORY]	= $category;
		$this->_query[self::VERSION]	= self::VERSION_TWO;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CATEGORY, $this->_feeds), $this->_query);
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function getListByRegion($regionId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate parameters
		$query = array(self::VERSION => self::VERSION_TWO);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_REGION, $regionId, $this->_feeds), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}