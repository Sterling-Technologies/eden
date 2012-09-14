<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon S3
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Amazon_S3 extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACL_PRIVATE 				= 'private';
	const ACL_PUBLIC_READ 			= 'public-read';
	const ACL_PUBLIC_READ_WRITE 	= 'public-read-write';
	const ACL_AUTHENTICATED_READ 	= 'authenticated-read';
	const GET		= 'GET';
	const PUT		= 'PUT';
	const DELETE	= 'DELETE';
	const HEAD		= 'HEAD';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta			= array();
	protected $_host			= 's3.amazonaws.com';
	protected $_accessKey		= NULL;
	protected $_accessSecret	= NULL;
	protected $_response		= NULL;
	protected $_ssl 			= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key, $secret, $host = 's3.amazonaws.com', $ssl = true) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string')		//Argument 2 must be string 
			->argument(3, 'string')		//Argument 3 must be string 
			->argument(4, 'bool');		//Argument 4 must be bool
			
		$this->_host 			= $host;
		$this->_accessKey 		= $key;
		$this->_accessSecret 	= $secret;
		$this->_ssl 			= $ssl;
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Put a bucket
	 *
	 * @param string Bucket name
	 * @param string Set as "EU" to create buckets hosted in Europe
	 * @return boolean
	 */
	public function addBucket($bucket, $location = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')	//Argument 1 must be string
			->argument(2, 'bool');	//Argument 2 must be bool
			
		$data		= NULL;
		$headers 	= array();
		$amazon 	= array('x-amz-acl' => self::ACL_PRIVAT);
		
		//create xml file
		if($location !== false) { 
			$dom 		= new DOMDocument;
			$config 	= $dom->createElement('CreateBucketConfiguration');
			$constraint = $dom->createElement('LocationConstraint', strtoupper($location));
			
			$config->appendChild($constraint);
			$dom->appendChild($config);
			$data = $dom->saveXML();
			
			$headers['Content-Type'] = 'application/xml';
		}
		
		return $this->_setResponse(self::PUT, $bucket, '/', array(), $data, $headers, $amazon);
	}
	
	/**
	 * Put an object
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @param string 
	 * @param string 
	 * @param array 
	 * @return array
	 */
	public function addFile($bucket, $path, $data, $permission = self::ACL_PRIVATE, $metaData = array()) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string')		//Argument 2 must be string
			->argument(3, 'string')		//Argument 3 must be string
			->argument(4, 'string')		//Argument 4 must be string
			->argument(5, 'array');		//Argument 5 must be array
			
		$headers = $amazon = array();
		$amazon['x-amz-acl'] = $permission;
		
		
		foreach($metaData as $key => $value) {
        	$headers[$key] = $value;
    	}
		
		if(strpos($path, '/') !== 0) {
			$path = '/'.$path;
		}
		
		return $this->_setResponse(self::PUT, $bucket, $path, array(), $data, $headers, $amazon);
	}
	
	/**
	 * Delete an empty bucket
	 *
	 * @param string Bucket name
	 * @return array
	 */
	public function deleteBucket($bucket) {
		//Argument 1 must be string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		return $this->_setResponse(self::DELETE, $bucket);
	}
	
	/**
	 * Delete an object
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @return array
	 */
	public function deleteFile($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		return $this->_setResponse(self::DELETE, $bucket, $path);
	}
	
	/**
	 * Delete an object
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @return boolean
	 */
	public function deleteFolder($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		//get all bucket
		$list = $this->getBucket($bucket);
		
		if(strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}
		
		if(substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
		
		
		$files = array();
		foreach($list as $object) {
			//if the oject does not start with the path
			if(strpos($object['name'], $path) !== 0) {
				//skip it
				continue;
			}
			//delete files
			$this->deleteFile($bucket, '/'.$object['name']);
		}
		
		return $this->_response;
	}
	
	/**
	 * Get contents for a bucket. If maxKeys is NULL this method will 
	 * loop through truncated result sets
	 *
	 * @param string Bucket name
	 * @param string Prefix
	 * @param string Marker (last file listed)
	 * @param string Max keys (maximum number of keys to return)
	 * @param string Delimiter
	 * @return array
	 */
	public function getBucket($name, $prefix = NULL, $marker = NULL, $maxKeys = NULL, $delimiter = NULL) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//Argument 1 must be string
			->argument(2, 'string', 'null')		//Argument 2 must be string or null
			->argument(3, 'string', 'null')		//Argument 3 must be string or null
			->argument(4, 'string', 'null')		//Argument 4 must be string or null
			->argument(5, 'string', 'null');	//Argument 5 must be string or null
			
		$bucket = array();
		
		do {
			$query = array();
			if($prefix) {
				$query['prefix'] = $prefix;
			}
			
			if($marker) {
				$query['marker'] = $marker;
			}
			
			if($maxKeys) {
				$query['max-keys'] = $maxKeys;
			}
			
			if($delimiter) {
				$query['delimiter'] = $delimiter;
			}
			
			$this->_setResponse('GET', $name, '/', $query);
			
			if($this->_meta['info'] != 200) { 
				return $this->_response;
			}
			
			
			$nextMarker = NULL;
			foreach ($this->_response->Contents as $content) {
				$bucket[(string)$content->Key] = array(
					'name' => (string)$content->Key,
					'time' => strtotime((string)$content->LastModified),
					'size' => (string)$content->Size,
					'hash' => substr((string)$content->ETag, 1, -1)
				);
				
				$nextMarker = (string)$content->Key;
			}
			
			foreach ($this->_response->CommonPrefixes as $prefix) {
				$bucket['prefixes'][] = (string)$prefixes->Prefix;
			}
			
			if(isset($this->_response->IsTruncated) && $this->_response->IsTruncated == 'false') {
				break;
			}
			
			if (isset($this->_response->NextMarker)) {
				$nextMarker = (string)$this->_response->NextMarker;
			}
		} while(!$maxKeys && $nextMarker);
		
		
		return $bucket;
	}
	
	/**
	 * Get a list of buckets
	 *
	 * @return array
	 */
	public function getBuckets() {
		
		return $this->_setResponse(self::GET);
	}
	
	/**
	 * Get an object
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @param mixed $saveTo Filename or resource to write to
	 * @return array
	 */
	public function getFile($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
			
		return $this->_setResponse(self::GET, $bucket, $path);
	}
	
	/**
	 * Get object information
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @return array
	 */
	public function getFileInfo($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		if(strpos($path, '/') !== 0) {
			$path = '/'.$path;
		}
		
		return $this->_setResponse(self::HEAD, $bucket, $path);
	}
	
	/**
	 * Get files for a bucket given a path
	 *
	 * If maxKeys is NULL this method will loop through truncated result sets
	 *
	 * @param string Bucket name
	 * @param string Prefix
	 * @param string Marker (last file listed)
	 * @param string Max keys (maximum number of keys to return)
	 * @param string Delimiter
	 * @param boolean Set to true to return CommonPrefixes
	 * @return array 
	 */
	public function getFiles($bucket, $path = NULL, $prefix = NULL, $marker = NULL, $maxKeys = NULL, $delimiter = NULL) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//Argument 1 must be string
			->argument(2, 'string', 'null')		//Argument 2 must be string or null
			->argument(3, 'string', 'null')		//Argument 3 must be string or null
			->argument(4, 'string', 'null')		//Argument 4 must be string or null
			->argument(5, 'string', 'null')		//Argument 5 must be string or null
			->argument(6, 'string', 'null');	//Argument 6 must be string or null
			
		$bucket = $this->getBucket($bucket, $prefix, $marker, $maxKeys, $delimiter);
		
		if(strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}
		
		if(substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
		
		$files = array();
		foreach($bucket as $object) {
			$name = $object['name'];
			if($path) {
				//if the oject does not start with the path
				if(strpos($name, $path.'/') !== 0) {
					//skip it
					continue;
				}
				
				//remove the path
				$name = substr($name, strlen($path.'/'));
			}
			
			//if the oject has a / or
			//if this is an s3fox folder
			if(strpos($name, '/') !== false || strpos($name, '_$folder$') !== false) {
				//skip it
				continue;
			}
			
			$files[$name] = true;
		}
		
		return array_keys($files);
	}
	
	/**
	 * Get folders given a path
	 *
	 * If maxKeys is NULL this method will loop through truncated result sets
	 *
	 * @param string Bucket name
	 * @param string path
	 * @param string Prefix
	 * @param string Marker (last file listed)
	 * @param string Max keys (maximum number of keys to return)
	 * @param string Delimiter
	 * @param boolean Set to true to return CommonPrefixes
	 * @return array 
	 */
	public function getFolders($bucket, $path = NULL, $prefix = NULL, $marker = NULL, $maxKeys = NULL, $delimiter = NULL) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//Argument 1 must be string
			->argument(2, 'string', 'null')		//Argument 2 must be string or null
			->argument(3, 'string', 'null')		//Argument 3 must be string or null
			->argument(4, 'string', 'null')		//Argument 4 must be string or null
			->argument(5, 'string', 'null')		//Argument 5 must be string or null
			->argument(6, 'string', 'null');	//Argument 6 must be string or null
			
		$bucket = $this->getBucket($bucket, $prefix, $marker, $maxKeys, $delimiter);
		
		if(strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}
		
		if(substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
		
		$folders = array();
		foreach($bucket as $object) {
			$name = $object['name'];
			if($path) {
				//if the oject does not start with the path
				if(strpos($name, $path.'/') !== 0) {
					//skip it
					continue;
				}
				
				//remove the path
				$name = substr($name, strlen($path.'/'));
			}
			
			//we just care about the sub string before the /
			$paths = explode('/', $name);
			//if this is an s3fox folder
			if(strpos($paths[0], '_$folder$') !== false) {
				//remove the suffix
				$paths[0] = str_replace('_$folder$', '', $paths[0]);
			}
			
			$folders[$paths[0]] = true;
		}
		
		return array_keys($folders);
	}
	
	/**
	 * Gets the size of a folder
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @return boolean
	 */
	public function getFolderSize($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
			
		$bucket = $this->getBucket($bucket);
		
		if(strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}
		
		if(substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
		
		$size = 0;
		foreach($bucket as $object) {
			//if the oject does not start with the path
			if(strpos($object['name'], $path.'/') !== 0) {
				//skip it
				continue;
			}
			
			$size += $object['size'];
		}
		
		return $size;
	}
	
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Get object or bucket Access Control Policy
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @return array
	 */
	public function getPermissions($bucket, $path = '/') {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		$query['acl'] = NULL;
		$response = $this->_setResponse('GET', $bucket, $path);
		
		if($this->_meta['info'] != 200) { 
			return $response;
		}

		$permission = array();
		if (isset($this->_response->Owner, $this->_response->Owner->ID, $this->_response->Owner->DisplayName)) {
			$permission['owner'] = array(
				'id' 	=> $this->_response->Owner->ID, 
				'name' 	=> $this->_response->Owner->DisplayName);
		}
		
		if (isset($this->_response->AccessControlList)) {
			$acp['users'] = array();
			foreach ($this->_response->AccessControlList->Grant as $grant) {
				foreach ($grant->Grantee as $grantee) {
					if (isset($grantee->ID, $grantee->DisplayName)) { // CanonicalUser
					
						$permission['users'][] = array(
							'type' 			=> 'CanonicalUser',
							'id' 			=> $grantee->ID,
							'name' 			=> $grantee->DisplayName,
							'permission' 	=> $grant->Permission);
						
					} else if (isset($grantee->EmailAddress)) { // AmazonCustomerByEmail
					
						$permission['users'][] = array(
							'type' 			=> 'AmazonCustomerByEmail',
							'email' 		=> $grantee->EmailAddress,
							'permission' 	=> $grant->Permission);
						
					} else if (isset($grantee->URI)) { // Group
					
						$permission['users'][] = array(
							'type' 			=> 'Group',
							'uri' 			=> $grantee->URI,
							'permission' 	=> $grant->Permission);
						
					}
				}
			}
		}
		
		return $permission;
	}
	
	/**
	 * Set object or bucket Access Control Policy
	 *
	 * @param string Bucket name
	 * @param string Object URI
	 * @param array Access Control Policy Data (same as the data returned from getAccessControlPolicy)
	 * @return boolean
	 */
	public function setPermissions($bucket, $path = '/', array $acp = array()) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		$dom = new DOMDocument;
		$dom->formatOutput = true;
		$policy = $dom->createElement('AccessControlPolicy');
		$list = $dom->createElement('AccessControlList');

		// It seems the owner has to be passed along too
		$owner = $dom->createElement('Owner'); 
		$owner->appendChild($dom->createElement('ID', $acp['owner']['id'])); 
		$owner->appendChild($dom->createElement('DisplayName', $acp['owner']['name']));
		$policy->appendChild($owner);

		foreach ($acp['acl'] as $permission) {
			$grant 		= $dom->createElement('Grant');
			$grantee 	= $dom->createElement('Grantee');
			
			$grantee->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
			
			if (isset($permission['id'])) { // CanonicalUser (DisplayName is omitted)
				$grantee->setAttribute('xsi:type', 'CanonicalUser');
				$grantee->appendChild($dom->createElement('ID', $permission['id']));
			} elseif (isset($permission['email'])) { // AmazonCustomerByEmail
				$grantee->setAttribute('xsi:type', 'AmazonCustomerByEmail');
				$grantee->appendChild($dom->createElement('EmailAddress', $permission['email']));
			} elseif ($permission['type'] == 'Group') { // Group
				$grantee->setAttribute('xsi:type', 'Group');
				$grantee->appendChild($dom->createElement('URI', $permission['uri']));
			}
			
			$grant->appendChild($grantee);
			$grant->appendChild($dom->createElement('Permission', $permission['permission']));
			$list->appendChild($grant);
		}

		$policy->appendChild($list);
		$dom->appendChild($policy);
		
		$data 	= $dom->saveXML();
		$query 	= array('acl' => NULL);
		$header = array('Content-Type' => 'application/xml');

		return $this->_setResponse('PUT', $bucket, $path, $query, $data, $headers);
	}
	
	/* Protected Methods
	-------------------------------*/	
	protected function _getHost($bucket = NULL) {
		if(!$bucket) {
			return $this->_host;
		}
		
		return strtolower($bucket).'.'.$this->_host;
	}
	
	protected function _getPath($bucket = NULL, $path = '/', array $query = array()) {
		if ($bucket) {
			return '/'.strtolower($bucket).$path;
		} 
		
		$keys = array_keys($query);
		foreach($keys as $key) {
			if(in_array($key, array('acl', 'location', 'torrent', 'logging'))) {
				$query = http_build_query($query);
				
				$link = '?';
				if(strpos($path, '?') !== false) {
					$link = '&';
				}
				
				return $path.$link.$query;
			}
		}
		
		return $path;
	}
	
	protected function _getSignature($string) {
		if(extension_loaded('hash')) {
			$hash = base64_encode(hash_hmac('sha1', $string, $this->_accessSecret, true));
		} else {
			$pad1 = str_pad($this->_accessSecret, 64, chr(0x00)) ^ str_repeat(chr(0x36), 64);
			$pad2 = str_pad($this->_accessSecret, 64, chr(0x00)) ^ str_repeat(chr(0x5c), 64);
			$pack1	= pack('H*', sha1($pad1 . $string));
			$pack2 	= pack('H*', sha1($pad2 . $pack1));
			$hash = base64_encode($pack2);
		}
		
		return 'AWS '.$this->_accessKey.':'.$hash;	
	}

	protected function _getUrl($host, $path, $query = NULL) {
		if(is_array($query)) {
			$query = http_build_query($query);
		}
		
		$link = '?';
		if(strpos($path, '?') !== false) {
			$link = '&';
		}
		
		$protocol = 'http://';
		if($this->_ssl && extension_loaded('openssl')) {
			$protocol = 'https://';
		}
		
		return $protocol.$host.$path.$link.$query;
	}
	
	protected function _responseHeaderCallback(&$curl, &$data) {
		$strlen = strlen($data);
		if ($strlen <= 2) {
			return $strlen;
		}
		
		if (substr($data, 0, 4) == 'HTTP') {
			$this->_meta['code'] = substr($data, 9, 3);
			return $strlen;
		}
		
		list($header, $value) = explode(': ', trim($data), 2);
		
		if ($header == 'Last-Modified') {
			$this->_meta['headers']['time'] = strtotime($value);
		} else if ($header == 'Content-Length') {
			$this->_meta['headers']['size'] = $value;
		} else if ($header == 'Content-Type') {
			$this->_meta['headers']['type'] = $value;
		} else if ($header == 'ETag') {
			$this->_meta['headers']['hash'] = $value{0} == '"' ? substr($value, 1, -1) : $value;
		} else if (preg_match('/^x-amz-meta-.*$/', $header)) {
			$this->_meta['headers'][$header] = $value;
		}
		
		return $strlen;
	}
	
	protected function _responseWriteCallback(&$curl, &$data) {
		$this->_response .= $data;
		return strlen($data);
	}

	protected function _setResponse($action, $bucket = NULL, $path = '/', array $query = array(), 
		$data = NULL, array $headers = array(), array $amazon = array()) {

		//get host - bucket1.s3.amazonaws.com
		$host 	= $this->_getHost($bucket);
		//get url - http://bucket1.s3.amazonaws.com/some/path
		$url 	= $this->_getUrl($host, $path, $query);
		//get path - /bucket1/some/path
		$path 	= $this->_getPath($bucket, $path);
		
		//get headers
		ksort($amazon);
		$curlHeaders = $amazonHeaders = array(); 
		
		$headers['Host'] = $host;
		$headers['Date'] = gmdate('D, d M Y H:i:s T');
		
		foreach ($amazon as $header => $value) {
			$curlHeaders[] = $header.': '.$value; 
			$amazonHeaders[] = strtolower($header).':'.$value;
		}
		
		foreach ($headers as $header => $value) {
			$curlHeaders[] = $header.': '.$value; 
		}

		$amazonHeaders = "\n".implode("\n", $amazonHeaders);
		
		if(!trim($amazonHeaders)) {
			$amazonHeaders = NULL;
		}
		
		if(!isset($headers['Content-MD5'])) {
			$headers['Content-MD5'] = NULL;
		}
		
		if(!isset($headers['Content-Type'])) {
			$headers['Content-Type'] = NULL;
		}
		
		//get signature
		$signature = array(
			$action,
			$headers['Content-MD5'], 
			$headers['Content-Type'],
			$headers['Date'].$amazonHeaders,
			$path);
		
		$signature = implode("\n", $signature);
		if($headers['Host'] == 'cloudfront.amazonaws.com') {
			$signature = $headers['Date'];
		}
		
		$curlHeaders[] = 'Authorization: ' . $this->_getSignature($signature);
		
		//setup curl 
		$curl = Eden_Curl::i()
			->setUserAgent('S3/php')
			->setUrl($url)
			->setHeaders($curlHeaders)
			->setHeader(false)
			->setWriteFunction(array(&$this, '_responseWriteCallback'))
			//->setHeaderFunction(array(&$this, '_responseHeaderCallback'))
			//->when($this->_ssl)
			->verifyHost(true)
			->verifyPeer(true);
			//->endWhen();

		// Request types
		switch ($action) {
			case 'GET': 
				break;
			case 'PUT': 
			case 'POST': // POST only used for CloudFront
			
			//Open a file resource using the php://memory stream
			$fh = fopen('php://memory', 'rw');
			// Write the data to the file
			fwrite($fh, $data);
			// Move back to the beginning of the file
			rewind($fh); 
		
				$curl->setPut(true)
					->setInFile($fh)
					->setInFileSize(strlen($data));
				break;
			case 'HEAD':
				$curl->setCustomRequest('HEAD')->setNobody(true);
				break;
			case 'DELETE':
				$curl->setCustomRequest('DELETE');
				break;
		}
		//get curl response
		$response 	= $curl->getResponse();
		
		//if there is no errot in curl
		if(!empty($response)) {		
			//check if response format is in xml
			if($this->_isXml($response)) { 
				//if it is xml, well format in to object
				$this->_response = simplexml_load_string($response);
			} 
		//else, there must be a curl error
		} else {
			//return curl error
			$this->_response = $curl->getMeta(); 
		}
		
		//save curl response to meta
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $curlHeaders;
		$this->_meta['query'] 			= $data;
		$this->_meta['path']			= $path;
		$this->_meta['bucket']			= $bucket;
		$this->_meta['response'] 		= $this->_response;
		//print_r($this->_meta);
		return $this->_response;
	}
	
	protected function _isXml($xml) {
	
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		//if it is a valid xml format
		if(empty($errors)) {
			return true;
		} else {
			return false;
		}
	}
	
	/* Private Methods
	-------------------------------*/
}
