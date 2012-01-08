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
	public static function i($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setEvent($id) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		$this->_query['event_id'] = $id;
		
		return $this;
	}
	
	public function setName($name) {
		//Argument 1 must be numeric
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['name'] = $name;
		
		return $this;
	}
	
	public function setPrice($price) {
		//Argument 1 must be float
		Eden_Eventbrite_Error::i()->argument(1, 'float');
		$this->_query['price'] = $price;
		
		return $this;
	}
	
	public function setQuantity($quantity) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		$this->_query['quantity'] = $quantity;
		
		return $this;
	}
	
	public function setDonation() {
		$this->_query['is_donation'] = 1;
		
		return $this;
	}
	
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	public function setStart($start) {
		//Argument 1 must be an integer or string
		Eden_Eventbrite_Error::i()->argument(1, 'int', 'string');
		//if start is a string
		if(is_string($start)) {
			//then convert it to unixcode
			$start = strtotime($start);
		}
	
		$start = date('Y-m-d H:i:s', $start);
		//add it to our query
		$query['start_sales'] = $start;
		
		return $this;
	}
	
	public function setEnd($end) {
		//Argument 1 must be an integer or string
		Eden_Eventbrite_Error::i()->argument(1, 'int', 'string');
		//if start is a string
		if(is_string($start)) {
			//then convert it to unixcode
			$end = strtotime($end);
		}
	
		$end = date('Y-m-d H:i:s', $end);
		//add it to our query
		$query['end_sales'] = $end;
		
		return $this;
	}
	
	public function setFee() {
		$this->_query['include_fee'] = 1;
		
		return $this;
	}
	
	public function setMin($quantity) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		if($min < 0) {
			$min = 0;
		}
		$this->_query['min'] = $min;
		
		return $this;
	}
	
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		if($max < 1) {
			$max = 1;
		}
		
		$this->_query['max'] = $max;
		
		return $this;
	}
	
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
	
	public function add() {
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



