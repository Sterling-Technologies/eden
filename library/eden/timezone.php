<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 * General available methods for common time zone procedures.
 *
 * @package    Eden
 * @subpackage timezone
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: timezone.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Timezone extends Eden_Class {
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
	 * Returns a list of timezones
	 *
	 * @param string key 
	 * @return array
	 */
	public function getTimeZones($key = NULL) {
		//Argument 1 must be a string or null
		Eden_Timezone_Error::i()->argument(1, 'string', 'null');
		
		$zones = array();
		$zonesProcessed = array();
		for($i = -43200; $i < 52200; $i += 3600) {
			$zoneStandard = timezone_name_from_abbr(NULL, $i, 0);
			$zoneDaylightSavings = timezone_name_from_abbr(NULL, $i, 1);
			
			$name = $zoneDaylightSavings ? $zoneDaylightSavings : $zoneStandard;
			
			if($name && !in_array($name, $zonesProcessed)) {
				$date = new DateTime( 'now', new DateTimeZone($name) );
				$alias = explode('/', $name);
				$alias = str_replace('_', ' ', $alias[1]);
				$zone = array(
					'name' => $name, 
					'offset' => $i, 
					'abbr' => $date->format('T'), 
					'alias' => $alias, 
					//PHP BUG: $date->format('U') returns the system unix time
					'time' => $date->format('Y m d g i s'));
				if(isset($zone[$key])) {
					$zones[$zone[$key]] = $zone;
				} else {
					$zones[] = $zone;
				}
				
				$zonesProcessed[] = $name;
			}
		}
		
		return $zones;
	}
	
	/**
	 * Returns the current system unix time in another zone
	 *
	 * @param *string zoneName
	 * @param int systemTime
	 * @return int
	 */
	public function getTimeInZone($zoneName, $systemTime = NULL) {
		//argument testing
		Eden_Timezone_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string
			->argument(2, 'int', 'null');	//Argument 2 must be a string or null
			
		$systemTime = $systemTime ? $systemTime : time();
		
		$systemOffset = date('Z');
		$zoneOffset = new DateTime("now", new DateTimeZone($zoneName));
		$zoneOffset = $zoneOffset->getOffset();
		return ($systemOffset * -1) + $zoneOffset + $systemTime;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Timezone Errors
 */
class Eden_Timezone_Error extends Eden_Error {
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
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Magic
	-------------------------------*/
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}