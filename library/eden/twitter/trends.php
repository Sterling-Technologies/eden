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
 * @category   Twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Trends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_DAILY_TRENDS = 'https://api.twitter.com/1/trends/daily.json';
	const URL_GET_WEEKLY_TRENS = 'http://api.twitter.com/version/trends/weekly.json';
	
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
		
		$query = array();
		
		//if it is not empty
		if(!is_null($date)) {
			//lets put it in query
			$query['date'] = date('Y-m-d', strtotime($date));
		}
		
		//if it is not empty
		if(!is_null($exclude)) {
			//lets put it in query
			$query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(self::URL_GET_DAILY_TRENDS, $query);
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
		
		$query = array();
		
		//if it is not empty
		if(!is_null($date)) {
			//lets put it in query
			$query['date'] = date('Y-m-d', strtotime($date));
		}
		
		//if it is not empty
		if(!is_null($exclude)) {
			//lets put it in query
			$query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(self::URL_GET_WEEKLY_TRENDS, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}