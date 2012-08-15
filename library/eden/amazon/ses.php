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
	/**
	 * Set identity
	 * 
	 * @param string
	 * @return this
	 */
	public function setIdentity($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Identity'] = $identity;
		
		return $this;
	}
	
	/**
	 * Add identity
	 * 
	 * @param string
	 * @return this
	 */
	public function addIdentity($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Identities.member']
			[isset($this->_params['Identities.member']) ? count($this->_params['Identities.member'])+1 : 1] = $identity;
		
		return $this;
	}
	
	/**
	 * Set email address
	 * 
	 * @param email
	 * @return this
	 */
	public function setEmailAddress($email) {
		//argument 1 must be a email
		Eden_Amazon_Error::i()->argument(1, 'email');
		$this->_params['EmailAddress'] = $email;
		
		return $this;
	}
	
	/**
	 * SThe type of the identities to list. Possible values are 
	 * "EmailAddress" and "Domain". If this parameter is omitted, 
	 * then all identities will be listed.
	 * Valid Values: EmailAddress | Domain
	 * 
	 * @param string
	 * @return this
	 */
	public function setIdentityType($type) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['IdentityType'] = $type;
		
		return $this;
	}
	
	/**
	 * The maximum number of identities per page. 
	 * Possible values are 1-100 inclusive.
	 * 
	 * @param string|integer
	 * @return this
	 */
	public function setMaxResult($max) {
		//argument 1 must be a string or integer
		Eden_Amazon_Error::i()->argument(1, 'string', 'int');
		$this->_params['MaxItems'] = $max;
		
		return $this;
	}
	
	/**
	 * Set max rate
	 * 
	 * @param string
	 * @return this
	 */
	public function setMaxRate($max) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['MaxItems'] = $max;
		
		return $this;
	}
	
	/**
	 * The token to use for pagination.
	 * 
	 * @param string
	 * @return this
	 */
	public function setNextToken($token) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['NextToken'] = $token;
		
		return $this;
	}
	
	/**
	 * A list of destinations for the message.
	 * 
	 * @param string
	 * @return this
	 */
	public function addTo($to) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.ToAddresses.member']
			[isset($this->_params['Destination.ToAddresses.member']) ? count($this->_params['Destination.ToAddresses.member']) + 1 : 1] = $to;
		
		return $this;
	}
	
	/**
	 * Add CC
	 * 
	 * @param string
	 * @return this
	 */
	public function addCc($cc) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.CcAddresses.member']
			[isset($this->_params['Destination.CcAddresses.member']) ? count($this->_params['Destination.CcAddresses.member']) + 1 : 1] = $cc;
		
		return $this;
	}
	
	/**
	 * Add BCC
	 * 
	 * @param string
	 * @return this
	 */
	public function addBcc($bcc) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Destination.BccAddresses.member']
			[isset($this->_params['Destination.BccAddresses.member']) ? count($this->_params['Destination.BccAddresses.member']) + 1 : 1] = $bcc;
		
		return $this;
	}
	
	/**
	 * Set email subject
	 * 
	 * @param string
	 * @param boolean
	 * @return this
	 */
	public function setSubject($subject, $charset = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
			
		$data = ($charset) ? 'Data.Charset' : 'Data';
		$this->_params['Message.Subject.'.$data] = $subject;
		
		return $this;
	}
	
	/**
	 * Set email body
	 * 
	 * @param string
	 * @param boolean
	 * @param boolean
	 * @return this
	 */
	public function setBody($body, $html = false, $charset = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'bool')		//argument 1 must be a boolean
			->argument(3, 'bool');		//argument 1 must be a boolean
		
		//if html is true,
		//set type as 'html' else set type as 'text'
		$type = ($html) ? 'Html' : 'Text';
		//if charset is true, 
		//set data as 'charset' else set data as 'data'
		$data = ($charset) ? 'Charset' : 'Data';
		//set parameters
		$this->_params['Message.Body.'.$type.'.'.$data] = $body;
		
		return $this;
	}
	
	/**
	 * Set email that will reply
	 * 
	 * @param email
	 * @return this
	 */
	public function addReplyTo($email) {
		//argument 1 must be a email
		Eden_Amazon_Error::i()->argument(1, 'email');
		
		//if email is set, count it as one else if they add another email, increament count
		$this->_params['ReplyToAddresses.member']
			[isset($this->_params['ReplyToAddresses.member']) ? count($this->_params['ReplyToAddresses.member']) + 1 : 1] = $email;
			
		return $this;
	}
	
	/**
	 * Set return path
	 * 
	 * @param string
	 * @return this
	 */
	public function setReturnPath($path) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['ReturnPath'] = $path;
		
		return $this;
	}
	
	/**
	 * Set source email
	 * 
	 * @param email
	 * @return this
	 */
	public function setSource($email) {
		//argument 1 must be a email
		Eden_Amazon_Error::i()->argument(1, 'email');
		$this->_params['Source'] = $email;
		
		return $this;
	}
	
	/**
	 * Set destination
	 * 
	 * @param email
	 * @return this
	 */
	public function addDestination($destination) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		//destination is set, destinations.member equals count destination as one 
		//else if they add destination.member again, destination.member equals increament distination
		$this->_params['Destinations.member']
			[isset($this->_params['Destinations.member']) ? count($this->_params['Destinations.member']) + 1 : 1] = $destination;
		
		return $this;
	}
	
	/**
	 * Set message text
	 * 
	 * @param string
	 * @return this
	 */
	public function setRawMsg($msg) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['RawMessage.Data'] = $msg;
		
		return $this;
	}
	
	/**
	 * Sets whether DKIM signing is enabled for an identity. Set 
	 * to true to enable DKIM signing for this identity; false to disable it.
	 * 
	 * @param boolean
	 * @return this
	 */
	public function setDkim($dkim) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		$this->_params['DkimEnabled'] = $dkim;
		
		return $this;
		
	}
	
	/**
	 * Sets whether Amazon SES will forward feedback notifications 
	 * as email. true specifies that Amazon SES will forward feedback 
	 * notifications as email, in addition to any Amazon SNS topic publishing 
	 * otherwise specified. false specifies that Amazon SES will publish feedback 
	 * notifications only through Amazon SNS. This value can only be set to false 
	 * when topics are specified for both Bounce and Complaint topic types.
	 * 
	 * @param boolean
	 * @return this
	 */
	public function setForwarding($forward) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		$this->_params['ForwardingEnabled'] = $forward;
		
		return $this;
	}
	
	/**
	 * The type of feedback notifications that will be published to the specified topic.
	 * Valid Values: Bounce | Complaint
	 * 
	 * @param string
	 * @return this
	 */
	public function setNotificationType($type) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['NotificationType'] = $type;
		
		return $this;
	}
	
	/**
	 * The Amazon Resource Name (ARN) of the Amazon Simple Notification Service 
	 * (Amazon SNS) topic. If the parameter is ommited from the request or a 
	 * null value is passed, the topic is cleared and publishing is disabled.
	 * 
	 * @param string
	 * @return this
	 */
	public function setTopic($sns) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['SnsTopic'] = $sns;
		
		return $this;
	}
	
	/**
	 * The name of the domain to be verified for Easy DKIM signing
	 * 
	 * @param string
	 * @return this
	 */
	public function setDomain($domain) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Domain'] = $domain;
		
		return $this;
		
	}
	
	/*
	 * Deletes the specified identity (email address or domain) from the list of verified identities.
	 * parameters  
	 * 		
	 * @param string
	 * @return array
	 */
	public function deleteIdentity($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		//set parameter
		$this->_params['Action']	= 'DeleteIdentity';
		$this->_params['Identity']	= $identity;
		
		return $this->_getResponse();
	}
	
	/*
	 * Deletes the specified email address from the list of verified addresses.
	 * parameters
	 *
	 * @param string
	 * @return array
	 */
	public function deleteVerifiedEmail($email) {
		//argument 1 must be a email
		Eden_Amazon_Error::i()->argument(1, 'email');
		
		//set parameters
		$this->_params['Action']		= 'DeleteVerifiedEmailAddress';
		$this->_params['EmailAddress']	= $email;
		
		return $this->_getResponse();
	}
	
	/*
	 * Returns the DNS records, or tokens, that must be present 
	 * in order for Easy DKIM to sign outgoing email messages.
	 * parameters 
	 *
	 * @param string
	 * @return array
	 */
	public function getIdentityDetail($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		//set parameters
		$this->_params['Action'] = 'GetIdentityDkimAttributes';
		$this->_params['Identities.member']
			[isset($this->_params['Identities.member']) ? count($this->_params['Identities.member'])+1 : 1] = $identity;
		
		return $this->_getResponse();
	}
	
	/*
	 * Given a list of verified identities (email addresses and/or domains), 
	 * returns a structure describing identity notification attributes.
	 * parameters
	 *
	 * @param string
	 * @return array
	 */
	public function getNotifications($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		//set parameters
		$this->_params['Action'] = 'GetIdentityNotificationAttributes';
		$this->_params['Identities.member']
			[isset($this->_params['Identities.member']) ? count($this->_params['Identities.member'])+1 : 1] = $identity;
			
		return $this->_getResponse();
	}
	
	/*
	 * Given a list of identities (email addresses and/or domains), 
	 * returns the verification status and (for domain identities) 
	 * the verification token for each identity.
	 * parameters
	 * 		
	 * @param string
	 * @return
	 */
	public function getVerificationAttributes($identity) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		//set parameters
		$this->_params['Action'] = 'GetIdentityVerificationAttributes';
		$this->_params['Identities.member']
			[isset($this->_params['Identities.member']) ? count($this->_params['Identities.member'])+1 : 1] = $identity;
		return $this->_getResponse();
	}
	
	/*
	 * Returns the user's current sending limits.
	 * parameters
	 *
	 * @return array
	 */
	public function getQuota() {
		//set parameters
		$this->_params['Action']			= 'GetSendQuota';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
		return $this->_getResponse();
	}
	
	/*
	 * Returns the user's sending statistics. The result is a list of data points, 
	 * representing the last two weeks of sending activity.
	 * parameters
	 *
	 * @return array
	 */
	public function getStatistics() {
		//set parameters
		$this->_params['Action']			= 'GetSendStatistics';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
		return $this->_getResponse();
	}
	
	/*
	 * Returns a list containing all of the identities (email addresses and domains) 
	 * for a specific AWS Account, regardless of verification status.
	 * parameters
	 *
	 * @return array
	 */
	public function getIdentities() {
		//set parameter
		$this->_params['Action']			= 'ListIdentities';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
		return $this->_getResponse();
	}
	
	/*
	 * Returns a list containing all of the email addresses that have been verified.
	 * parameters
	 *
	 * @return array
	 */
	public function getVerifiedEmails() {
		//set parameters
		$this->_params['Action']			= 'ListVerifiedEmailAddresses';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
		return $this->_getResponse();
		
	}
	
	/*
	 * Composes an email message based on input data, and then immediately queues the message for sending.
	 * parameters
	 *		Destination
	 *			BccAddresses	- addBcc()			~ optional
	 *			CcAddresses		- addCc()			~ optional
	 *				ToAddresses		- addTo()			~ required
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
		//set parameters
		$this->_params['Action']			= 'SendEmail';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
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
		$this->_params['Action'] 			= 'SendRawEmail';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
		
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
		$this->_params['Action']			= 'SetIdentityDkimEnabled';
		$this->_params['AWSAccessKeyId']	= $this->_publicKey;
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
		$this->_params['Action'] 		 = 'SetIdentityFeedbackForwardingEnabled';
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
		$this->_params['Action'] 		 = 'SetIdentityNotificationTopic';
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
		$this->_params['Action'] 		= 'VerifyDomainDkim';
		$this->_params['AWSAccessKeyId' = $this->_publicKey;
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
		$this->_params['Action']		 = 'VerifyDomainIdentity';
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
		$this->_params['Action'] 		 = 'VerifyEmailAddress';
		
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
		$this->_params['Action'] 		 = 'VerifyEmailIdentity';
		
		return $this->_getResponse();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
