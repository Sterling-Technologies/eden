<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon ec2 base
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const AMAZON_EC2_URL	= 'https://ec2.amazonaws.com/';
	const AMAZON_EC2_HOST	= 'ec2.amazonaws.com';

	const VERSION_DATE 		= '2012-07-20';
	const VERSION			= 'Version';
	const SIGNATURE			= 'Signature';
	const SIGNATURE_VERSION	= 'SignatureVersion';
	const SIGNATURE_METHOD	= 'SignatureMethod';
	const ACCESS_KEY		= 'AWSAccessKeyId';
	const TIMESTAMP			= 'Timestamp';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta 		= NULL;
	protected $_versionDate = self::VERSION_DATE;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($accessKey, $accessSecret) { 
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_accessKey		= $accessKey;
		$this->_accessSecret	= $accessSecret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * The name of a filter. 
	 *
	 * @param string
	 * @return array
	 */
	public function setFilterName($filterName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Filter_Name']
			[isset($this->_query['Filter_Name'])?
			count($this->_query['Filter_Name'])+1:1] = $filterName;
		
		return $this;
	}
	
	/**
	 * The name of a filter. 
	 *
	 * @param string
	 * @return array
	 */
	public function setFilterValue($filterNumber, $valueNumber, $filterValue) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string', 'int')	//argument 1 must be a string or integer
			->argument(2, 'string', 'int')	//argument 2 must be a string or integer
			->argument(3, 'string');		//argument 3 must be a string
		
		$this->_query[sprintf('Filter.%s.Value.%s',$filterNumber, $valueNumber)] = $filterValue;
		
		return $this;
	}
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta() {
	
		return $this->_meta;
	}
	
	/**
	 * Set Amazon API version date
	 *
	 * @param string Amazon version date
	 * @return this
	 */
	public function setVersionDate($date) {
		//argument test
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_versionDate = $date;
		
		return $this;
	}
	/**
	 * Check if the response is xml
	 *
	 * @param string|array|object|null
	 * @return bollean
	 */
	public function isXml($xml) {
		//argument 1 must be a string, array,  object or null
		Eden_Amazon_Error::i()->argument(1, 'string', 'array', 'object', 'null');
		
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		
		return empty($errors);
	}
	/* Protected Methods
	-------------------------------*/
	protected function _generateSignature($host, $query) {	
		// Write the signature
		$signature = "GET\n";
		$signature .= "$host\n";
		$signature .= "/\n";
		//sort query
		ksort($query);
		$first = true;
		//generate a hash signature
		foreach($query as $key => $value) {
			$signature .= (!$first ? '&' : '') . rawurlencode($key) . '=' . rawurlencode($value);
			$first = false;
		}
		//genarate signature by encoding the access secret to the signature hash
		$signature = hash_hmac('sha256', $signature, $this->_accessSecret, true);
		$signature = base64_encode($signature);
		
		return $signature;
	}
	
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
	
	protected function _formatQuery($rawQuery) {
		foreach($rawQuery as $key => $value) {
			//if value is still in array
			if(is_array($value)) {
				//foreach value
				foreach($value as $k => $v) {
					$keyValue = explode('_', $key);
					if(!empty($keyValue[1])) {
						$name =  rawurlencode($keyValue[0].'.'.$k.'.'.$keyValue[1]);
					} else {
						$name =  rawurlencode($keyValue[0].'.'.$k);
					}
					//put key key name with k integer if they set multiple value
					$query[str_replace("%7E", "~", $name)] = str_replace("%7E", "~", rawurlencode($v));
				}
			//else it is a simple array only	
			} else {
				//format array to query
				$query[str_replace("%7E", "~", rawurlencode($key))] = str_replace("%7E", "~", rawurlencode($value));
			}
		} 
		return $query;
	}
	
	protected function _getResponse($host, $rawQuery) { 
		//prevent sending null values
		$rawQuery = $this->_accessKey($rawQuery); 
		//sort the raw query
		ksort($rawQuery);
		//format array query
		$query = $this->_formatQuery($rawQuery); 
		// Build out the variables
		$domain = "https://$host/";
		//set parameters for generating request
		$query[self::ACCESS_KEY] 		= $this->_accessKey; 
		$query[self::TIMESTAMP] 		= date('c');
		$query[self::VERSION] 			= $this->_versionDate;
		$query[self::SIGNATURE_METHOD]	= 'HmacSHA256';
		$query[self::SIGNATURE_VERSION] = 2; 
		//create a request signature for security access
		$query[self::SIGNATURE] 		= $this->_generateSignature($host, $query);
		//build a http query
		$url = $domain.'?'.http_build_query($query); 
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
		//get response from curl
		$response = $curl->getResponse();
		
		//if result is in xml format 
		if($this->isXml($response)){
			//convert it to string
			$response = simplexml_load_string($response);
		}
		
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		return $response;
	
	}
	
	/* Private Methods
	-------------------------------*/
}
