<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon Simple Notification Service (SNS)
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Amazon_Sns extends Eden_Class { 
	/* Constants
	-------------------------------*/
	const AMAZON_SNS_URL	= 'http://sns.us-east-1.amazonaws.com/';
	const AMAZON_SNS_HOST	= 'sns.us-east-1.amazonaws.com';

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
	protected $_query = array();
	
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
	 * The AddPermission action adds a statement to a topic's access control policy, 
	 * granting access for the specified AWS accounts to the specified actions.
	 *
	 * @param string The ARN of the topic whose access control policy you wish to modify.
	 * @param string A unique identifier for the new policy statement.
	 * @param array
	 * @return array
	 */
	public function addPermission($topic, $label, $permissions) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'array');		//argument 3 must be a array
		
		$this->_query['Action'] 	= 'AddPermission';
		$this->_query['TopicArn'] 	= $topic;
		$this->_query['Label'] 		= $label;
		
		$memberFlatArray 		= array();
		$permissionFlatArray 	= array();
		
		foreach($permissions as $member => $permission) {
			$memberFlatArray[]		= $member;
			$permissionFlatArray[]	= $permission;
		}
		
		for($x = 0; $x <= count($memberFlatArray); $x++){
			
			if(isset($memberFlatArray[$x], $permissionFlatArray[$x])) {
				//prevent sending 0 value
				$y = $x + 1;
				$this->_query['ActionName.member.'.$y] = $memberFlatArray[$x];
				$this->_query['AWSAccountID.member.'.$y] = $permissionFlatArray[$x];
			}
		} 
	
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The ConfirmSubscription action verifies an endpoint owner's intent to receive 
	 * messages by validating the token sent to the endpoint by an earlier Subscribe action. 
	 *
	 * @param string Short-lived token sent to an endpoint during the Subscribe action.
	 * @param string The ARN of the topic for which you wish to confirm a subscription.
	 * @return array
	 */
	public function confirmSubscription($token, $topicArn) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'ConfirmSubscription';
		$this->_query['Token'] 		= $token;
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The CreateTopic action creates a topic to which notifications can be published. 
	 * Users can create at most 100 topics 
	 *
	 * @param string The name of the topic you want to create.
	 * @return array
	 */
	public function createTopic($name) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']	= 'CreateTopic';
		$this->_query['Name'] 	= $name;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The DeleteTopic action deletes a topic and all its subscriptions
	 *
	 * @param string The ARN of the topic you want to delete
	 * @return array
	 */
	public function deleteTopic($topicArn) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']		= 'DeleteTopic';
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The GetSubscriptionAttribtues action returns all of the properties of a subscription.
	 *
	 * @param string The ARN of the subscription whose properties you want to get
	 * @return array
	 */
	public function getSubscriptionAttributes($subscriptionArn) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']				= 'GetSubscriptionAttributes';
		$this->_query['SubscriptionArn'] 	= $subscriptionArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The GetTopicAttributes action returns all of the properties of a topic
	 *
	 * @param string The ARN of the topic whose properties you want to get
	 * @return array
	 */
	public function getTopicAttributes($topicArn) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']		= 'GetTopicAttributes';
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The ListSubscriptions action returns a list of the requester's subscriptions. 
	 * Each call returns a limited list of subscriptions, up to 100
	 *
	 * @return array
	 */
	public function listSubscriptions() {	
		
		$this->_query['Action']	= 'ListSubscriptions';
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The ListSubscriptionsByTopic action returns a list of the subscriptions to a specific topic
	 *
	 * @param string The ARN of the topic for which you wish to find subscriptions.
	 * @return array
	 */
	public function listSubscriptionsByTopic($topicArn) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']		= 'ListSubscriptionsByTopic';
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The ListTopics action returns a list of the requester's topics
	 * Each call returns a limited list of subscriptions, up to 100
	 *
	 * @return array
	 */
	public function listTopics() {	
		
		$this->_query['Action']	= 'ListTopics';
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The ConfirmSubscription action verifies an endpoint owner's intent to receive 
	 * messages by validating the token sent to the endpoint by an earlier Subscribe action. 
	 *
	 * @param string The message you want to send to the topic.
	 * @param string The topic you want to publish to.
	 * @param string|null Optional parameter to be used as the "Subject" line of when the
	 * message is delivered to e-mail endpoints
	 * @return array
	 */
	public function publish($message, $topicArn, $subject = NULL) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'string')				//argument 2 must be a string
			->argument(3, 'string', 'null');	//argument 3 must be a string or null
		
		$this->_query['Action'] 	= 'Publish';
		$this->_query['Message'] 	= $message;
		$this->_query['TopicArn'] 	= $topicArn;
		$this->_query['Subject'] 	= $subject;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The RemovePermission action removes a statement from a topic's access control policy.
	 *
	 * @param string The unique label of the statement you want to remove.
	 * @param string The ARN of the topic whose access control policy you wish to modify
	 * @return array
	 */
	public function removePermission($label, $topicArn) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'RemovePermission';
		$this->_query['Label'] 		= $label;
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The SetSubscriptionAttributes action allows a subscription owner to set an attribute of the topic to a new value.
	 *
	 * @param string The name of the attribute you want to set.
	 * @param string The new value for the attribute in JSON format.
	 * @param string The ARN of the subscription to modify.
	 * @return array
	 */
	public function setSubscriptionAttributes($attributeName, $attributeValue, $subscriptionArn) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 			= 'SetSubscriptionAttributes';
		$this->_query['AttributeName'] 		= $attributeName;
		$this->_query['AttributeValue'] 	= $attributeValue;
		$this->_query['SubscriptionArn'] 	= $subscriptionArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The SetTopicAttributes action allows a topic owner to set an attribute of the topic to a new value.
	 *
	 * @param string The name of the attribute you want to set. Valid values: Policy | DisplayName | DeliveryPolicy
	 * @param string The new value for the attribute.
	 * @param string The ARN of the topic to modify.
	 * @return array
	 */
	public function setTopicAttributes($attributeName, $attributeValue, $topicArn) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 			= 'SetTopicAttributes';
		$this->_query['AttributeName'] 		= $attributeName;
		$this->_query['AttributeValue'] 	= $attributeValue;
		$this->_query['TopicArn'] 			= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The Subscribe action prepares to subscribe an endpoint by sending the endpoint a confirmation message
	 *
	 * @param string The endpoint that you want to receive notifications
	 * @param string The protocol you want to use
	 * @param string The ARN of topic you want to subscribe to.
	 * @return array
	 */
	public function subscribe($endpoint, $protocol, $topicArn) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 	= 'Subscribe';
		$this->_query['Endpoint'] 	= $endpoint;
		$this->_query['Protocol'] 	= $protocol;
		$this->_query['TopicArn'] 	= $topicArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * The Unsubscribe action deletes a subscription
	 *
	 * @param string The ARN of the subscription to be deleted
	 * @return array
	 */
	public function unsubscribe($subscriptionArn) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']				= 'Unsubscribe';
		$this->_query['SubscriptionArn'] 	= $subscriptionArn;
		
		return $this->_getResponse(self::AMAZON_SNS_HOST, $this->_query);
	}
	
	/**
	 * Token returned by the previous ListSubscriptionsByTopic request.
	 *
	 * @param string
	 * @return array
	 */
	public function setNextToken($nextToken) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['NextToken']	= $nextToken;
		
		return $this;
	}
	
	/**
	 * The ConfirmSubscription action verifies an endpoint owner's intent to receive
	 * messages by validating the token sent to the endpoint by an earlier Subscribe action
	 *
	 * @param string
	 * @return array
	 */
	public function setAuthenticateOnUnsubscribe($authenticateOnUnsubscribe) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['AuthenticateOnUnsubscribe']	= $authenticateOnUnsubscribe;
		
		return $this;
	}
	
	/**
	 * Set MessageStructure to json if you want to send a different message for each protocol
	 *
	 * @param string
	 * @return array
	 */
	public function setMessageStructure($messageStructure) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['MessageStructure']	= $messageStructure;
		
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
	
	/* Protected Methods
	-------------------------------*/
	protected function _isXml($xml) {
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
						$name =  $keyValue[0].'.'.$k.'.'.$keyValue[1];
					} else {
						$name =  $keyValue[0].'.'.$k;
					}
					//put key key name with k integer if they set multiple value
					$query[str_replace("%7E", "~", $name)] = str_replace("%7E", "~", $v);
				}
			//else it is a simple array only	
			} else {
				//format array to query
				$query[str_replace("%7E", "~", $key)] = str_replace("%7E", "~", $value);
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
		$query[self::TIMESTAMP] 		= gmdate('Y-m-d\TH:i:s\Z');;
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
		if($this->_isXml($response)){
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
