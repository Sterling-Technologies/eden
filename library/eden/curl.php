<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 * cURL allows you to connect and communicate to many 
 * different types of servers with many different types 
 * of protocols. We rely on cURL heavily as the main
 * transport for all API interactions.
 *
 * @package    Eden
 * @category   curl
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Curl extends Eden_Class implements ArrayAccess {
	/* Constants
	-------------------------------*/
	const PUT 		= 'PUT';
	const DELETE 	= 'DELETE';
	const GET 		= 'GET';
	const POST 		= 'POST';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_options = array();
	protected $_meta 	= array();
	protected $_query	= array();
	protected $_headers	= array();
	
	protected static $_setBoolKeys = array(
		'AutoReferer' 		=> CURLOPT_AUTOREFERER,
		'BinaryTransfer' 	=> CURLOPT_BINARYTRANSFER,
		'CookieSession' 	=> CURLOPT_COOKIESESSION,
		'CrlF' 				=> CURLOPT_CRLF,
		'DnsUseGlobalCache' => CURLOPT_DNS_USE_GLOBAL_CACHE,
		'FailOnError' 		=> CURLOPT_FAILONERROR,
		'FileTime' 			=> CURLOPT_FILETIME,
		'FollowLocation' 	=> CURLOPT_FOLLOWLOCATION,
		'ForbidReuse' 		=> CURLOPT_FORBID_REUSE,
		'FreshConnect' 		=> CURLOPT_FRESH_CONNECT,
		'FtpUseEprt' 		=> CURLOPT_FTP_USE_EPRT,
		'FtpUseEpsv' 		=> CURLOPT_FTP_USE_EPSV,
		'FtpAppend' 		=> CURLOPT_FTPAPPEND,
		'FtpListOnly' 		=> CURLOPT_FTPLISTONLY,
		'Header' 			=> CURLOPT_HEADER,
		'HeaderOut' 		=> CURLINFO_HEADER_OUT,
		'HttpGet' 			=> CURLOPT_HTTPGET,
		'HttpProxyTunnel' 	=> CURLOPT_HTTPPROXYTUNNEL,
		'Netrc' 			=> CURLOPT_NETRC,
		'Nobody' 			=> CURLOPT_NOBODY,
		'NoProgress' 		=> CURLOPT_NOPROGRESS,
		'NoSignal' 			=> CURLOPT_NOSIGNAL,
		'Post' 				=> CURLOPT_POST,
		'Put' 				=> CURLOPT_PUT,
		'ReturnTransfer' 	=> CURLOPT_RETURNTRANSFER,
		'SslVerifyPeer' 	=> CURLOPT_SSL_VERIFYPEER,
		'TransferText' 		=> CURLOPT_TRANSFERTEXT,
		'UnrestrictedAuth' 	=> CURLOPT_UNRESTRICTED_AUTH,
		'Upload' 			=> CURLOPT_UPLOAD,
		'Verbose' 			=> CURLOPT_VERBOSE);
	
	protected static $_setIntegerKeys = array(
		'BufferSize' 		=> CURLOPT_BUFFERSIZE,
		'ClosePolicy' 		=> CURLOPT_CLOSEPOLICY,
		'ConnectTimeout' 	=> CURLOPT_CONNECTTIMEOUT,
		'ConnectTimeoutMs' 	=> CURLOPT_CONNECTTIMEOUT_MS,
		'DnsCacheTimeout' 	=> CURLOPT_DNS_CACHE_TIMEOUT,
		'FtpSslAuth' 		=> CURLOPT_FTPSSLAUTH,
		'HttpVersion' 		=> CURLOPT_HTTP_VERSION,
		'HttpAuth' 			=> CURLOPT_HTTPAUTH,
		'InFileSize' 		=> CURLOPT_INFILESIZE,
		'LowSpeedLimit' 	=> CURLOPT_LOW_SPEED_LIMIT,
		'LowSpeedTime' 		=> CURLOPT_LOW_SPEED_TIME,
		'MaxConnects' 		=> CURLOPT_MAXCONNECTS,
		'MaxRedirs' 		=> CURLOPT_MAXREDIRS,
		'Port' 				=> CURLOPT_PORT,
		'ProxyAuth' 		=> CURLOPT_PROXYAUTH,
		'ProxyPort' 		=> CURLOPT_PROXYPORT,
		'ProxyType' 		=> CURLOPT_PROXYTYPE,
		'ResumeFrom' 		=> CURLOPT_RESUME_FROM,
		'SslVerifyHost' 	=> CURLOPT_SSL_VERIFYHOST,
		'SslVersion' 		=> CURLOPT_SSLVERSION,
		'TimeCondition' 	=> CURLOPT_TIMECONDITION,
		'Timeout' 			=> CURLOPT_TIMEOUT,
		'TimeoutMs' 		=> CURLOPT_TIMEOUT_MS,
		'TimeValue' 		=> CURLOPT_TIMEVALUE);
	
	protected static $_setStringKeys = array(
		'CaInfo' 			=> CURLOPT_CAINFO,
		'CaPath' 			=> CURLOPT_CAPATH,
		'Cookie' 			=> CURLOPT_COOKIE,
		'CookieFile' 		=> CURLOPT_COOKIEFILE,
		'CookieJar' 		=> CURLOPT_COOKIEJAR,
		'CustomRequest' 	=> CURLOPT_CUSTOMREQUEST,
		'EgdSocket' 		=> CURLOPT_EGDSOCKET,
		'Encoding' 			=> CURLOPT_ENCODING,
		'FtpPort' 			=> CURLOPT_FTPPORT,
		'Interface' 		=> CURLOPT_INTERFACE,
		'Krb4Level' 		=> CURLOPT_KRB4LEVEL,
		'PostFields' 		=> CURLOPT_POSTFIELDS,
		'Proxy' 			=> CURLOPT_PROXY,
		'ProxyUserPwd' 		=> CURLOPT_PROXYUSERPWD,
		'RandomFile' 		=> CURLOPT_RANDOM_FILE,
		'Range' 			=> CURLOPT_RANGE,
		'Referer' 			=> CURLOPT_REFERER,
		'SslCipherList' 	=> CURLOPT_SSL_CIPHER_LIST,
		'SslCert' 			=> CURLOPT_SSLCERT,
		'SslCertPassword' 	=> CURLOPT_SSLCERTPASSWD,
		'SslCertType' 		=> CURLOPT_SSLCERTTYPE,
		'SslEngine' 		=> CURLOPT_SSLENGINE,
		'SslEngineDefault' 	=> CURLOPT_SSLENGINE_DEFAULT,
		'Sslkey' 			=> CURLOPT_SSLKEY,
		'SslKeyPasswd' 		=> CURLOPT_SSLKEYPASSWD,
		'SslKeyType' 		=> CURLOPT_SSLKEYTYPE,
		'Url' 				=> CURLOPT_URL,
		'UserAgent' 		=> CURLOPT_USERAGENT,
		'UserPwd' 			=> CURLOPT_USERPWD);
	
	protected static $_setArrayKeys = array(
		'Http200Aliases' 	=> CURLOPT_HTTP200ALIASES,
		'HttpHeader' 		=> CURLOPT_HTTPHEADER,
		'PostQuote' 		=> CURLOPT_POSTQUOTE,
		'Quote' 			=> CURLOPT_QUOTE);
		
	protected static $_setFileKeys = array(
		'File' 				=> CURLOPT_FILE,
		'InFile' 			=> CURLOPT_INFILE,
		'StdErr' 			=> CURLOPT_STDERR,
		'WriteHeader' 		=> CURLOPT_WRITEHEADER);
		
	protected static $_setCallbackKeys = array(
		'HeaderFunction' 	=> CURLOPT_HEADERFUNCTION,
		'ReadFunction' 		=> CURLOPT_READFUNCTION,
		'WriteFunction' 	=> CURLOPT_WRITEFUNCTION);

	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __call($name, $args) {
		if(strpos($name, 'set') === 0) {
			$method = substr($name, 3);
			
			if(isset(self::$_setBoolKeys[$method])) {
				Eden_Curl_Error::i()->vargument($name, $args, 1, 'bool');
				$key = self::$_setBoolKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
			
			if(isset(self::$_setIntegerKeys[$method])) {
				Eden_Curl_Error::i()->vargument($name, $args, 1, 'int');
				$key = self::$_setIntegerKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
			
			if(isset(self::$_setStringKeys[$method])) {
				Eden_Curl_Error::i()->vargument($name, $args, 1, 'string');
				$key = self::$_setStringKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
			
			if(isset(self::$_setArrayKeys[$method])) {
				Eden_Curl_Error::i()->vargument($name, $args, 1, 'array');
				$key = self::$_setArrayKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
			
			if(isset(self::$_setFileKeys[$method])) {
				$key = self::$_setFileKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
			
			if(isset(self::$_setCallbackKeys[$method])) {
				Eden_Curl_Error::i()->vargument($name, $args, 1, 'array', 'string');
				$key = self::$_setCallbackKeys[$method];
				$this->_options[$key] = $args[0];
				
				return $this;
			}
		}
		
		parent::__call($name, $args);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Send the curl off and returns the results
	 * parsed as DOMDocument
	 *
	 * @return DOMDOcument
	 */
	public function getDomDocumentResponse() {
		$this->_meta['response'] = $this->getResponse();
		$xml = new DOMDocument();
		$xml->loadXML($this->_meta['response']);
		return $xml;
	}
	
	/**
	 * Send the curl off and returns the results
	 * parsed as JSON
	 *
	 * @return array
	 */
	public function getJsonResponse($assoc = true) {
		$this->_meta['response'] = $this->getResponse();
		Eden_Curl_Error::i()->argument(1, 'bool');
		return json_decode($this->_meta['response'], $assoc);
	}
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Curl_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Send the curl off and returns the results
	 * parsed as url query
	 *
	 * @return array
	 */
	public function getQueryResponse() {
		$this->_meta['response'] = $this->getResponse();
		parse_str($this->_meta['response'], $response);
		return $response;
	}
	
	/**
	 * Send the curl off and returns the results
	 *
	 * @return string
	 */
	public function getResponse() {
		$curl = curl_init();
		
		$this->_addParameters()->_addHeaders();
		$this->_options[CURLOPT_RETURNTRANSFER] = true;
		curl_setopt_array($curl, $this->_options);
		
		$response = curl_exec($curl);
		
		$this->_meta = array(
			'info' 			=> curl_getinfo($curl, CURLINFO_HTTP_CODE),
			'error_message'	=> curl_errno($curl),
			'error_code'	=> curl_error($curl));
		
		curl_close($curl);
		unset($curl);
		
		return $response;
	}
	
	/**
	 * Send the curl off and returns the results
	 * parsed as SimpleXml
	 *
	 * @return SimpleXmlElement
	 */
	public function getSimpleXmlResponse() {
		$this->_meta['response'] = $this->getResponse();
		return simplexml_load_string($this->_meta['response']);
	}
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($this->_option[$offset]);
    }
	
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($this->_option[$offset]) ? $this->_option[$offset] : NULL;
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        if (!is_null($offset)) {
			if(in_array($offset, $this->_setBoolKeys)) {
				$method = array_search($offset, $this->_setBoolKeys);
				$this->_call('set'.$method, array($value));
			}
			
			if(in_array($offset, $this->_setIntegerKeys)) {
				$method = array_search($offset, $this->_setIntegerKeys);
				$this->_call('set'.$method, array($value));
			}
			
			if(in_array($offset, $this->_setStringKeys)) {
				$method = array_search($offset, $this->_setStringKeys);
				$this->_call('set'.$method, array($value));
			}
			
			if(in_array($offset, $this->_setArrayKeys)) {
				$method = array_search($offset, $this->_setArrayKeys);
				$this->_call('set'.$method, array($value));
			}
			
			if(in_array($offset, $this->_setFileKeys)) {
				$method = array_search($offset, $this->_setFileKeys);
				$this->_call('set'.$method, array($value));
			}
			
			if(in_array($offset, $this->_setCallbackKeys)) {
				$method = array_search($offset, $this->_setCallbackKeys);
				$this->_call('set'.$method, array($value));
			}
        }
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
        unset($this->_option[$offset]);
    }
	
	/**
	 * Send the curl off 
	 *
	 * @return this
	 */
	public function send() {
		$curl = curl_init();
		
		$this->_addParameters()->_addHeaders();
		curl_setopt_array($curl, $this->_options);
		curl_exec($curl);
		
		$this->_meta = array(
			'info' 			=> curl_getinfo($curl, CURLINFO_HTTP_CODE),
			'error_message'	=> curl_errno($curl),
			'error_code'	=> curl_error($curl));
		
		curl_close($curl);
		unset($curl);
		
		return $this;
	}
	
	/**
	 * Curl has problems handling custom request types
	 * from misconfigured end points or vice versa. 
	 * When default cURL fails, try a custom GET instead
	 *
	 * @return this
	 */
	public function setCustomGet() {
		$this->setCustomRequest(self::GET);
		return $this;
	}
	
	/**
	 * Curl has problems handling custom request types
	 * from misconfigured end points or vice versa. 
	 * When default cURL fails, try a custom POST instead
	 *
	 * @return this
	 */
	public function setCustomPost() {
		$this->setCustomRequest(self::POST);
		return $this;
	}
	
	/**
	 * Curl has problems handling custom request types
	 * from misconfigured end points or vice versa. 
	 * When default cURL fails, try a custom PUT instead
	 *
	 * @return this
	 */
	public function setCustomPut() {
		$this->setCustomRequest(self::PUT);
		return $this;
	}
	
	/**
	 * Curl has problems handling custom request types
	 * from misconfigured end points or vice versa. 
	 * When default cURL fails, try a custom DELETE instead
	 *
	 * @return this
	 */
	public function setCustomDelete() {
		$this->setCustomRequest(self::DELETE);
		return $this;
	}
	
	/**
	 * CURLOPT_POSTFIELDS accepts array and string
	 * arguments, this is a special case that __call 
	 * does not handle 
	 *
	 * @param string|array
	 * @return this
	 */
	public function setPostFields($fields) {
		//argument 1 must be a string or array
		Eden_Curl_Error::i()->argument(1, 'array', 'string');
		$this->_options[CURLOPT_POSTFIELDS] = $fields;
		
		return $this;
	}
	
	/**
	 * Sets request headers
	 *
	 * @param array|string
	 * @return this
	 */
	public function setHeaders($key, $value = NULL) {
		Eden_Curl_Error::i()
			->argument(1, 'array', 'string')
			->argument(2, 'scalar','null');
		
		if(is_array($key)) {
			$this->_headers = $key;
			return $this;
		}
		
		$this->_headers[] = $key.': '.$value;
		return $this;
	}
	
	/**
	 * Sets url parameter
	 *
	 * @param array|string
	 * @return this
	 */
	public function setUrlParameter($key, $value = NULL) {
		Eden_Curl_Error::i()
			->argument(1, 'array', 'string')
			->argument(2, 'scalar');
		
		if(is_array($key)) {
			$this->_param = $key;
			return $this;
		}
		
		$this->_param[$key] = $value;
	}
	
	/**
	 * Sets CURLOPT_SSL_VERIFYHOST
	 *
	 * @param bool
	 * @return this
	 */
	public function verifyHost($on = true) {
		Eden_Curl_Error::i()->argument(1, 'bool');
		$this->_options[CURLOPT_SSL_VERIFYHOST] = $on ? 1 : 2;
		return $this;
	}
	
	/**
	 * Sets CURLOPT_SSL_VERIFYPEER
	 *
	 * @param bool
	 * @return this
	 */
	public function verifyPeer($on = true) {
		Eden_Curl_Error::i()->argument(1, 'bool');
		$this->_options[CURLOPT_SSL_VERIFYPEER] = $on;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _addHeaders() {
		if(empty($this->_headers)) {
			return $this;
		}
		
		$this->_options[CURLOPT_HTTPHEADER] = $this->_headers;
		return $this;
	}
	
	protected function _addParameters() {
		if(empty($this->_params)) {
			return $this;
		}
		
		$params = http_build_query($this->_params);
		if($this->_options[CURLOPT_POST]) {
			$this->_options[CURLOPT_POSTFIELDS] = $params;
			return $this;
		}
		
		//if there is a question mark in the url
		if(strpos($this->_options[CURLOPT_URL], '?') === false) {
			//add the question mark
			$params = '?'.$params;
		//else if the question mark is not at the end
		} else if(substr($this->_options[CURLOPT_URL], -1, 1) != '?') {
			//append the parameters to the end
			//with the other parameters
			$params = '&'.$params; 
		}
		
		//append the parameters
		$this->_options[CURLOPT_URL] .= $params;
		
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}

/**
 * cUrl Errors
 */
class Eden_Curl_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}