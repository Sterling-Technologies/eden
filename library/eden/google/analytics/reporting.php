<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google Analytics Reporting
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author     Christian Blanquera cblanquera@openovate.com
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
	protected $_dimensions		= array();
	protected $_sort			= array();
	protected $_filters			= NULL;
	protected $_segment			= array();
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
	
	public function __call($name, $args) {
		if(strpos($name, 'addDimension') === 0) {
			//addSegmentCity('Manila')
			$key = Eden_Type_String::i($name)
				->substr(12)
				->strtolower()
				->get();
			
			if(!isset(self::$_options[$key], $args[0])) {
				return $this;
			}
			
			$this->_dimensions[] = self::$_options[$key];
			return $this;
		}
		
		if(strpos($name, 'addSegment') === 0) {
			//addSegmentCity('Manila')
			$key = Eden_Type_String::i($name)
				->substr(10)
				->strtolower()
				->get();
			
			if(!isset(self::$_options[$key], $args[0])) {
				return $this;
			}
			
			$this->_segment[] = self::$_options[$key];
			return $this;
		}
		
		
		
		if(strpos($name, 'sortBy') === 0) {
			//sortByCity('Manila')
			$key = Eden_Type_String::i($name)
				->substr(6)
				->strtolower()
				->get();
			
			if(!isset(self::$_options[$key], $args[0])) {
				return $this;
			}
			
			$this->_sort[] = self::$_options[$key];
			return $this;
		}
		
		try {
			return parent::__call($name, $args);
		} catch(Eden_Error $e) {
			Eden_Sql_Error::i($e->getMessage())->trigger();
		}
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
	 * Set Max results
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
	 * @param string|array The dimensions parameter breaks down metrics by common criteria; 
	 * for example, by ga:browser or ga:city.
	 * @return this
	 */
	public function setDimensions($dimensions) {
		//argument 1 must be a string or array
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(is_string($dimensions)) {
			$dimensions = func_get_args();
		}
		
		foreach($dimensions as $i => $dimension) {
			if(isset(self::$_options[strtolower($dimension)])) {
				$dimensions[$i] = self::$_options[strtolower($dimension)];
			}
		}
		
		$this->_dimensions = $dimensions;
		
		return $this;
	}
	
	/**
	 * Sorting order is specified by the left to right order of the metrics 
	 * and dimensions listed. Sorting direction defaults to ascending and can be changed to descending 
	 * by using a minus sign (-) prefix on the requested field.
	 *
	 * @param string|array Example: ga:country,ga:browser.
	 * @return this
	 */
	public function setSort($sort) {
		//argument 1 must be a string or array
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(is_string($sort)) {
			$sort = func_get_args();
		}
		
		foreach($sort as $i => $key) {
			if(isset(self::$_options[strtolower($key)])) {
				$sort[$i] = self::$_options[strtolower($key)];
			}
		}
		
		$this->_sort = $sort;
		
		return $this;
	}
	
	/**
	 * Dimension or metric filters that restrict the data returned for your request.
	 *
	 * @param string Example: ga:browser >= FireFox
	 * @return this
	 */
	public function setFilters($filters) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		if(strpos($filters, ' ') === false) {
			$this->_filters = $filters;
			return $this;
		}
		
		$gaWord = true;
		$filters = explode(' ', $filters);
		
		foreach($filters as $i => $word) {
			if($gaWord) {
				if(strpos($word, 'ga:') !== 0) {
					$filters[$i] = 'ga:'.$word;
					if(isset(self::$_options[$word])) {
						$filters[$i] = self::$_options[$word];
					}
				}
				
				$gaWord = false;
			}
			
			if(strtolower($word) == 'and') {
				$filters[$i] = ';';
				$gaWord = false;
			} else if(strtolower($word) == 'or') {
				$filters[$i] = ',';
				$gaWord = false;
			}
		}
		
		$this->_filters = urlencode(implode('', $filters));
		
		return $this;
	}
	
	/**
	 * Segments the data returned for your request.
	 *
	 * @param string|array Example: dynamic::ga:medium%3D%3Dreferral.
	 * @return this
	 */
	public function setSegments($segments) {
		//argument 1 must be a string or array
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(is_string($segments)) {
			$segments = func_get_args();
		}
		
		foreach($segments as $i => $segment) {
			if(isset(self::$_options[strtolower($segment)])) {
				$segments[$i] = self::$_options[strtolower($segments)];
			}
		}
		
		$this->_segment = $segments;
		
		return $this;
	}
	
	/**
	 * Selector specifying a subset of fields to include in the response.
	 *
	 * @param string Example: rows,columnHeaders(name,dataType).
	 * @return this
	 */
	public function setFields($fields) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
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
	 * @param string
	 * @return this
	 */
	public function setUserIp($userIp) {
		//argument 1 must be a string
		Eden_Google_Error::i()->userIp(1, 'string');
		$this->_userIp = $prettyPrint;
		
		return $this;
	}
	
	/**
	 * Alternative to userIp in cases when the user's IP address is unknown.
	 *
	 * @param string
	 * @return this
	 */
	public function setQuotaUser($quotaUser) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
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
			->argument(1, 'string', 'int')		//argument 1 must be a string or int
			->argument(2, 'string', 'int')		//argument 2 must be a string or int
			->argument(3, 'string', 'int')		//argument 3 must be a string or int
			->argument(4, 'string', 'array');	//argument 4 must be a string or array
		 
		$id = (string) $id;
		if(strpos($id, 'ga:') !== 0) {
			$id = 'ga:'.$id;
		}
		
		if(is_string($startDate)) {
			$startDate = strtotime($startDate);
		}
		
		$startDate = date('Y-m-d', $startDate);
		
		if(is_string($endDate)) {
			$endDate = strtotime($endDate);
		}
		
		$endDate = date('Y-m-d', $endDate);
		
		if(!is_array($metrics)) {
			$metrics = explode(',', $metrics);
		}
		
		foreach($metrics as $i => $metric) {
			$metric = trim($metric);
			if(isset(self::$_options[strtolower($metric)])) {
				$metrics[$i] = self::$_options[strtolower($metric)];
			}
		}
		
		//populate parameters
		$query = array(
			'ids'			=> $id,
			'start-date'	=> $startDate,
			'end-date'		=> $endDate,
			'metrics'		=> implode(',', $metrics),
			'dimensions'	=> implode(',', $this->_dimensions),	//optional
			'sort'			=> implode(',', $this->_sort),			//optional
			'filters'		=> $this->_filters,						//optional
			'segment'		=> implode(',', $this->_segment),		//optional
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
	/* Large Data
	-------------------------------*/
	protected static $_options = array(
		'visitortype'					=> 'ga:visitorType',
		'visitcount'					=> 'ga:visitCount',
		'dayssincelastvisit'			=> 'ga:daysSinceLastVisit',
		'userdefinedvalue'				=> 'ga:userDefinedValue',
		'visitors'						=> 'ga:visitors',
		'newvisits'						=> 'ga:newVisits',
		'percentnewvisits'				=> 'ga:percentNewVisits',
		'visitlength'					=> 'ga:visitLength',
		'visits'						=> 'ga:visits',
		'bounces'						=> 'ga:bounces',
		'entrancebouncerate'			=> 'ga:entranceBounceRate',
		'visitbouncerate'				=> 'ga:visitBounceRate',
		'timeonsite'					=> 'ga:timeOnSite',
		'avgtimeonsite'					=> 'ga:avgTimeOnSite',
		'referralpath'					=> 'ga:referralPath',
		'campaign'						=> 'ga:campaign',
		'source'						=> 'ga:source',
		'medium'						=> 'ga:medium',
		'keyword'						=> 'ga:keyword',
		'adcontent'						=> 'ga:adContent',
		'organicsearches'				=> 'ga:organicSearches',
		'adgroup'						=> 'ga:adGroup',
		'adslot'						=> 'ga:adSlot',
		'adslotposition'				=> 'ga:adSlotPosition',
		'addistributionetwork'			=> 'ga:adDistributionNetwork',
		'admatchtype'					=> 'ga:adMatchType',
		'admatchedquery'				=> 'ga:adMatchedQuery',
		'adplacementdomain'				=> 'ga:adPlacementDomain',
		'adplacementurl'				=> 'ga:adPlacementUrl',
		'adformat'						=> 'ga:adFormat',
		'adtargetingtype'				=> 'ga:adTargetingType',
		'adtargetingoption'				=> 'ga:adTargetingOption',
		'addisplayurl'					=> 'ga:adDisplayUrl',
		'addestinationurl'				=> 'ga:adDestinationUrl',
		'adwordscustomerid'				=> 'ga:adwordsCustomerId',
		'adwordscampaignid'				=> 'ga:adwordsCampaignId',
		'adwordsadGroupid'				=> 'ga:adwordsAdGroupId',
		'adwordscreativeid'				=> 'ga:adwordsCreativeId',
		'qdwordscriteriaid'				=> 'ga:adwordsCriteriaId',
		'impressions'					=> 'ga:impressions',
		'adclicks'						=> 'ga:adClicks',
		'adcost'						=> 'ga:adCost',
		'cpm'							=> 'ga:CPM',
		'cpc'							=> 'ga:CPC',
		'ctr'							=> 'ga:CTR',
		'costpertransaction'			=> 'ga:costPerTransaction',
		'costpergoalconversion'			=> 'ga:costPerGoalConversion',
		'costperconversion'				=> 'ga:costPerConversion',
		'rpc'							=> 'ga:RPC',
		'roi'							=> 'ga:ROI',
		'margin'						=> 'ga:margin',
		'goalstarts'					=> 'ga:goal(n)Starts',
		'goalstartsall'					=> 'ga:goalStartsAll',
		'goalcompletions'				=> 'ga:goal(n)Completions',
		'goalcompletionsall'			=> 'ga:goalCompletionsAll',
		'goalvalue'						=> 'ga:goal(n)Value',
		'goalvalueall'					=> 'ga:goalValueAll',
		'goalvaluepervisit'				=> 'ga:goalValuePerVisit',
		'goalconversionrate'			=> 'ga:goal(n)ConversionRate',
		'goalconversionrateall'			=> 'ga:goalConversionRateAll',
		'goalabandons'					=> 'ga:goal(n)Abandons',
		'goalabandonsall'				=> 'ga:goalAbandonsAll',
		'goalabandonrate'				=> 'ga:goal(n)AbandonRate',
		'goalabandonrateall'			=> 'ga:goalAbandonRateAll',
		'browser'						=> 'ga:browser',
		'browserversion'				=> 'ga:browserVersion',
		'operatingsystem'				=> 'ga:operatingSystem',
		'operatingsystemversion'		=> 'ga:operatingSystemVersion',
		'flashversion'					=> 'ga:flashVersion',
		'javaenabled'					=> 'ga:javaEnabled',
		'ismobile'						=> 'ga:isMobile',
		'language'						=> 'ga:language',
		'screencolors'					=> 'ga:screenColors',
		'screenresolution'				=> 'ga:screenResolution',
		'continent'						=> 'ga:continent',
		'subcontinent'					=> 'ga:subContinent',
		'country'						=> 'ga:country',
		'region'						=> 'ga:region',
		'city'							=> 'ga:city',
		'latitude'						=> 'ga:latitude',
		'longitude'						=> 'ga:longitude',
		'networkdomain'					=> 'ga:networkDomain',
		'networklocation'				=> 'ga:networkLocation',
		'hostname'						=> 'ga:hostname',
		'pagepath'						=> 'ga:pagePath',
		'pagetitle'						=> 'ga:pageTitle',
		'landingpagepath'				=> 'ga:landingPagePath',
		'secondpagepath'				=> 'ga:secondPagePath',
		'exitpagepath'					=> 'ga:exitPagePath',
		'previouspagepath'				=> 'ga:previousPagePath',
		'nextpagepath'					=> 'ga:nextPagePath',
		'pagedepth'						=> 'ga:pageDepth',
		'entrances'						=> 'ga:entrances',
		'entrancerate'					=> 'ga:entranceRate',
		'pageviews'						=> 'ga:pageviews',
		'pageviewspervisit'				=> 'ga:pageviewsPerVisit',
		'uniquepageviews'				=> 'ga:uniquePageviews',
		'timeonpage'					=> 'ga:timeOnPage',
		'avgtimeonpage'					=> 'ga:avgTimeOnPage',
		'exits'							=> 'ga:exits',
		'exiteate'						=> 'ga:exitRate',
		'searchused'					=> 'ga:searchUsed',
		'searchkeyword'					=> 'ga:searchKeyword',
		'searchkeywordrefinement'		=> 'ga:searchKeywordRefinement',
		'searchcategory'				=> 'ga:searchCategory',
		'searchstartpage'				=> 'ga:searchStartPage',
		'searchdestinationpage'			=> 'ga:searchDestinationPage',
		'searchresultviews'				=> 'ga:searchResultViews',
		'searchuniques'					=> 'ga:searchUniques',
		'avgSearchresultviews'			=> 'ga:avgSearchResultViews',
		'searchvisits'					=> 'ga:searchVisits',
		'percentvisitswithsearch'		=> 'ga:percentVisitsWithSearch',
		'searchdepth'					=> 'ga:searchDepth',
		'avgsearchdepth'				=> 'ga:avgSearchDepth',
		'searchrefinements'				=> 'ga:searchRefinements',
		'searchduration'				=> 'ga:searchDuration',
		'avgsearchduration'				=> 'ga:avgSearchDuration',
		'searchexits'					=> 'ga:searchExits',
		'searchexitrate'				=> 'ga:searchExitRate',
		'searchgoalconversionrate'		=> 'ga:searchGoal(n)ConversionRate',
		'searchgoalconversionrateall'	=> 'ga:searchGoalConversionRateAll',
		'goalvalueallpersearch'			=> 'ga:goalValueAllPerSearch',
		'pageloadtime'					=> 'ga:pageLoadTime',
		'pageloadsample'				=> 'ga:pageLoadSample',
		'avgpageloadtime'				=> 'ga:avgPageLoadTime',
		'domainlookuptime'				=> 'ga:domainLookupTime',
		'avgdomainlookuptime'			=> 'ga:avgDomainLookupTime',
		'pagedownloadtime'				=> 'ga:pageDownloadTime',
		'avgpagedownloadtime'			=> 'ga:avgPageDownloadTime',
		'redirectiontime'				=> 'ga:redirectionTime',
		'avgredirectiontime'			=> 'ga:avgRedirectionTime',
		'serverconnectiontime'			=> 'ga:serverConnectionTime',
		'avgserverconnectiontime'		=> 'ga:avgServerConnectionTime',
		'serverresponsetime'			=> 'ga:serverResponseTime',
		'avgserverresponsetime'			=> 'ga:avgServerResponseTime',
		'speedmetricssample'			=> 'ga:speedMetricsSample',
		'eventcategory'					=> 'ga:eventCategory',
		'eventaction'					=> 'ga:eventAction',
		'eventlabel'					=> 'ga:eventLabel',
		'totalevents'					=> 'ga:totalEvents',
		'uniqueevents'					=> 'ga:uniqueEvents',
		'eventvalue'					=> 'ga:eventValue',
		'avgeventvalue'					=> 'ga:avgEventValue',
		'visitswithevent'				=> 'ga:visitsWithEvent',
		'eventspervisitwithevent'		=> 'ga:eventsPerVisitWithEvent',
		'transactionid'					=> 'ga:transactionId',
		'affiliation'					=> 'ga:affiliation',
		'visitstotransaction'			=> 'ga:visitsToTransaction',
		'daystotransaction'				=> 'ga:daysToTransaction',
		'productsku'					=> 'ga:productSku',
		'productname'					=> 'ga:productName',
		'productcategory'				=> 'ga:productCategory',
		'transactions'					=> 'ga:transactions',
		'transactionspervisit'			=> 'ga:transactionsPerVisit',
		'transactionrevenue'			=> 'ga:transactionRevenue',
		'revenuepertransaction'			=> 'ga:revenuePerTransaction',
		'transactionrevenuepervisit'	=> 'ga:transactionRevenuePerVisit',
		'transactionshipping'			=> 'ga:transactionShipping',
		'transactiontax'				=> 'ga:transactionTax',
		'totalvalue'					=> 'ga:totalValue',
		'itemquantity'					=> 'ga:itemQuantity',
		'uniquepurchases'				=> 'ga:uniquePurchases',
		'revenueperitem'				=> 'ga:revenuePerItem',
		'itemrevenue'					=> 'ga:itemRevenue',
		'itemsperpurchase'				=> 'ga:itemsPerPurchase',
		'customvarname'					=> 'ga:customVarName(n)',
		'customvarvalue'				=> 'ga:customVarValue(n)',
		'date'							=> 'ga:date',
		'year'							=> 'ga:year',
		'month'							=> 'ga:month',
		'week'							=> 'ga:week',
		'day'							=> 'ga:day',
		'hour'							=> 'ga:hour',
		'nthmonth'						=> 'ga:nthMonth',
		'nthweek'						=> 'ga:nthWeek',
		'nthday'						=> 'ga:nthDay',
		'dayofweek'						=> 'ga:dayOfWeek');
}