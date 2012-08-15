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
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Amazon_Ses extends Eden_Amazon_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_host = 'email.us-east-1.amazonaws.com';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	public function setIdentity($identity) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Identity'] = $identity;
		
		return $this;
	}
	
	public function addIdentity($identity) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Identities.member'][isset($this->_params['Identities.member']) ? count($this->_params['Identities.member'])+1 : 1] = $identity;
		
		return $this;
	}
	
	public function setEmailAddress($email) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['EmailAddress'] = $email;
		
		return $this;
	}
	
	public function setIdentityType($type) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['IdentityType'] = $type;
		return $this;
	}
	
	public function setMaxResult($max) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['MaxItems'] = $max;
		return $this;
	}
	
	public function setMaxRate($max) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['MaxItems'] = $max;
		return $this;
	}
	
	public function setNextToken($token) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['NextToken'] = $token;
		return $this;
	}
	
	public function addTo($to) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.ToAddresses.member'][isset($this->_params['Destination.ToAddresses.member']) ? count($this->_params['Destination.ToAddresses.member']) + 1 : 1] = $to;
		return $this;
	}
	
	public function addCc($cc) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.CcAddresses.member'][isset($this->_params['Destination.CcAddresses.member']) ? count($this->_params['Destination.CcAddresses.member']) + 1 : 1] = $cc;
		return $this;
	}
	
	public function addBcc($bcc) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.BccAddresses.member'][isset($this->_params['Destination.BccAddresses.member']) ? count($this->_params['Destination.BccAddresses.member']) + 1 : 1] = $bcc;
		return $this;
	}
	
	public function setSubject($subject, $charset = false) {
		Eden_Amazon_Error::i()->argument(1, 'string')
			->argument(2, 'bool');
			
		$data = ($charset) ? 'Data.Charset' : 'Data';
		$this->_params['Message.Subject.'.$data] = $subject;
		return $this;
	}
	
	public function setBody($body, $html = false, $charset = false) {
		Eden_Amazon_Error::i()->argument(1, 'string')
			->argument(2, 'bool')
			->argument(3, 'bool');
		
		$type = ($html) ? 'Html' : 'Text';
		$data = ($charset) ? 'Charset' : 'Data';
		$this->_params['Message.Body.'.$type.'.'.$data] = $body;
		return $this;
	}
	
	public function addReplyTo($replyTo) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['ReplyToAddresses.member'][isset($this->_params['ReplyToAddresses.member']) ? count($this->_params['ReplyToAddresses.member']) + 1 : 1] = $replyTo;
		return $this;
	}
	
	public function setReturnPath($path) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['ReturnPath'] = $path;
		return $this;
	}
	
	public function setSource($email) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Source'] = $email;
		return $this;
	}
	
	public function addDestination($destination) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destinations.member'][isset($this->_params['Destinations.member']) ? count($this->_params['Destinations.member']) + 1 : 1] = $destination;
		return $this;
	}
	
	public function setRawMsg($msg) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['RawMessage.Data'] = $msg;
		return $this;
	}
	
	public function setDkim($dkim) {
		Eden_Amazon_Error::i()->argument(1, 'bool');
		$this->_params['DkimEnabled'] = $dkim;
		return $this;
		
	}
	
	public function setForwarding($forward) {
		Eden_Amazon_Error::i()->argument(1, 'bool');
		$this->_params['ForwardingEnabled'] = $forward;
		return $this;
	}
	
	public function setNotificationType($type) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['NotificationType'] = $type;
		return $this;
	}
	
	public function setTopic($sns) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['SnsTopic'] = $sns;
		return $this;
	}
	
	public function setDomain($domain) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Domain'] = $domain;
		return $this;
		
	}
	
	/*
	 * Deletes the specified identity (email address or domain) from the list of verified identities.
	 * parameters  
	 * 		Identity - setIdentity() ~ required
	 *
	 * @return
	 */
	public function deleteIdentity() {
		//set action parameter
		$this->_params['Action'] = 'DeleteIdentity';
		return $this->_getResponse();
	}
	
	/*
	 * Deletes the specified email address from the list of verified addresses.
	 * parameters
	 * 		EmailAddress - setEmailAddress() ~ required
	 *
	 * @return
	 */
	public function deleteVerifiedEmail() {
		$this->_params['Action'] = 'DeleteVerifiedEmailAddress';
		return $this->_getResponse();
	}
	
	/*
	 * Returns the DNS records, or tokens, that must be present 
	 * in order for Easy DKIM to sign outgoing email messages.
	 * parameters 
	 * 		Identities.member.N - addIdentity() ~ required
	 *
	 * @return
	 */
	public function getIdentityDetail() {
		$this->_params['Action'] = 'GetIdentityDkimAttributes';
		return $this->_getResponse();
	}
	
	/*
	 * Given a list of verified identities (email addresses and/or domains), 
	 * returns a structure describing identity notification attributes.
	 * parameters
	 * 		Identities.member.N - addIdentity() ~ required
	 *
	 * @return
	 */
	public function getNotifications() {
		$this->_params['Action'] = 'GetIdentityNotificationAttributes';
		return $this->_getResponse();
	}
	
	/*
	 * Given a list of identities (email addresses and/or domains), 
	 * returns the verification status and (for domain identities) 
	 * the verification token for each identity.
	 * parameters
	 * 		Identities.member.N - addIdentity() ~ required
	 *
	 * @return
	 */
	public function getVerificationAttributes() {
		$this->_params['Action'] = 'GetIdentityVerificationAttributes';
		return $this->_getResponse();
	}
	
	/*
	 * Returns the user's current sending limits.
	 * parameters
	 * 		NONE
	 *
	 * @return
	 */
	public function getQuota() {
		$this->_params['Action'] = 'GetSendQuota';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
	}
	
	/*
	 * Returns the user's sending statistics. The result is a list of data points, 
	 * representing the last two weeks of sending activity.
	 * parameters
	 * 		NONE
	 *
	 * @return
	 */
	public function getStatistics() {
		$this->_params['Action'] = 'GetSendStatistics';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
	}
	
	/*
	 * Returns a list containing all of the identities (email addresses and domains) 
	 * for a specific AWS Account, regardless of verification status.
	 * parameters
	 * 		IdentityType 	- setIdentityType	~ optional
	 *		MaxItems		- setMaxResults		~ optional
	 *		NextToken		- setNextToken		~ optional
	 *
	 * @return
	 */
	public function getIdentities() {
		$this->_params['Action'] = 'ListIdentities';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Returns a list containing all of the email addresses that have been verified.
	 * parameters
	 * 		NONE
	 *
	 * @return
	 */
	public function getVerifiedEmails() {
		$this->_params['Action'] = 'ListVerifiedEmailAddresses';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Composes an email message based on input data, and then immediately queues the message for sending.
	 * parameters
	 *		Destination
	 *			BccAddresses	- addBcc()			~ optional
	 *			CcAddresses		- addCc()			~ optional
	 *			ToAddresses		- addTo()			~ required
	 *		Message
	 *			Body			- setBody()			~ required
	 *			Subject			- setSubject()		~ required
	 *		ReplyToAddresses	- addReplyTo		~ optional
	 *		ReturnPath			- setReturnpath()	~ optional
	 *		Source				- setSource()			~ required
	 *
	 * @return
	 */
	public function send() {
		$this->_params['Action'] = 'SendEmail';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		
		return $this->_getResponse();
	}
	
	/*
	 * Sends an email message, with header and content specified by the client. The SendRawEmail action 
	 * is useful for sending multipart MIME emails. The raw text of the message must comply with Internet 
	 * email standards; otherwise, the message cannot be sent.
	 * parameters
	 * 		Destinations.member		- addDestination()	~ optional
	 * 		RawMessage				- setRawMsg()		~ required
	 *		Source					- setSource()		~ optional
	 *
	 * @return
	 */
	public function sendRawMail() {
		$this->_params['Action'] = 'SendRawEmail';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		
		return $this->_getResponse();
	}
	
	/*
	 * Enables or disables Easy DKIM signing of email sent from an identity
	 * parameters
	 * 		DkimEnabled - setDkim() 	~ required
	 *		Identity	- setIdentity() ~ required
	 *
	 * @return
	 */
	public function setDkimIdentity(){
		$this->_params['Action'] = 'SetIdentityDkimEnabled';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Given an identity (email address or domain), enables or disables whether 
	 * Amazon SES forwards feedback notifications as email. Feedback forwarding 
	 * may only be disabled when both complaint and bounce topics are set.
	 * parameters
	 * 		DkimEnabled - setForwarding() 	~ required
	 *		Identity	- setIdentity()		~ required
	 *
	 * @return
	 */
	public function setIdentityForwarding(){
		$this->_params['Action'] = 'SetIdentityFeedbackForwardingEnabled';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Given an identity (email address or domain), sets the Amazon SNS topic to which 
	 * Amazon SES will publish bounce and complaint notifications for emails sent with 
	 * that identity as the Source. Publishing to topics may only be disabled when feedback 
	 * forwarding is enabled.
	 * parameters
	 *		Identity			- setIdentity()			~ required
	 *		NotificationType	- setNotificationType()	~ required = Bounce | Complaint
	 *		SnsTopic			- setTopic()			~ optional
	 *
	 * @return
	 */
	public function setNotificationTopic(){
		$this->_params['Action'] = 'SetIdentityNotificationTopic';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Returns a set of DNS records, or tokens, that must be published in the domain name's 
	 * DNS to complete the DKIM verification process. These tokens are DNS CNAME records that 
	 * point to DKIM public keys hosted by Amazon SES. To complete the DKIM verification process, 
	 * these tokens must be published in the domain's DNS. The tokens must remain published in 
	 * order for Easy DKIM signing to function correctly.
	 * parameters
	 *		Domain - setDomain() ~ required
	 *
	 * @return
	 */
	public function verifyDomainDkim(){
		$this->_params['Action'] = 'VerifyDomainDkim';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Verifies a domain.
	 * parameters
	 *		Domain - setDomain() ~ required
	 *
	 * @return
	 */
	public function verifyDomainIdentity(){
		$this->_params['Action'] = 'VerifyDomainIdentity';
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		return $this->_getResponse();
		
	}
	
	/*
	 * Verifies an email address. This action causes a confirmation 
	 * email message to be sent to the specified address.
	 * parameters
	 *		EmailAddress - setEmailAddress() ~ required
	 *
	 * @return
	 */
	public function verifyEmail() {
		//set action parameters
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		$this->_params['Action'] = 'VerifyEmailAddress';
		return $this->_getResponse();
	}
	
	/*
	 * Verifies an email address. This action causes a confirmation
	 * email message to be sent to the specified address.
	 * parameters
	 *		EmailAddress - setEmailAddress() ~ required
	 *
	 * @return
	 */
	public function verifyEmailIdentity() {
		//set action parameters
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		$this->_params['Action'] = 'VerifyEmailIdentity';
		return $this->_getResponse();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setSignature($date) {
		//encode signature using HmacSHA256
		$this->_signature = base64_encode(hash_hmac('sha256', $date, $this->_privateKey, true));
		return $this;
	}
	
	protected function _getResponse() {
		//each params
		foreach ($this->_params as $param => $value) {
			//this is my custom url encode
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$canonicalizedQuery[] = str_replace("%7E", "~", rawurlencode($param.'.'.$k)).'='.str_replace("%7E", "~", rawurlencode($v));
				}
				
			} else {
				$canonicalizedQuery[] = str_replace("%7E", "~", rawurlencode($param)).'='.str_replace("%7E", "~", rawurlencode($value));
			}
		}
		
		//sort parameter query
		sort($canonicalizedQuery, SORT_STRING);
		$date = gmdate('D, d M Y H:i:s e');
		//implode it to make a string of query
		$this->_canonicalizedQuery = implode("&", $canonicalizedQuery);
		//set signature
		$this->_setSignature($date);
		$query = $this->_canonicalizedQuery;
		//auth is the authentication string. we'll use that on the header of our curl request
		$auth = 'AWS3-HTTPS AWSAccessKeyId='.$this->_publicKey;
		$auth .= ',Algorithm=HmacSHA256,Signature='.$this->_signature;
		
		//assigning header variables including the authentication string
		$headers = array('X-Amzn-Authorization: '.$auth, 'Date: '.$date, 'Host: '.$this->_host);
		
		//send post request
		return $this->_postRequest($query, $headers);
	}
	
	/* Private Methods
	-------------------------------*/
}
