<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * United Kingdom
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Country_Unitedkingdom extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a list of counties
	 *
	 * @return array
	 */
	public function getCounties() {
		return include(dirname(__FILE__).'/unitedkingdom/counties.php');
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}