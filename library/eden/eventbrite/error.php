<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite Errors
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Error extends Eden_Error {
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
	protected function _isValid($type, $data) {
		if($type == 'gmt') {
			return preg_match('/^GMT(\-|\+)[0-9]{2,4}$/', $data); 
		}
		
		return parent::_isValid($type, $data);
	}
	
	/* Private Methods
	-------------------------------*/
}