<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google youtube search
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Search extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_SEARCH	= 'https://gdata.youtube.com/feeds/api/videos';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_startIndex	= NULL;
	protected $_maxResults	= NULL;
	protected $_orderBy		= NULL;
	
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
	public function setStart($start) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_startIndex = $start;
		
		return $this;
	}
	
	/**
	 * Set start index
	 *
	 * @param integer
	 * @return this
	 */
	public function setRange($range) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_maxResults = $range;
		
		return $this;
	}
	
	/**
	 * Order results by relevance
	 *
	 * @return this
	 */
	public function orderByRelevance() {
		$this->_orderBy = 'relevance';
		
		return $this;
	}
	
	/**
	 * Order results by published
	 *
	 * @return this
	 */
	public function orderByPublished() {
		$this->_orderBy = 'published';
		
		return $this;
	}
	
	/**
	 * Order results by viewCount
	 *
	 * @return this
	 */
	public function orderByViewCount() {
		$this->_orderBy = 'viewCount';
		
		return $this;
	}
	
	/**
	 * Order results by rating
	 *
	 * @return this
	 */
	public function orderByRating() {
		$this->_orderBy = 'rating';
		
		return $this;
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function getResponse($queryString) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate parameters
		$query = array(
			self::QUERY			=> $queryString,
			self::VERSION		=> self::VERSION_TWO,	
			self::START_INDEX	=> $this->_startIndex,	//optional
			self::MAX_RESULTS	=> $this->_maxResults,	//optional
			self::ORDER_BY		=> $this->_orderBy);	//optional
		
		return $this->_getResponse(self::URL_YOUTUBE_SEARCH, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}