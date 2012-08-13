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
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_ssl 			= false;
	protected $_host			= 's3.amazonaws.com';
	protected $_user			= NULL;
	protected $_pass			= NULL;
	
	protected $_meta			= array();
	protected $_response		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($user, $pass, $host = 's3.amazonaws.com', $ssl = false) {
		$this->_host 	= $host;
		$this->_user 	= $user;
		$this->_pass 	= $pass;
		$this->_ssl 	= $ssl;
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Put a bucket
	 *
	 * @param string $bucket Bucket name
 	 * @param constant $acl ACL flag
	 * @param string $location Set as "EU" to create buckets hosted in Europe
	 * @return boolean
	 */
	public function addBucket($bucket, $acl = self::ACL_PRIVATE, $location = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//Argument 1 must be string
			->argument(2, 'string', 'null')		//Argument 2 must be string or null
			->argument(3, 'bool');				//Argument 3 must be bool
			
		$data = NULL;
		$headers = array();
		$amazon = array('x-amz-acl' => $acl);
		
		if ($location !== false) {
			$dom 		= new DOMDocument;
			$config 	= $dom->createElement('CreateBucketConfiguration');
			$constraint = $dom->createElement('LocationConstraint', strtoupper($location));
			
			$config->appendChild($constraint);
			$dom->appendChild($config);
			$data = $dom->saveXML();
			
			$headers['Content-Type'] = 'application/xml';
		}
		
		$this->_setResponse('PUT', $bucket, '/', array(), $data, $headers, $amazon);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Put an object
	 *
	 * @param mixed $input Input data
	 * @param string $bucket Bucket name
	 * @param string $path Object URI
	 * @param constant $acl ACL constant
	 * @param array $metaHeaders Array of x-amz-meta-* headers
	 * @param array $requestHeaders Array of request headers or content type as a string
	 * @return boolean
	 */
	public function addFile($bucket, $path, $data, $acl = self::ACL_PRIVATE, $file = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string')		//Argument 2 must be string
			->argument(4, 'string')		//Argument 4 must be string
			->argument(5, 'bool');		//Argument 5 must be boolean
			
		$headers = $amazon = array();
		
		$headers['Content-Type'] = Eden_File::i()->getMimeType($path);
		$amazon['x-amz-acl'] = $acl;
		
		if(strpos($path, '/') !== 0) {
			$path = '/'.$path;
		}
		
		//if not file 
		if(!$file) {
			//put it into a file
			//we do this because file data in memory is bad
			$tmp = tmpfile();
			fwrite($tmp, $data);
			$file = $tmp;
			$size = strlen($data);
			//release file data from memory
			$data = NULL;
		//if is a file
		} else {
			$file = fopen($data, 'r');
			$size = filesize($data);
		}
		
		$data = array($file, $size);
		
		$this->_setResponse('PUT', $bucket, $path, array(), $data, $headers, $amazon);
		
		//dont forget to close
		fclose($file);
		
		if(!empty($this->_meta['error'])) {
			return false;
		}
		
		return $size;
	}
	
	/**
	 * Delete an empty bucket
	 *
	 * @param string $bucket Bucket name
	 * @return boolean
	 */
	public function deleteBucket($bucket) {
		//Argument 1 must be string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_setResponse('DELETE', $bucket);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Delete an object
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @return boolean
	 */
	public function deleteFile($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		$this->_setResponse('DELETE', $bucket, $path);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Delete an object
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @return boolean
	 */
	public function deleteFolder($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
			
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
			
			$this->deleteFile($bucket, '/'.$object['name']);
		}
		
		return true;
	}
	
	/**
	 * Get contents for a bucket
	 *
	 * If maxKeys is NULL this method will loop through truncated result sets
	 *
	 * @param string $name Bucket name
	 * @param string $prefix Prefix
	 * @param string $marker Marker (last file listed)
	 * @param string $maxKeys Max keys (maximum number of keys to return)
	 * @param string $delimiter Delimiter
	 * @return array | false
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
			
			if(!empty($this->_meta['error']) || empty($this->_response)) {
				break;
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
	 * @param boolean $detailed Returns detailed bucket list when true
	 * @return array | false
	 */
	public function getBuckets() {
		$this->_setResponse('GET');
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		$buckets = array();
		foreach ($this->_response->Buckets->Bucket as $bucket) {
			$buckets[] = (string)$bucket->Name;
		}
		
		return $buckets;
	}
	
	/**
	 * Get an object
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @param mixed $saveTo Filename or resource to write to
	 * @return mixed
	 */
	public function getFile($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
			
		$this->_setResponse('GET', $bucket, $path);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		return $this->_response;
	}
	
	/**
	 * Get object information
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @param boolean $returnInfo Return response information
	 * @return mixed | false
	 */
	public function getFileInfo($bucket, $path) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		if(strpos($path, '/') !== 0) {
			$path = '/'.$path;
		}
		
		$this->_setResponse('HEAD', $bucket, $path);
		
		if(!empty($this->_meta['error'])) {
			return false;
		}
		
		return $this->_meta['headers'];
	}
	
	/**
	 * Get files for a bucket given a path
	 *
	 * If maxKeys is NULL this method will loop through truncated result sets
	 *
	 * @param string $bucket Bucket name
	 * @param string $prefix Prefix
	 * @param string $marker Marker (last file listed)
	 * @param string $maxKeys Max keys (maximum number of keys to return)
	 * @param string $delimiter Delimiter
	 * @param boolean $prefixes Set to true to return CommonPrefixes
	 * @return array | false
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
	 * @param string $bucket Bucket name
	 * @param string path
	 * @param string $prefix Prefix
	 * @param string $marker Marker (last file listed)
	 * @param string $maxKeys Max keys (maximum number of keys to return)
	 * @param string $delimiter Delimiter
	 * @param boolean $prefixes Set to true to return CommonPrefixes
	 * @return array | false
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
	
	public function getMeta($key = NULL) {
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Get object or bucket Access Control Policy
	 *
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @return mixed | false
	 */
	public function getPermissions($bucket, $path = '/') {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be string
			->argument(2, 'string');	//Argument 2 must be string
		
		$query['acl'] = NULL;
		$this->_setResponse('GET', $bucket, $path);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
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
	 * @param string $bucket Bucket name
	 * @param string $uri Object URI
	 * @param array $acp Access Control Policy Data (same as the data returned from getAccessControlPolicy)
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

		$this->_setResponse('PUT', $bucket, $path, $query, $data, $headers);
		
		if(!empty($this->_meta['error']) || empty($this->_response)) {
			return false;
		}
		
		return true;
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
			$hash = base64_encode(hash_hmac('sha1', $string, $this->_pass, true));
		} else {
			$pad1 = str_pad($this->_pass, 64, chr(0x00)) ^ str_repeat(chr(0x36), 64);
			$pad2 = str_pad($this->_pass, 64, chr(0x00)) ^ str_repeat(chr(0x5c), 64);
			$pack1	= pack('H*', sha1($pad1 . $string));
			$pack2 	= pack('H*', sha1($pad2 . $pack1));
			$hash = base64_encode($pack2);
		}
		
		return 'AWS '.$this->_user.':'.$hash;	
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
		
		//reset meta and response
		$this->_meta = array();
		$this->_response = NULL;
		
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
			->setHeaderFunction(array(&$this, '_responseHeaderCallback'))
			->when($this->_ssl)
			->verifyHost(true)
			->verifyPeer(true)
			->endWhen();

		// Request types
		switch ($action) {
			case 'GET': 
				break;
			case 'PUT': 
			case 'POST': // POST only used for CloudFront
				$curl->setPut(true)
					->setInFile($data[0])
					->setInFileSize($data[1]);
				break;
			case 'HEAD':
				$curl->setCustomRequest('HEAD')->setNobody(true);
				break;
			case 'DELETE':
				$curl->setCustomRequest('DELETE');
				break;
		}
		
		$response 	= $curl->getResponse();
		$meta 		= $curl->getMeta();
		
		// Execute, grab errors
		if ($response) {
			$this->_meta['code'] = $meta['info'];
			$this->_meta['error'] = array();
		} else {
			$this->_meta['error'] = array(
				'code' 		=> $meta['error_code'],
				'message' 	=> $meta['error_message'],
				'path' 		=> $path);
		}
		
		// Parse body into XML
		if(empty($this->_meta['error']) 
			&& isset($this->_meta['headers']['type'])
			&& $this->_meta['headers']['type'] == 'application/xml'
			&& strlen($this->_response) > 0) {
			
			$this->_response = simplexml_load_string($this->_response);
			
			if(!in_array($this->_meta['code'], array(200, 204))
				&& isset($this->_response->Code, $this->_response->Message)) {
				
				$this->_meta['error'] = array(
					'code' 		=> $this->_response->Code,
					'message' 	=> $this->_response->Message,
					'path' 		=> $path);
				
				if(isset($this->_response->Resource)) {
					$this->_meta['error']['path'] = $this->_response->Resource;
				}
				
				$this->_response = NULL;
			}
		}
		
		return $this;
	}

	/* Private Methods
	-------------------------------*/
}
