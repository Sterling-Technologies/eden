<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Facebook Errors
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const AUTHENTICATION_FAILED = 'Application authentication failed. Facebook returned %s: %s';
	const GRAPH_FAILED 			= 'Call to graph.facebook.com failed. Facebook returned %s: %s';
	const REQUIRES_AUTH 		= 'Call to %s requires authentication. Please set token first or set argument 4 in setObject() to false.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}