<?php //--> 

/**
 * Google Latitude History Class
 *
 * @package    Eden
 * @category   google
 * @author     Matthew Baggett matthew@baggett.me
 */
class Eden_Google_Latitude_History extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_LATITUDE_HISTORY = 'https://www.googleapis.com/latitude/v1/location';
	
	const GRANULARITY = 'granularity';
	const MINTIME = 'min-time';
	const MAXTIME = 'max-time';
	const MAXRESULTS = 'max-results';
	const QUOTAUSER = 'quotaUser';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_google_api_key;
	
	/* Private Properties
	-------------------------------*/
	
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($api_key, $token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		Eden_Google_Error::i()->argument(2, 'string');
		$this->_google_api_key 	= $api_key;
		$this->_token = $token;
	}
	
	/* Public Methods
	-------------------------------*/
	
	public function setGranularity($granularity){
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::GRANULARITY] = $granularity;
	}
	
	public function setMinTime($min_time){
		Eden_Google_Error::i()->argument(1, 'float');
		$this->_query[self::MINTIME] = $min_time;
	}
	
	public function setMaxTime($max_time){
		Eden_Google_Error::i()->argument(1, 'float');
		$this->_query[self::MAXTIME] = $max_time;
	}
	
	public function setMaxResults($max_results){
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_query[self::MAXRESULTS] = $max_results;
	}
	
	public function setQuotaUser($uid){
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_query[self::QUOTAUSER] = $uid;
	}

	public function fetch(){
		$response = $this->_getResponse(self::URL_LATITUDE_HISTORY, $this->_query);
		
		if(isset($response['error'])){		
			throw new Eden_Google_Error($response['error']['errors'][0]['message']); 
		}
		
		if(isset($response['data']['items'])){
			foreach($response['data']['items'] as $location){
				$locations[] = Eden_Google_Latitude_Location::createFromData($location);
			}
			return $locations;
		}else{
			return array();
		}
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}