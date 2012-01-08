<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite Errors
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: exception.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Tumblr_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const TITLE_NOT_SET = 'You tried to set an event without setting a title. Call setTitle() before send()';
	const START_NOT_SET = 'You tried to set an event without setting a start date. Call setStart() before send()';
	const END_NOT_SET 	= 'You tried to set an event without setting an end date. Call setEnd() before send()';
	const ZONE_NOT_SET 	= 'You tried to set an event without setting a timezone. Call setTimezone() before send()';
	
	const PRIVACY_NOT_SET 	= 'You tried to set an event without setting the privacy. Call setPublic() or setPrivate() before send()';
	const URL_NOT_SET 		= 'You tried to set an event without setting a personal url. Call setUrl() before send()';
	const ORGANIZER_NOT_SET = 'You tried to set an event without setting an orgaizer. Call setOrganizer() before send()';
	const VENUE_NOT_SET 	= 'You tried to set an event without setting a venue. Call setVenue() before send()';
	const CAPACITY_NOT_SET 	= 'You tried to set an event without setting the capacity. Call setCapacity() before send()';
	const CURRENCY_NOT_SET 	= 'You tried to set an event without setting a currency. Call setCurrency() before send()';
	const INVALID_PASSWORD	= 'Password must be 4 characters or greater!';
	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}