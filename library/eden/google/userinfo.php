<?php //--> 

/**
 * Google Userinfo support
 *
 * @package    Eden
 * @category   google
 * @author     Matthew Baggett matthew@baggett.me
 */ 
class Eden_Google_Userinfo extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_USERINFO = 'https://www.googleapis.com/oauth2/v1/userinfo';
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
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	public function me(){
		return $this->_getResponse(self::URL_USERINFO, $this->_query);
		
	}
	
}