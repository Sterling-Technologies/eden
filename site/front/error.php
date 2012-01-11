<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Front application exception
 *
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: exception.php 9 2010-01-03 00:28:47Z blanquera $
 */
class Front_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const BLOCK_NOT_EXIST = 'Block %s does not exist.';
	
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