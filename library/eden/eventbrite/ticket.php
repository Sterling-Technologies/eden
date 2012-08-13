<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite ticketing
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
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
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Creates the ticket
	 *
	 * @return array
	 */
	public function create() {
		if(!isset($this->_query['event_id'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::EVENT_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['name'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::NAME_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['price'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::PRICE_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['quantity'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::QUANTITY_NOT_SET)->trigger();
		}
		
		$query = $this->_query;
		if(isset($query['hide'])) {
			unset($query['hide']);
		}
		
		return $this->_getJsonResponse(self::URL_NEW, $query);
	}
	
	/**
	 * Set the description
	 * 
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	/**
	 * Accept donations
	 * 
	 * @return this
	 */
	public function setDonation() {
		$this->_query['is_donation'] = 1;
		
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
		
		$this->_query['end_sales'] = $end;
		
		return $this;
	}
	
	/**
	 * Set event ID
	 * 
	 * @param int
	 * @return this
	 */
	public function setEvent($id) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		$this->_query['event_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Include Eventbrite's fee on top of the ticket fee
	 *
	 * @return this
	 */
	public function setFee() {
		$this->_query['include_fee'] = 1;
		
		return $this;
	}
	
	/**
	 * If true, will hide the ticket type
	 *
	 * @param bool
	 * @return this
	 */
	public function setHide($hide) {
		//Argument 1 must be a boolean
		Eden_Eventbrite_Error::i()->argument(1, 'bool');
		
		//if the string hide is show
		if($hide) { 
			//hide is equal to yes
			$this->_query['hide'] = 'y';
		} else if($hide ===  false) {
			//hide is equal to no
			$this->_query['hide'] = 'n';
		}
		
		return $this;
	}
	
	/**
	 * Set Ticket ID
	 *
	 * @param int
	 * @return this
	 */
	 public function setId($ticketId) {
		 //Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		$this->_query['id'] = $ticketId;
		
		return $this;
	 }
	
	/**
	 * Set the maximum number of tickets per order
	 *
	 * @param int
	 * @return this
	 */
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		if($max < 1) {
			$max = 1;
		}
		
		$this->_query['max'] = $max;
		
		return $this;
	}
	
	/**
	 * Set the minimum number of tickets per order
	 *
	 * @param int
	 * @return this
	 */
	public function setMin($quantity) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		if($min < 0) {
			$min = 0;
		}
		$this->_query['min'] = $min;
		
		return $this;
	}
	
	/**
	 * Set ticket name
	 * 
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['name'] = $name;
		
		return $this;
	}
	
	/**
	 * Set price
	 * 
	 * @param float
	 * @return this
	 */
	public function setPrice($price) {
		//Argument 1 must be float
		Eden_Eventbrite_Error::i()->argument(1, 'float', 'int');
		$this->_query['price'] = $price;
		
		return $this;
	}
	
	/**
	 * Set quantity
	 * 
	 * @param int
	 * @return this
	 */
	public function setQuantity($quantity) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		$this->_query['quantity'] = $quantity;
		
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
		
		$this->_query['start_sales'] = $start;
		
		return $this;
	}
	
	/**
	 * Updates the ticket
	 *
	 * @return array
	 */
	public function update() {
		if(!isset($this->_query['event_id'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::EVENT_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['name'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::NAME_NOT_SET)->trigger();
		}
		
		
		if(!isset($this->_query['price'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::PRICE_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['quantity'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::QUANTITY_NOT_SET)->trigger();
		}
		
		return $this->_getJsonResponse(self::URL_UPDATE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}



