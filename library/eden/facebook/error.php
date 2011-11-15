<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Facebook Errors
 *
 * @package    Eden
 * @subpackage facebook
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: exception.php 1 2010-01-02 23:06:36Z blanquera $
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