<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Xend API factory. This is a factory class with 
 * methods that will load up different Xend classes.
 * Xend classes are organized as described on their 
 * developer site: booking, rate, shipment and tracking service. 
 *
 * @package    Eden
 * @category   Zappos
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos extends Eden_Class {
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
	 * Returns 
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Search
	 */
	public function search($apiKey) {
		return Eden_Zappos_Search::i($apiKey);
	}
	
	/**
	 * Returns 
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Search
	 */
	public function getImage($apiKey) {
		return Eden_Zappos_Image::i($apiKey);
	}
	
	/**
	 * Returns 
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Search
	 */
	public function getProduct($apiKey) {
		return Eden_Zappos_Product::i($apiKey);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}