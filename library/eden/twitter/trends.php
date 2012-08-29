<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter trends
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Trends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST			= 'https://api.twitter.com/1/trends/%s.json';
	const URL_GET_DETAIL		= 'https://api.twitter.com/1/trends/available.json';
	const URL_GET_DAILY_TRENDS 	= 'https://api.twitter.com/1/trends/daily.json';
	const URL_GET_WEEKLY_TRENS 	= 'http://api.twitter.com/version/trends/weekly.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the locations that Twitter has 
	 * trending topic information
	 *
	 * @param float|null
	 * @param float|null
	 * @return array
	 */
	public function getDetail($lat = NULL, $long = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'float', 'null')	//Argument 1 must be a float or null
			->argument(2, 'float', 'null');	//Argument 2 must be a float or null
		
		//if it is not empty
		if(!is_null($lat)) {
			//lets put it in query
			$this->_query['lat'] = $lat;
		}
		
		//if it is not empty
		if(!is_null($long)) {
			//lets put it in query
			$this->_query['long'] = $long;
		}
		
		return $this->_getResponse(self::URL_GET_DETAIL, $this->_query);
	}
	
	/**
	 * Returns the top 10 trending topics for a specific
	 * WOEID, if trending information is available for it.
	 *
	 * @param integer
	 * @param string|null
	 * @return array
	 */
	public function getList($id, $exclude = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'int')				//Argument 1 must be an integer
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
		
		if(!is_null($exclude)) {
			//lets put it in query
			$this->_query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(sprintf(self::URL_GET_LIST, $id), $this->_query);
	}
	
	/**
	 * Returns the top 20 trending topics
	 * for each hour in a given day.
	 *
	 * @param sting|null
	 * @param string|null
	 * @return array
	 */
	public function getDailyTrends($date = NULL, $exclude = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')		//Argument 1 must be a string or null
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
		
		//if it is not empty
		if(!is_null($date)) {
			//lets put it in query
			$this->_query['date'] = date('Y-m-d', strtotime($date));
		}
		
		//if it is not empty
		if(!is_null($exclude)) {
			//lets put it in query
			$this->_query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(self::URL_GET_DAILY_TRENDS, $this->_query);
	}
	
	/**
	 * Returns the top 30 trending topics 
	 * for each day in a given week.
	 *
	 * @param sting|null
	 * @param string|null
	 * @return array
	 */
	public function getWeeklyTrends($date = NULL, $exclude = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')		//Argument 1 must be a string or null
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
		
		//if it is not empty
		if(!is_null($date)) {
			//lets put it in query
			$this->_query['date'] = date('Y-m-d', strtotime($date));
		}
		
		//if it is not empty
		if(!is_null($exclude)) {
			//lets put it in query
			$this->_query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(self::URL_GET_WEEKLY_TRENDS, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}