<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter local trends
 *
 * @package    Eden
 * @category   Twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_LocalTrends extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'https://api.twitter.com/1/trends/1.json';
	const URL_GET_DETAIL	= 'https://api.twitter.com/1/trends/available.json';
	
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
		
		$query = array('woeid' => $id);
		//if it is not empty
		if(!is_null($exclude)) {
			//lets put it in query
			$query['exclude'] = $exclude;
		}
		
		return $this->_getResponse(self::URL_GET_LIST);
	}
	
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
		
		$query = array();
		
		//if it is not empty
		if(!is_null($lat)) {
			//lets put it in query
			$query['lat'] = $lat;
		}
		
		//if it is not empty
		if(!is_null($long)) {
			//lets put it in query
			$query['long'] = $long;
		}
		
		return $this->_getResponse(self::URL_GET_DETAIL);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}