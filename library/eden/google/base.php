<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google oauth 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACCESS_TOKEN	= 'access_token';
	const KEY			= 'key'; 
	const MAX_RESULTS	= 'maxResults';
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	const CONTENT_TYPE	= 'Content-Type: application/json';
	
	const KIND			= 'kind';
	const ID			= 'id';					
	const OCR			= 'ocr';
	const SELF_LINK		= 'selfLink';
	const CHILD_LINK	= 'childLink';
	const CONVERT		= 'convert';		
	const PINNED		= 'pinned';				
	const TITLE			= 'title';
	const IS_ROOT		= 'isRoot';
	const ETAG			= 'etag';		
	const NAME			= 'name';		
	const ROLE			= 'role';		
	const TYPE 			= 'type';		
	
	const NEW_REVISION		= 'newRevision';					
	const OCR_LANGUAGE		= 'ocrLanguage';			
	const TEXT_LANGUAGE		= 'timedTextLanguage';	
	const TEXT_TRACKNAME 	= 'timedTextTrackName';	
	const DESCRIPTION		= 'description';			
	const LAST_VIEW			= 'lastViewedByMeDate';	
	const MIME_TYPE			= 'mimeType';				
	const MODIFIED_DATE		= 'modifiedDate';		
	const AUTH_KEY			= 'authKey';	
	const WITH_LINK			= 'withLink';	
	const PHOTO_LINK		= 'photoLink';
	const VALUE				= 'value';				
	const FILESIZE			= 'fileSize';
	const SCOPE				= 'scope';
	const CALENDAR_ID		= 'calendarId';
	const SUMMARY			= 'summary';
	const LOCATION			= 'location';
	const TIMEZONE			= 'timezone';
	const START				= 'start';
	const END				= 'end';
	const DESTINATION		= 'destination';
	const STATUS			= 'status';
	const ATTENDEES			= 'attendees';
	const COLOR_ID			= 'colorId';
	const CREATOR			= 'creator';
	const ORGANIZER			= 'organizer';
	const REMINDERS			= 'reminders';
	const UID				= 'iCalUID';
	const TEXT				= 'text';
	const TIMEMIN			= 'timeMin';
	const TIMEMAX			= 'timeMax';
	const ITEMS				= 'items';
	const ACCESS_ROLE		= 'accessRole';
	const HIDDEN			= 'hidden';
	const SELECTED			= 'selected';
	const LAST_MODIFY		= 'lastModifyingUserName';	
	const PUBLISHED 		= 'published';		
	
	const SOURCE_LANGUAGE		= 'sourceLanguage';	
	const TARGET_LANGUAGE		= 'targetLanguage';
	const GROUP_EXPANSION		= 'groupExpansionMax';
	const CALENDAR_EXPANSION	= 'calendarExpansionMax';		
	const ORIGINAL_FILENAME		= 'originalFilename';	
	const OUTSIDE_DOMAIN		= 'publishedOutsideDomain';	
	const DEFAULT_REMINDERS		= 'defaultRemiders';	
	const SUMMARY_OVERRIDE		= 'summaryOverride';			
	const PUBLISHED_LINK		= 'publishedLink';				
	const PUBLISHED_AUTO		= 'publishAuto';				
	const DOWNLOAD_URL			= 'downloadUrl';				
	const EXPORT_LINK			= 'exportLinks';				
	const MD5_CHECKSUM			= 'md5Checksum';	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token		= NULL;
	protected $_maxResult	= NULL;
	protected $_headers		= array(self::FORM_HEADER, self::CONTENT_TYPE);
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Set Maximum results of query
	 *
	 * @param int
	 * @return array
	 */
	public function setMaxResult($maxResult) {
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_maxResult = $maxResult;
		
		return $this;
	}
	
	/**
	 * Check if the response is xml
	 *
	 * @param string
	 * @return array
	 */
	public function isXml($xml) {
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML( $xml );
		$errors = libxml_get_errors();
	
		return empty( $errors );
	}
	
	public function setXmlHeaders($developerId) {
		//form xml header
		$headers = array(
			'application/x-www-form-urlencoded',
			'Content-Type: application/atom+xml',
			'X-GData-Key: key='.$developerId);
		
		return $headers;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			
			if($val == NULL || empty($val)) {
				unset($array[$key]);
			}
		}
		
		return $array;
	}
		
	protected function _getResponse($url, array $query = array()) {
		//if needed, add access token to query
		$query[self::ACCESS_TOKEN] = $this->_token;
		//if needed,  add api key to the query
		if(isset($this->_apiKey)) {
			$query[self::KEY] = $this->_apiKey;
			//prevent sending fields with no value
		}
		$query = $this->_accessKey($query);
		//build url query
		$url = $url.'?'.http_build_query($query);
		//set curl
		$response =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60)
			->getResponse();
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			$response =  simplexml_load_string($response);
		} else {
			//else it is in json format, covert it to array
			$response = json_decode($response, true);
		}
		
		return $response;
	}
	
	protected function _post($url, $query) {
		//add access token to query
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//check if query is in xml format
		if($this->isXml($query)) {
			//set different headers for xml
			$this->_headers = $this->setXmlHeaders($this->_developerId);
		//else it is in array	
		} else {
			//prevent sending fields with no value
			$query = $this->_accessKey($query);
			//json encode query
			$query = json_encode($query);
		}
		
		//set curl
		$response = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers)
			->getResponse();
		return $response;
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			$response =  simplexml_load_string($response);
		} else {
			//else it is in json format, covert it to array
			$response = json_decode($response, true);
		}
		
		return $response;
	}
	
	protected function _postXml($url, $query) {
		
		if($this->isXml($query)) {
		
		}
		echo $query; exit;
		//set headers
		$headers = $this->setXmlHeaders($this->_developerId);
		//add access token to query
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//json encode query
		//$query = json_encode($query);
		
		echo $query; exit;
		//set curl
		$response = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers)
			->getSimpleXmlResponse();
		
		return $response;
	}
	
	protected function _patch($url, array $query = array()) {
		//add access token to query
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//json encode query
		$query = json_encode($query);
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers)
			->setCustomRequest('PATCH');
		
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _delete($url) {		
		//add access token to the url
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setHeaders($this->_headers)
			->setCustomRequest('DELETE');
			
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		
		return $response;
	}
	
	protected function _put($url, array $query = array()) {
		//if query is an array
		if(is_array($query)) {
			//prevent sending fields with no value
			$query = $this->_accessKey($query); 
			//covent query to json format
			$query = json_encode($query);
		}
		//add access token to the url
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//Open a file resource using the php://memory stream
		$fh = fopen('php://memory', 'rw');
		// Write the data to the file
		fwrite($fh, $query);
		// Move back to the beginning of the file
		rewind($fh);
		//start curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setHeaders($this->_headers)
			->setPut(true)
			->setUrl($url)
			->setInFile($fh)
			->setInFileSize(strlen($query));
			
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}

	protected function _customPost($url, array $query = array()) {
		//add access token to query
		$query[self::ACCESS_TOKEN] = $this->_token;
		//if query is an array
		if(is_array($query)) {
			//prevent sending fields with no value
			$query = $this->_accessKey($query); 
			//covent query to string
			$query = http_build_query($query);
		}
		//combine url and query
		$url = $url.'?'.$query;
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers);
		
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}