<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk Attachments 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Attachments extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const TICKETS_UPLOAD_FILES	= 'https://%s.zendesk.com/api/v2/uploads.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Upload a file
	 *
	 * @param string The relative path on the server of the file to upload.
	 * @param string The mime type of the file
	 * @return array
	 */
	public function uploadFiles($file, $type) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['filename'] = $file;
		
		return $this->_upload(sprintf(self::TICKETS_UPLOAD_FILES, $this->_subdomain), $this->_query, $type);
	}
	
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}