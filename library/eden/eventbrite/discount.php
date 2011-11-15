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
class Eden_Eventbrite_Event_Discount extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW = 'https://www.eventbrite.com/json/discount_new';
	const URL_UPDATE = 'https://www.eventbrite.com/json/discount_update';
	
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
	public function add($event, $code, $amount, $percent, $tickets, $quantity, $start, $end) {
		//Argument Test
		Eden_Eventbrite_Error::get()
			->argument(1, 'int')				//Argument 1 must be an integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'float')				//Argument 3 must be a float
			->argument(4, 'float')				//Argument 4 must be a float
			->argument(5, 'string', 'array')	//Argument 5 must be a string or array
			->argument(6, 'int')				//Argument 6 must be an array
			->argument(7, 'string')				//Argument 7 must be a string
			->argument(8, 'string');			//Argument 8 must be a string
		
		if(is_array($tickets)) {
			$tickets = implode(',', $tickets);
		}
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$query = array(
			'event_id' 				=> $event,
			'code'					=> $code,
			'amount_off'			=> $amount,
			'percent_off'			=> $percent,
			'tickets'				=> $tickets,
			'quantity_available'	=> $quantity,
			'start_date'			=> $start,
			'end_date'				=> $end);
		
		return $this->_getJsonResponse(self::URL_NEW, $query);
	}
	
	public function update($id, $code, $amount, $percent, $tickets, $quantity, $start, $end) {
		//Argument Test
		Eden_Eventbrite_Error::get()
			->argument(1, 'int')				//Argument 1 must be an integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'float')				//Argument 3 must be a float
			->argument(4, 'float')				//Argument 4 must be a float
			->argument(5, 'string', 'array')	//Argument 5 must be a string or array
			->argument(6, 'int')				//Argument 6 must be an array
			->argument(7, 'string')				//Argument 7 must be a string
			->argument(8, 'string');			//Argument 8 must be a string
		
		if(is_array($tickets)) {
			$tickets = implode(',', $tickets);
		}
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$query = array(
			'id' 					=> $id,
			'code'					=> $code,
			'amount_off'			=> $amount,
			'percent_off'			=> $percent,
			'tickets'				=> $tickets,
			'quantity_available'	=> $quantity,
			'start_date'			=> $start,
			'end_date'				=> $end);
		
		return $this->_getJsonResponse(self::URL_UPDATE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}