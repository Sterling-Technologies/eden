<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Mail exception
 *
 * @package    Eden
 * @category   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const SERVER_ERROR 		= 'Problem connecting to %s . Check server, port or ssl settings for your email server.';
	const LOGIN_ERROR 		= 'Your email provider has rejected your login information. Verify your email and/or password is correct.';
	const TLS_ERROR			= 'Problem connecting to %s with TLS on.';
	const SMTP_ADD_EMAIL 	= 'Adding %s to email failed.'; 
	const SMTP_DATA 		= 'Server did not allow data to be added.'; 
	
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