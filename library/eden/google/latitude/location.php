<?php //--> 

/**
 * Google Latitude Location Class
 *
 * @package    Eden
 * @category   google
 * @author     Matthew Baggett matthew@baggett.me
 */
class Eden_Google_Latitude_Location {
	protected $timestampMs;
	protected $latitude;
	protected $longitude;
	
	public function setTimestampMs($timestampMs)	{ $this->timestampMs 	= $timestampMs; return $this;	}
	public function setLatitude($latitude)			{ $this->latitude 		= $latitude; 	return $this;	}
	public function setLongitude($longitude)		{ $this->longitude 		= $longitude; 	return $this;	}
	
	public function getTimestampMs()				{ return $this->timestampMs/1000;			 			}
	public function getTimestamp()					{ return strtotime($this->timestampMs/1000); 			}
	public function getLatitude()					{ return $this->latitude; 								}
	public function getLongitude()					{ return $this->longitude; 								}
	
	static function createFromData($data){
		$newLocation = new Eden_Google_Latitude_Location();
		$newLocation->setTimestampMs($data['timestampMs']);
		$newLocation->setLatitude($data['latitude']);
		$newLocation->setLongitude($data['longitude']);
		return $newLocation;
	}
}