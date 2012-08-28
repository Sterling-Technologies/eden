<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Canada
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Country_Ca extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_territories = array(
		'BC' => 'British Columbia',				'ON' => 'Ontario', 
		'NL' => 'Newfoundland and Labrador', 	'NS' => 'Nova Scotia', 
		'PE' => 'Prince Edward Island', 		'NB' => 'New Brunswick', 
		'QC' => 'Quebec', 						'MB' => 'Manitoba', 
		'SK' => 'Saskatchewan', 				'AB' => 'Alberta', 
		'NT' => 'Northwest Territories',		'NU' => 'Nunavut',
		'YT' => 'Yukon Territory');
	
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
	 * Returns a list of Canadian territories
	 *
	 * @return array
	 */
	public function getTerritories() {
		return self::$_territories;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}