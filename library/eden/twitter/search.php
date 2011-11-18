<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Twitter_Search extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_SEARCH	= 'http://search.twitter.com/search.json';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	protected static $_validResult = array('mixed', 'recent', 'popular');
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns tweets that match a specified query
	 *
	 * @param id is integer.
	 * @param count is integer.
	 * @param page is integer
	 * @return $this
	 */
	 public function search($q, $callback = NULL, $geocode = NULL, $lang = NULL, $locale = NULL, $page = NULL, $result = NULL, $rpp = NULL, $show = false, $until = NULL, $since = NULL, $entities = NULL) {
		//Argument Test
		Eden_Twitter_Error::get()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'float')				//Argument 3 must be a flaot
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(6, 'int')				//Argument 6 must be an integer
			->argument(7, 'string')				//Argument 7 must be as string
			->argument(8, 'string')				//Argument 8 must be as integer
			->argument(9, 'boolean')			//Argument 9 must be a boolean
			->argument(10, 'string')			//Argument 10 must be a string
			->argument(11, 'string')			//Argument 11 must be a string
			->argument(12, 'boolean');			//Argument 12 must be a boolean
			
		$query = array('q' => $q);
		//if it is not empty
		if(!is_null($callback)) {
			//lets put it in query
			$query['callback'] = $callback;
		}
		//if it is not empty
		if(!is_null($geocode)) {
			//lets put it in query
			$query['geocode'] = $geocode;
		}
		//if it is not empty
		if(!is_null($lang)) {
			//lets put it in query
			$query['lang'] = $lang;
		}
		//if it is not empty
		if(!is_null($locale)) {
			//lets put it in query
			$query['locale'] = $locale;
		}
		//if it is not empty
		if(!is_null($page)) {
			//lets put it in query
			$query['page'] = $count;
		}
		//if there is a result
		if(!is_null($result))  {
			//if result is a string
			if(is_string($result)) {
				//lets make it an array
				$result = explode(',', $result);
			}
			//at this point result will be an array
			$results = array();
			//for each result
			foreach($result as $event) {
				//if this result is a valid result
				if(in_array($result, $this->_validResult)) {
					//lets add this to our valid resulr list 
					$results[] = $event;
				}
			}
			//if we have at least one valid result
			if(!empty($results)) {
				//lets make results into a string
				$result = implode(',', $result);
				//and add to query
				$query['result_type'] = $result;		
			}
		
		}
		//if rpp is not empty and less than equal to 100
		if(!is_null($rpp) && $rpp <= 100) {
			//lets put in in query
			$query['rpp'] = $rpp;
		}
		//if show
		if($show) {
			$query['show_user'] = 1;
		}
		//if it is not empty
		if(!is_null($until)) {
			$until = date('Y-m-d', $until);
		//add it to our query
		$query['until'] = $until;
		}
		//if it is not empty and 
		if(!is_null($since)) {
			//lets put it in query
			$query['since_id'] = $since;
		}
		//if entities
		if($entities) {
			$query['include_entities'] = 1;
		}
	
		return $this->_getResponse(self::URL_SEARCH, $query);
	 }
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}