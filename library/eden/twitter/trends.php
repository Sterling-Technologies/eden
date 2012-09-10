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
	const URL_TRENDING_PLACE		= 'https://api.twitter.com/1.1/trends/place.json';
	const URL_TRENDING_AVAILABLE	= 'https://api.twitter.com/1.1/trends/available.json';
	const URL_TRENDING_CLOSEST		= 'https://api.twitter.com/1.1/trends/closest.json';
	
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
	 * Returns the top 10 trending topics for a specific WOEID, if trending 
	 * information is available for it.
	 *
	 * @param string|integer The Yahoo! Where On Earth ID of the location to return 
	 * trending information for. Global information is available by using 1 as the WOEID.
	 * @return array
	 */
	public function getPlaceTrending($id) {
		//Argument 1 must be a string or integer
		Eden_Twitter_Error::i()->argument(1, 'string', 'int');
		
		$this->_query['id'] = $id;
		
		return $this->_getResponse(self::URL_TRENDING_PLACE, $this->_query);
	}
	
	/**
	 * Returns the locations that Twitter has trending topic information for.
	 *
	 * @return array
	 */
	public function getAvailableTrending() {
		
		return $this->_getResponse(self::URL_TRENDING_AVAILABLE);
	}
	
	/**
	 * Returns the locations that Twitter has trending topic information for, closest to a specified location.
	 *
	 * @param float|null
	 * @param float|null
	 * @return array
	 */
	public function getClosestTrending($lat = NULL, $long = NULL) {
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
		
		return $this->_getResponse(self::URL_TRENDING_CLOSEST, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}