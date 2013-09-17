<?php //--> 

/**
 * Google Latitude support
 *
 * @package    Eden
 * @category   google
 * @author     Matthew Baggett matthew@baggett.me
 */ 
class Eden_Google_Latitude extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
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
		$this->_google_api_key = $api_key;
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Google latitude direction
	 *
	 * @return Eden_Google_Latitude_Direction
	 */
	public function history() {
			
		return Eden_Google_Latitude_History::i($this->_google_api_key, $this->_token);
	}
	
	
}