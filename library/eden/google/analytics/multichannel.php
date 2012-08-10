<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google analytics multi channel funnel
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Analytics_Multichannel extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_ANALYTICS_MULTI_CHANNEL = 'https://www.googleapis.com/analytics/v3/data/mcf';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_startIndex		= NULL;
	protected $_maxResults		= NULL;
	protected $_dimensions		= NULL;
	protected $_sort			= NULL;
	protected $_filters			= NULL;
	
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
	 * Set dimensions
	 *
	 * @param integer
	 * @return this
	 */
	public function setDimesion($dimensions) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_dimensions = $dimensions;
		
		return $this;
	}
	
	/**
	 * Set sort
	 *
	 * @param integer
	 * @return this
	 */
	public function setSort($sort) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_sort = $sort;
		
		return $this;
	}
	
	/**
	 * Dimension or metric filters that restrict the data returned for your request.
	 *
	 * @param integer
	 * @return this
	 */
	public function setFilters($filters) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_filters = $filters;
		
		return $this;
	}
	
	/**
	 * Returns all accounts to which the user has access.
	 *
	 * @param string Unique table ID of the form
	 * @param string First date of the date range for which you are requesting the data. YYYY-MM-DD.
	 * @param string Last date of the date range for which you are requesting the data. YYYY-MM-DD.
	 * @param string List of comma-separated metrics, such as ga:visits,ga:bounces.
	 * @return array
	 */
	public function getInfo($id, $startDate, $endDate, $metrics) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
			
		//populate parameters
		$query = array(
			'ids'			=> $id,
			'start-date'	=> $startDate,
			'end-date'		=> $endDate,
			'metrics'		=> $metrics,
			'dimensions'	=> $this->_dimensions,		//optional
			'sort'			=> $this->_sort,			//optional
			'filters'		=> $this->_filters,			//optional
			'start-index'	=> $this->_startIndex,		//optional
			'max-results'	=> $this->_maxResults);		//optional
		
		return $this->_getResponse(self::URL_ANALYTICS_MULTI_CHANNEL, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}