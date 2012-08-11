<?php //-->
require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/timezone/validation.php';
require_once dirname(__FILE__).'/timezone/error.php';

/**
 * Timezone convert-o-matic
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Timezone extends Eden_Class {
	/* Constants
	-------------------------------*/
	const GMT = 'GMT';
	const UTC = 'UTC';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($zone, $time = NULL) {
		Eden_Timezone_Error::i()
			->argument(1, 'string')
			->argument(1, 'location', 'utc', 'abbr')
			->argument(2, 'int', 'string', 'null');
		
		if(is_null($time)) {
			$time = time();
		}
		
		$this->_offset 	= $this->_getOffset($zone);
		$this->setTime($time);
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Convert current time set here to another time zone
	 *
	 * @param string valid UTC, GMT, PHP Location or TZ Abbreviation
	 * @param string|null
	 * @return string|int
	 */
	public function convertTo($zone, $format = NULL) {
		Eden_Timezone_Error::i()
			->argument(1, 'string')
			->argument(1, 'location', 'utc', 'abbr')
			->argument(2, 'string', 'null');
		
		$time = $this->_time + $this->_getOffset($zone);
		
		if(!is_null($format)) {
			return date($format, $time);
		}
		
		return $time;
	}
	
	/**
	 * Returns the GMT Format
	 *
	 * @return string
	 */
	public function getGMT($prefix = self::GMT) {
		Eden_Timezone_Error::i()->argument(1, 'string');
		list($hour, $minute, $sign) = $this->_getUtcParts($this->_offset);
		return $prefix.$sign.$hour.$minute;
	}
	
	/**
	 * Returns a list of GMT formats and dates in a 24 hour period
	 *
	 * @param string
	 * @param int
	 * @param string|null
	 * @return array
	 */
	public function getGMTDates($format, $interval = 30, $prefix = self::GMT) {
		Eden_Timezone_Error::i()
			->argument(1, 'string')
			->argument(2, 'int')
			->argument(3, 'string', 'null');
			
		$offsets 	= $this->getOffsetDates($format, $interval);
		$dates 		= array();
		
		foreach($offsets as $offset => $date) {
			list($hour, $minute, $sign) = $this->_getUtcParts($offset);
			$gmt = $prefix.$sign.$hour.$minute;
			$dates[$gmt] = $date;
		}
		
		return $dates;
	}
	
	/**
	 * Returns the current offset of this timezone
	 *
	 * @return int
	 */
	public function getOffset() {
		return $this->_offset;
	}
	
	/**
	 * Returns a list of offsets and dates in a 24 hour period
	 *
	 * @param string
	 * @param int
	 * @return array
	 */
	public function getOffsetDates($format, $interval = 30) {
		Eden_Timezone_Error::i()
			->argument(1, 'string')
			->argument(2, 'int');
			
		$dates = array();
		$interval *= 60;
		
		for($i=-12*3600; $i <= (12*3600); $i+=$interval) {
			$time = $this->_time + $i;
			$dates[$i] = date($format, $time);
		}
		
		return $dates;
	}
	
	/**
	 * Returns the time or date
	 *
	 * @return string|null
	 */
	public function getTime($format = NULL) {
		Eden_Timezone_Error::i()->argument(1, 'string', 'null');
		
		$time = $this->_time + $this->_offset;
		
		if(!is_null($format)) {
			return date($format, $time);
		}
		
		return $time;
	}
	
	/**
	 * Returns the UTC Format
	 *
	 * @return string
	 */
	public function getUTC($prefix = self::UTC) {
		Eden_Timezone_Error::i()->argument(1, 'string');
		list($hour, $minute, $sign) = $this->_getUtcParts($this->_offset);
		return $prefix.$sign.$hour.':'.$minute;
	}
	
	/**
	 * Returns a list of UTC formats and dates in a 24 hour period
	 *
	 * @param string
	 * @param int
	 * @param string|null
	 * @return array
	 */
	public function getUTCDates($format, $interval = 30, $prefix = self::UTC) {
		Eden_Timezone_Error::i()
			->argument(1, 'string')
			->argument(2, 'int')
			->argument(3, 'string', 'null');
			
		$offsets 	= $this->getOffsetDates($format, $interval);
		$dates 		= array();
		
		foreach($offsets as $offset => $date) {
			list($hour, $minute, $sign) = $this->_getUtcParts($offset);
			$utc = $prefix.$sign.$hour.':'.$minute;
			$dates[$utc] = $date;
		}
		
		return $dates;
	}
	
	/**
	 * Sets a new time
	 *
	 * @param int|string
	 * @return this
	 */
	public function setTime($time) {
		Eden_Timezone_Error::i()->argument(1, 'int', 'string');
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_time = $time - $this->_offset;
		return $this;
	}
	
	/**
	 * Returns timezone's validation methods
	 *
	 * @return Eden_Timezone_Validation
	 */
	public function validation() {
		return Eden_Timezone_Validation::i();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getOffset($zone) {
		if($this->validation()->isLocation($zone)) {
			return $this->_getOffsetFromLocation($zone);
		}
		
		if($this->validation()->isUtc($zone)) {
			return $this->_getOffsetFromUtc($zone);
		}
		
		if($this->validation()->isAbbr($zone)) {
			return $this->_getOffsetFromAbbr($zone);
		}
		
		return 0;
	}
	
	protected function _getOffsetFromAbbr($zone) {
		$zone = timezone_name_from_abbr(strtolower($zone));
		return $this->_getOffsetFromLocation($zone);
	}
	
	protected function _getOffsetFromLocation($zone) {
		$zone = new DateTimeZone($zone);
		$gmt = new DateTimeZone(self::GMT);
		
		return $zone->getOffset(new DateTime('now', $gmt));
	}
	
	protected function _getOffsetFromUtc($zone) {
		$zone 	= str_replace(array('GMT','UTC'), '', $zone);
		$zone 	= str_replace(':', '', $zone);
		
		$add 	= $zone[0] == '+';
		$zone 	= substr($zone, 1);
		
		switch(strlen($zone)) {
			case 1:
			case 2:
				return $zone * 3600 * ($add?1:-1);
			case 3:
				$hour 	= substr($zone, 0, 1) * 3600;
				$minute = substr($zone, 1) * 60;
				return ($hour+$minute) * ($add?1:-1);
			case 4:
				$hour 	= substr($zone, 0, 2) * 3600;
				$minute = substr($zone, 2) * 60;
				return ($hour+$minute) * ($add?1:-1);
				
		}
		
		return 0;
	}
	
	/* Private Methods
	-------------------------------*/
	private function _getUtcParts($offset) {
		$minute = '0'.(floor(abs($offset/60)) % 60);
		
		return array(
			floor(abs($offset/3600)), 
			substr($minute, strlen($minute)-2),
			$offset < 0 ? '-':'+');
	}
}