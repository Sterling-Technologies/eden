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
class Eden_Eventbrite_Ticket extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW = 'https://www.eventbrite.com/json/ticket_new';
	const URL_UPDATE = 'https://www.eventbrite.com/json/ticket_update';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
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
	public function add($event, $name,  $price, $quantity, $description = NULL, $donation = false, $start = NULL, $end = NULL, $fee = false, $min = NULL, $max = NULL) {
		//argument test
		Eden_Eventbrite_Error::get()
			->argument(1, 'numeric')							//Argument 1 must be numeric
			->argument(2, 'string')								//Argument 2 must be a string
			->argument(3, 'float')								//Argument 3 must a float
			->argument(4, 'int')								//Argument 4 must be an integer
			->argument(5, 'string', 'null')						//Argument 5 must be a string or null
			->argument(6, 'bool')	 		  				    //Argument 6 must be an integer
			->argument(7, 'string', 'int', 'null')				//Argument 7 must be a string, integer or null
			->argument(8, 'string', 'int', 'null')				//Argument 8 must be a string, integer or null
			->argument(9, 'bool')								//Argument 9 must be an integer
			->argument(10, 'int')								//Argument 10 must be an integer
			->argument(11, 'int', 'null')						//Argument 11 must be an integer or null
			->argument(12, 'int', 'null');						//Argument 12 must be an integer or null
			
		$query = array (		
			'event_id'      => $event,
			'name'		    => $name,
			'price'			=> $price,
			'quantity'		=> $quantity);

		if($donation){
			$query['is_donation'] = 1;	
		}
		//if description is not empty
		if(!is_null($description)){
			//add it to our query
			$query['description'] = $description;
		}
		//if start is not empty
		if(!is_null($start)){
			//if start is a string
			if(is_string($start)) {
				//then convert it to unixcode
				$start = strtotime($start);
			}
		
			$start = date('Y-m-d H:i:s', $start);
			//add it to our query
			$query['start_sales'] = $start;
		}
		//if end is not empty
		if(!is_null($end)){
			//if end is a string
			if(is_string($end)){
				//then convert it to unixcode
				$end = strtotime($end);	
			}
		
			$end = date('Y-m-d H:i:s', $end);
			//add it to our query
			$query['end_sales'] = $end;
		}
		
		if($fee){
			$query['include_fee'] = 1;	
		}
		//if min is not empty and min is not greater than 0
		if(!is_null($min) && $min > 0){
			//add it to our query
			$query['min'] =  $min;	
		}
		//if maqx is not empty and max is not greater than equal to min
		if(!is_null($max) && $max > 0 && $max >= $min){
			//add it to our query
			$query['max'] = $max;	
		}
		return $this->_getJsonResponse(self::URL_NEW, $query);
			
	}
	
	public function update($event, $name,  $price, $quantity, $description = NULL, $donation = false, $start = NULL, $end = NULL, $fee = false, $min = NULL, $max = NULL, $hide = NULL) {
		//argument test		
		Eden_Eventbrite_Error::get()
			->argument(1, 'numeric')							//Argument 1 must be numeric
			->argument(2, 'string')								//Argument 2 must be a string
			->argument(3, 'float')								//Argument 3 must a float
			->argument(4, 'int')								//Argument 4 must be an integer
			->argument(5, 'string', 'null')						//Argument 5 must be a string or null
			->argument(6, 'bool')	 		  				    //Argument 6 must be an integer
			->argument(7, 'string', 'int', 'null')				//Argument 7 must be a string, integer or null
			->argument(8, 'string', 'int', 'null')				//Argument 8 must be a string, integer or null
			->argument(9, 'bool')								//Argument 9 must be an integer
			->argument(10, 'int')								//Argument 10 must be an integer
			->argument(11, 'int', 'null')						//Argument 11 must be an integer or null
			->argument(12, 'int', 'null')						//Argument 12 must be an integer or null
			->argument(13, 'bool', 'null');						//Argument 13 must be a boolean or null
			
		$query = array (		
			'event_id'      => $event,
			'name'		    => $name,
			'price'			=> $price,
			'quantity'		=> $quantity);

		if($donation){
			$query['is_donation'] = 1;	
		}
		//if description is not empty
		if(!is_null($description)){
			//add it to our query
			$query['description'] = $description;
		}
		//if start is not empty
		if(!is_null($start)){
			//if start is a string
			if(is_string($start)) {
				//then convert it to unixcode
				$start = strtotime($start);
			}
			
			$start = date('Y-m-d H:i:s', $start);
			//add it to our query
			$query['start_sales'] = $start;
		}
		//if start is not empty
		if(!is_null($end)) {
			//if start is a string
			if(is_string($end)){
				//then convert it to unixcode
				$end = strtotime($end);	
			}
		
			$end = date('Y-m-d H:i:s', $end);
			//add it to our query
			$query['end_sales'] = $end;
		}
		
		if($fee) {
			$query['include_fee'] = 1;	
		}
		//if min is not empty and min is not greater than 0 
		if(!is_null($min) && $min > 0 ){
			//add it to our query
			$query['min'] =  $min;	
		}
		//if maqx is not empty and max is not greater than equal to min
		if(!is_null($max) && $max > 0 && $max >= $min ){
			//add it to our query
			$query['max'] = $max;	
		}
		//if the string hide is show
		if($hide) { 
			//hide is equal to yes
			$query['hide'] = 'y';
		} else if($hide ===  false) {
			//hide is equal to no
			$query['hide'] = 'n';
		}
	
		return $this->_getJsonResponse(self::URL_UPDATE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}



