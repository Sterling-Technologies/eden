<?php //-->
require_once dirname(__FILE__).'/../../library/eden.php';

eden();

class Eden_Timezone extends Eden_Class {
	
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function getOffset($source, $destination) {
		//source and destination will be in abbr format
		//we need to figure out the full text format
		$source = timezone_name_from_abbr($source);				//should now be Europe/Berlin for example
		$destination = timezone_name_from_abbr($destination);	//should now be Europe/Berlin for example

		//now lets put that into DateTimeZone to get the offset
		$source = new DateTimeZone($source);
		$destination = new DateTimeZone($destination);
		$gmt = new DateTimeZone('UTC');
		
		//get GMT now
		$gmt = new DateTime('now', $gmt);
		
		//get offset for each
		$source = $source->getOffset($gmt);
		$destination = $destination->getOffset($gmt);
		
		//calculate difference
		return $destination - $source;
	}
	
	public function convertTime($time, $source ,$destination) {
		//fugureout whats the diff of tw0 timezone
		//add or subtract the time according from diff
		return $time + $this->getOffset($source, $destination);
	}
	
}

echo date('F d, Y g:iA', Eden_Timezone::get()->convertTime(time(), 'HKT', 'PDT'));





//echo eden()->User('Chris')->getName();
