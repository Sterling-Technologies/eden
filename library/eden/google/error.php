<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Errors
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const INVALID_ROLE			= 'Argument 2 was expecting owner, reader, writer. %s was given';
	const INVALID_TYPE			= 'Argument 3 was expecting user, group, domain, anyone. %s was given';
	const INVALID_COLLECTION	= 'Argument 2 was expecting plusoners, resharers. %s was given';
	const INVALID_FEEDS_TWO		= 'Argument 2 was expecting most_viewed, most_subscribed. %s was given';
	const INVALID_FEEDS_ONE		= 'Argument 1 was expecting most_viewed, most_subscribed. %s was given';
	const INVALID_STATUS		= 'Argument 2 was expecting accepted, rejected. %s was given';
	
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