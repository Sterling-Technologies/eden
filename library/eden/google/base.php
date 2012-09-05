<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google base 
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
	const RESPONSE		= 'alt';
	const JSON_FORMAT	= 'json';
	const VERSION		= 'v';
	const QUERY			= 'q';
	const QUERY_STRING	= 'query';
	
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
	const KEYWORD				= 'keyword';
	const CATEGORY				= 'category';
	const POST_URL				= 'postUrl';
	const UPLOAD_TOKEN			= 'uploadToken';
	const REDIRECT_URL			= 'redirectUrl';
	const USER					= 'user';
	const CHANNEL				= 'channel';
	const START_INDEX			= 'start-index';
	const ORDER_BY				= 'orderby';
	const LIKE					= 'like';
	const DISLIKE				= 'dislike';
	const RATINGS				= 'ratings';
	const USER_NAME				= 'userName';
	const VIDEO_ID				= 'videoId';
	const POSITION				= 'position';
	const COMMENT				= 'comment';
	const COMMENT_ID			= 'commentId';
	const TIME					= 'time';
	const COLLECTION			= 'collection';
	const USER_ID				= 'userId';
	const PAGE_TOKEN			= 'pageToken';
	const ORDER					= 'orderBy';
	const SORT					= 'sortOrder';
	const ACITIVITY_ID			= 'activityId';
	const INFO					= 'info';
	const GIVEN_NAME			= 'givenName';
	const FAMILY_NAME			= 'familyName';
	const STREET				= 'street';
	const PHONE_NUMBER			= 'phoneNumber';
	const CITY					= 'city';
	const POST_CODE				= 'postCode';
	const COUNTRY				= 'country';
	const NOTES					= 'notes';
	const EMAIL					= 'email';
	const PRIMARY				= 'primary';
	const DEFAULT_VALUE			= 'default';
	const VERSION_THREE			= '3.0';
	const VERSION_TWO			= '2';
	const ME					= 'me';
	const PUBLIC_DATA			= 'public';
	const ALL					= '~all';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token		= NULL;
	protected $_maxResult	= NULL;
	protected $_headers		= array(self::FORM_HEADER, self::CONTENT_TYPE);
	protected $_meta		= array();
	protected $_developerId	= NULL;
	protected $_etag		= NULL;
	protected $_apiKey		= NULL;
	protected $_query		= array();
	
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
	public function getMeta() {
	
		return $this->_meta;
	}
	
	/**
	 * Check if the response is xml
	 *
	 * @param string|array|object|null
	 * @return bollean
	 */
	public function isXml($xml) {
		//argument 1 must be a string, array,  object or null
		Eden_Google_Error::i()->argument(1, 'string', 'array', 'object', 'null');
		
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		//front()->output($errors); exit;
		return empty($errors);
	}
	
	/**
	 * Check if the response is json format
	 *
	 * @param string
	 * @return boolean
	 */
	public function isJson($string) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	/**
	 * Set xml headers 
	 *
	 * @param string
	 * @param boolean 
	 * @return array
	 */
	public function setXmlHeaders($developerId, $etag = false) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')	//argument 1 must be a string or null
			->argument(2, 'bool');			//argument 2 must be a boolean
		
		//if developer id is not needed in header
		if(is_null($developerId)) {
			//form xml header with no header
			$headers = array(
				'application/x-www-form-urlencoded',
				'Content-Type: application/atom+xml');
		} 
		//if developer id is needed
		if(!is_null($developerId) && !$etag){
			//form xml header with developer id
			$headers = array(
				'application/x-www-form-urlencoded',
				'Content-Type: application/atom+xml',
				'X-GData-Key: key='.$developerId,
				'GData-Version: 2');
		}	
		
		//if etag is needed in the headers
		if(is_null($developerId) && $etag){
			//form xml header
			$headers = array(
				'application/x-www-form-urlencoded',
				'Content-Type: application/atom+xml',
				'If-Match: *');
		}
		
		return $headers;
	}
	
	/**
	 * Well format xml  
	 *
	 * @param string|object
	 * @return xml
	 */
	public function formatToXml($query) {
		//argument 1 must be a string or object
		Eden_Google_Error::i()->argument(1, 'string', 'object');
		
		$xml = new DOMDocument(); 
		$xml->preserveWhiteSpace = false; 
		$xml->formatOutput = true; 
		$xml->loadXML($query); 
		
		return $xml->saveXML();
	}
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		
		foreach($array as $key => $val) {
			// if value is array
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			//if value in null
			if($val == NULL || empty($val)) {
				//remove it from query
				unset($array[$key]);
			}
		}
		return $array;
	}
	
	protected function _reset() {
		//foreach this as key => value
		foreach ($this as $key => $value) {
			//if the value of key is not array
			if(!is_array($this->$key)) {
				//if key name starts at underscore, probably it is protected variable
				if(preg_match('/^_/', $key)) {
					//if the protected variable is not equal to token
					//we dont want to unset the access token
					if($key != '_token') {
						//reset all protected variables that currently use
						$this->$key = NULL;
					}
				}
			} 
        } 
		
		return $this;
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
		
		//reset protected variables
		unset($this->_query); 
		
		return $response;
	}
	
	protected function _delete($url, array $query = array(), $etag = false) {
		//if etag or developer id is needed in header
		if($etag || !is_null($this->_developerId)) {
			//set different headers for xml
			$this->_headers = $this->setXmlHeaders($this->_developerId, $etag);
			//add access token and version to the url
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token.'&v=3';
		//else it just needed regular headers
		} else {
			//add access token to the url
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		} 
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setHeaders($this->_headers)
			->setCustomRequest('DELETE');
			
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		
		//reset protected variables
		unset($this->_query); 
		
		//check if response is in json format
		if($this->isJson($response)) {
			//else it is in json format, covert it to array
			$response = json_decode($response, true);
		}
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			$response =  simplexml_load_string($response);
		}
		
		return $response;
	}
		
	protected function _getResponse($url, array $query = array()) {
		//if needed, add access token to query
		$query[self::ACCESS_TOKEN] = $this->_token;
		//if needed, add developer id to the query
		if(!is_null($this->_developerId)) {
			$query[self::KEY] = $this->_developerId;
		}
		//if needed, add api key to the query
		if(!is_null($this->_apiKey)) {
			$query[self::KEY] = $this->_apiKey;
		}
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//build url query
		$url = $url.'?'.http_build_query($query);
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
		//get response from curl
		$response = $curl->getResponse();
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		//reset protected variables
		unset($this->_query); 
		
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			return $response =  simplexml_load_string($response);
		}
		
		//check if response is in json format
		if($this->isJson($response)) { 
			//else it is in json format, convert it to array
			return $response = json_decode($response, true);
		}

		//check if response is in base64 format
		if(base64_decode($response, true)) {
			//if not base64 format, return normal response
			return $response;
		//else it is in base64 format
		} else { 
			//return an image
			return '<img src="data:image/jpeg;base64,'.base64_encode($response).'" />';
		}
		
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
		
		//reset protected variables
		unset($this->_query); 
		
		return $response;
	}
	
	protected function _post($url, $query, $etag = false) {
		//if query is in array
		if(is_array($query)) {
			//prevent sending fields with no value
			$query = $this->_accessKey($query);
			//json encode query
			$query = json_encode($query);
			//add access token to query
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		}
		//if query is in xml format
		if($this->isXml($query)) { 
			//set different headers for xml
			$this->_headers = $this->setXmlHeaders($this->_developerId, $etag);
			//well format the xml
			$query = $this->formatToXml($query);
			//add access token to query and convert response ti json format
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token.'&alt=json';
		} 
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers);
		//get response form curl
		$response = $curl->getResponse();		
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		//reset protected variables
		unset($this->_query); 
		
		//check if response is in json format
		if($this->isJson($response)) {
			//else it is in json format, covert it to array
			return $response = json_decode($response, true);
		}
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			return $response =  simplexml_load_string($response);
		} 
		//if it is a normal response
		return $response;
	}
	
	protected function _put($url, $query, $etag = false) {
		//if query is an array
		if(is_array($query)) {
			//prevent sending fields with no value
			$query = $this->_accessKey($query); 
			//covent query to json format
			$query = json_encode($query);
			//add access token to the url
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		}
		//if query is an xml
		if($this->isXml($query)) { 
			//set different headers for xml
			$this->_headers = $this->setXmlHeaders($this->_developerId, $etag);
			//well format the xml
			$query = $this->formatToXml($query);
			//add access token to the url
			$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		}
		//if query is in string
		if(is_string($query)) {
			//get the raw data using file get content
			$query = file_get_contents($query);
			//use different headers
			$headers	= array();
			$headers[] 	= 'Content-Length: '.strlen($query);
			$headers[] 	= 'Content-Transfer-Encoding: base64';
			$this->_headers = $headers;
			//add access token to the url
			$url = $url.'&'.self::ACCESS_TOKEN.'='.$this->_token;
		}
		
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
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		
		//reset protected variables
		unset($this->_query); 
		
		//check if response is in json format
		if($this->isJson($response)) {
			//else it is in json format, covert it to array
			return $response = json_decode($response, true);
		}
		//check if response is in xml format
		if($this->isXml($response)) {
			//if it is xml, convert it to array
			return $response =  simplexml_load_string($response);
		} 

		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}