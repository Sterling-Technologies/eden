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
class Eden_Google_Analytics_Reporting extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_ANALYTICS_CORE_REPORTING	= 'https://www.googleapis.com/analytics/v3/data/ga';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_startIndex		= NULL;
	protected $_maxResults		= NULL;
	protected $_dimensions		= NULL;
	protected $_sort			= NULL;
	protected $_filters			= NULL;
	protected $_segment			= NULL;
	protected $_fields			= NULL;
	protected $_prettyPrint		= NULL;
	protected $_userIp			= NULL;
	protected $_quotaUser		= NULL;
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
	 * Segments the data returned for your request.
	 *
	 * @param integer
	 * @return this
	 */
	public function setSegment($segment) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_segment = $segment;
		
		return $this;
	}
	
	/**
	 * Selector specifying a subset of fields to include in the response.
	 *
	 * @param integer
	 * @return this
	 */
	public function setFields($fields) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_fields = $fields;
		
		return $this;
	}
	
	/**
	 * Returns response with indentations and line breaks.
	 *
	 * @param integer
	 * @return this
	 */
	public function setPrettyPrint($prettyPrint) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_prettyPrint = $prettyPrint;
		
		return $this;
	}
	
	/**
	 * Specifies IP address of the end user for whom the API call is being made.
	 *
	 * @param integer
	 * @return this
	 */
	public function setUserIp($userIp) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->userIp(1, 'integer');
		$this->_userIp = $prettyPrint;
		
		return $this;
	}
	
	/**
	 * Alternative to userIp in cases when the user's IP address is unknown.
	 *
	 * @param integer
	 * @return this
	 */
	public function setQuotaUser($quotaUser) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'integer');
		$this->_quotaUser = $quotaUser;
		
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
			'segment'		=> $this->_segment,			//optional
			'start-index'	=> $this->_startIndex,		//optional
			'max-results'	=> $this->_maxResults,		//optional
			'fields'		=> $this->_fields,			//optional
			'prettyPrint'	=> $this->_prettyPrint,		//optional
			'userIp'		=> $this->_userIp,			//optional
			'quotaUser'		=> $this->_quotaUser);		//optional
		
		return $this->_getResponse(self::URL_ANALYTICS_CORE_REPORTING, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}