<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Youtube Upload 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Upload extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_UPLOAD = 'http://uploads.gdata.youtube.com/action/GetUploadToken';
	
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
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token 		= $token;
		$this->_developerId = $developerId; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Get upload token
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getUploadToken($title, $description, $category, $keyword, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string');	//argument 4 must be a string
			
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $title)
			->set(self::DESCRIPTION, $description)
			->set(self::CATEGORY, $category)
			->set(self::KEYWORD, $keyword)
			->parsePHP(dirname(__FILE__).'/template/upload.php');
		
		return $this->_upload(sprintf(self::URL_YOUTUBE_UPLOAD, $userId), $query);
	}
	
	/**
	 * Upload video to youtube
	 *
	 * @return form
	 */
	public function upload($uploadToken, $postUrl, $redirectUrl) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'object', 'string')		//argument 1 must be a object or string
			->argument(2, 'object', 'string')		//argument 2 must be a object or string
			->argument(3, 'string');				//argument 3 must be a string
			
		//make a xml template
		$query = Eden_Template::i()
			->set(self::UPLOAD_TOKEN, $uploadToken)
			->set(self::REDIRECT_URL, $redirectUrl)
			->set(self::POST_URL, $postUrl)
			->parsePHP(dirname(__FILE__).'/template/form.php');
		
		return $query;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}