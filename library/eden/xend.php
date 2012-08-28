<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/xend/base.php';
require_once dirname(__FILE__).'/xend/error.php';
require_once dirname(__FILE__).'/xend/booking.php';
require_once dirname(__FILE__).'/xend/rate.php';
require_once dirname(__FILE__).'/xend/shipment.php';
require_once dirname(__FILE__).'/xend/tracking.php';

/**
 * Xend API factory. This is a factory class with 
 * methods that will load up different Xend classes.
 * Xend classes are organized as described on their 
 * developer site: booking, rate, shipment and tracking service. 
 *
 * @package    Eden
 * @category   xend
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Xend extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns xend booking service
	 *
	 * @param *string User token
	 * @param *boolean test mode
	 * @return Eden_Xend_Booking
	 */
	public function booking($userToken, $test = true) {
		return Eden_Xend_Booking::i($userToken, $test = true);
	}
	
	/**
	 * Returns xend rate service
	 *
	 * @param *string User token
	 * @param *boolean test mode
	 * @return Eden_Xend_Rate
	 */
	public function rate($userToken, $test = true) {
		return Eden_Xend_Rate::i($userToken, $test = true);
	}
	
	/**
	 * Returns xend shipment service
	 *
	 * @param *string User token
	 * @param *boolean test mode
	 * @return Eden_Xend_Shipment
	 */
	public function shipment($userToken, $test = true) {
		return Eden_Xend_Shipment::i($userToken, $test = true);
	}
	
	/**
	 * Returns xend tracking service
	 *
	 * @param *string User token
	 * @param *boolean test mode
	 * @return Eden_Xend_Tracking
	 */
	public function tracking($userToken, $test = true) {
		return Eden_Xend_Tracking::i($userToken, $test = true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}