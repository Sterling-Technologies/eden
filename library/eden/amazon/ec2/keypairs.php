<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Key Pairs
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_KeyPairs extends Eden_Amazon_Ec2_Base {
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
	public static function i() {
		return self::_getMultiple(__CLASS__);
	} 
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Creates a new 2048-bit RSA key pair with the specified name. The public key is stored 
	 * by Amazon EC2 and the private key is returned to you. The private key is returned 
	 * as an unencrypted PEM encoded PKCS#8 private key. If a key with the specified name 
	 * already exists, Amazon EC2 returns an error.
	 *
	 * @param string A unique name for the key pair.
	 * @return array
	 */
	public function createKeyPair($keyName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']		= 'CreateKeyPair';
		$this->_query['KeyName']	= $keyName;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes the specified key pair, by removing the public key from Amazon EC2. 
	 * You must own the key pair.
	 *
	 * @param string A unique name for the key pair.
	 * @return array
	 */
	public function deleteKeyPair($keyName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']		= 'DeleteKeyPair';
		$this->_query['KeyName']	= $keyName;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about key pairs available to you
	 *
	 * @return array
	 */
	public function describeKeyPairs() {		
		
		$this->_query['Action']	= 'DescribeKeyPairs';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Imports the public key from an RSA key pair that you created with a
	 * third-party tool. Compare this with CreateKeyPair, in which AWS creates
	 * the key pair and gives the keys to you 
	 *
	 * @param string A unique name for the key pair.	
	 * @param string The public key.
	 * @return array
	 */
	public function importKeyPair($keyName, $publicKeyMaterial) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');	
		
		$this->_query['Action']				= 'ImportKeyPair';
		$this->_query['KeyName']			= $keyName;
		$this->_query['PublicKeyMaterial']	= base64_encode($publicKeyMaterial);
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Key pair name
	 *
	 * @param string
	 * @return array
	 */
	public function setKeyName($keyName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['KeyName_']
			[isset($this->_query['KeyName_'])?
			count($this->_query['KeyName_'])+1:1] = $keyName;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	