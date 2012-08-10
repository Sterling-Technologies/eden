<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite new or update discount
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Discount extends Eden_Eventbrite_Base {
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
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Creates the discount
	 * 
	 * @param int the event id
	 * @return array
	 */
	public function create($event) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query = $this->_query;
		$query['event_id'] = $event;
		return $this->_getJsonResponse(self::URL_NEW, $query);
	}
	
	/**
	 * Sets the discount amount
	 *
	 * @param float|int
	 * @return this
	 */
	public function setAmountOff($amount) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'float', 'int');
		
		$this->_query['amount_off'] = $amount;
		
		return $this;
	}
	
	/**
	 * Sets the discount code
	 *
	 * @param string
	 * @return this
	 */
	public function setCode($code) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['code'] = $code;
		
		return $this;
	}
	
	/**
	 * Set the end time
	 *
	 * @param string|int
	 * @return this
	 */
	public function setEnd($end) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$this->_query['end_date'] = $end;
		
		return $this;
	}
	
	/**
	 * Sets the discount percent 
	 *
	 * @param float|int
	 * @return this
	 */
	public function setPercentOff($percent) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int', 'float');
		
		$this->_query['percent_off'] = $percent;
		
		return $this;
	}
	
	/**
	 * Set quantity 
	 *
	 * @param int
	 * @return this
	 */
	public function setQuantity($quantity) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$this->_query['quantity_available'] = $quantity;
		
		return $this;
	}
	
	/**
	 * Set the start time
	 *
	 * @param int|string
	 * @return this
	 */
	public function setStart($start) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		$this->_query['start_date'] = $start;
		
		return $this;
	}
	
	/**
	 * Set ticket ID or a list of ticket IDs 
	 *
	 * @param string|array
	 * @return this
	 */
	public function setTickets($tickets) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($tickets)) {
			$tickets = implode(',', $tickets);
		}
		
		$this->_query['tickets'] = $tickets;
		
		return $this;
	}
	
	/**
	 * Creates the discount
	 * 
	 * @param int the discount id
	 * @return array
	 */
	public function update($id) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query = $this->_query;
		$query['id'] = $id;
		return $this->_getJsonResponse(self::URL_UPDATE, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}