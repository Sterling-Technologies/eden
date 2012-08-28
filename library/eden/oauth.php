<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/oauth/error.php';
require_once dirname(__FILE__).'/oauth/base.php';
require_once dirname(__FILE__).'/oauth/consumer.php';
require_once dirname(__FILE__).'/oauth/server.php';

/**
 * Oauth Factory; A summary of 2-legged and 3-legged OAuth
 * which can generally connect to any properly implemented
 * OAuth server.
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Oauth extends Eden_Class {
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
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the oauth consumer class
	 * 
	 * @return Eden_Oauth_Consumer
	 */
	public function consumer($url, $key, $secret) {
		return Eden_Oauth_Consumer::i($url, $key, $secret);
	}
	
	/**
	 * Returns an access token given the requiremets
	 * GET, HMAC-SHA1
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getHmacGetAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToGet()							//set method to get
			->setSignatureToHmacSha1()					//set method to HMAC-SHA1
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * GET, HMAC-SHA1, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getHmacGetAuthorizationAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()						//use authorization header
			->setMethodToGet()							//set method to get
			->setSignatureToHmacSha1()					//set method to HMAC-SHA1
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * GET, HMAC-SHA1, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getHmacGetAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()		//use authorization header
			->setMethodToGet()			//set method to get
			->setSignatureToHmacSha1()	//set method to HMAC-SHA1
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * GET, HMAC-SHA1
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getHmacGetRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToGet()			//set method to get
			->setSignatureToHmacSha1()	//set method to HMAC-SHA1
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * POST, HMAC-SHA1
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getHmacPostAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToPost()							//set method to post
			->setSignatureToHmacSha1()					//set method to HMAC-SHA1
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * POST, HMAC-SHA1, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getHmacPostAuthorizationAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()						//use authorization header
			->setMethodToPost()							//set method to post
			->setSignatureToHmacSha1()					//set method to HMAC-SHA1
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * POST, HMAC-SHA1, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getHmacPostAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()		//use authorization header
			->setMethodToPost()			//set method to post
			->setSignatureToHmacSha1()	//set method to HMAC-SHA1
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * POST, HMAC-SHA1
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getHmacPostRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToPost()			//set method to post
			->setSignatureToHmacSha1()	//set method to HMAC-SHA1
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * GET, PLAINTEXT
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getPlainGetAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToGet()							//set method to get
			->setSignatureToPlainText()					//set method to PLAIN TEXT
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * GET, PLAINTEXT, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getPlainGetAuthorizationAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()						//use authorization header
			->setMethodToGet()							//set method to get
			->setSignatureToPlainText()					//set method to PLAIN TEXT
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * GET, PLAINTEXT, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getPlainGetAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()		//use authorization header
			->setMethodToGet()			//set method to get
			->setSignatureToPlainText()	//set method to PLAIN TEXT
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * GET, PLAINTEXT
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getPlainGetRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToGet()			//set method to get
			->setSignatureToPlainText()	//set method to PLAIN TEXT
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * POST, PLAINTEXT
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getPlainPostAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToPost()							//set method to post
			->setSignatureToPlainText()					//set method to PLAIN TEXT
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns an access token given the requiremets
	 * POST, PLAINTEXT, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param string token
	 * @param string token secret
	 * @param array extra query
	 * @param string|null realm
	 * @param string|null verifier
	 * @return string access token
	 */
	public function getPlainPostAuthorizationAccessToken($url, $key, $secret, $token, 
		$tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string')				//Argument 4 must be a string
			->argument(5, 'string')				//Argument 5 must be a string
			->argument(7, 'string', 'null')		//Argument 7 must be a string or null
			->argument(8, 'string', 'null');	//Argument 8 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()						//use authorization header
			->setMethodToPost()							//set method to post
			->setSignatureToPlainText()					//set method to PLAIN TEXT
			->when($realm)								//when there is a realm
			->setRealm($realm)							//set the realm
			->endWhen()									//return back the consumer
			->when($verifier)							//when there is a verifier
			->setVerifier($verifier)					//set the verifier
			->endWhen()									//return back the consumer
			->setRequestToken($token, $tokenSecret)		//set the request token
			->getToken($query);							//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * POST, PLAINTEXT, use Authorization Header
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getPlainPostAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->useAuthorization()		//use authorization header
			->setMethodToPost()			//set method to post
			->setSignatureToPlainText()	//set method to PLAIN TEXT
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns a request token given the requiremets
	 * POST, PLAINTEXT
	 * 
	 * @param string url
	 * @param string cnsumer key
	 * @param string consumer secret
	 * @param array extra query
	 * @param string|null realm
	 * @return string request token
	 */
	public function getPlainPostRequestToken($url, $key, $secret, array $query = array(), $realm = NULL) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(5, 'string', 'null');	//Argument 5 must be a string or null
			
		return $this->consumer($url, $key, $secret)
			->setMethodToPost()			//set method to post
			->setSignatureToPlainText()	//set method to PLAIN TEXT
			->when($realm)				//when there is a realm
			->setRealm($realm)			//set the realm
			->endWhen()					//return back the consumer
			->getToken($query);			//get the token
	}
	
	/**
	 * Returns the oauth server class
	 * 
	 * @return Eden_Oauth_Server
	 */
	public function server() {
		return Eden_Oauth_Server::i();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}