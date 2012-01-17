<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2010-2012 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Sql Errors
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Sql_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const QUERY_ERROR 		= '%s Query: %s';
	const TABLE_NOT_SET 	= 'No default table set or was passed.';
	const DATABASE_NOT_SET 	= 'No default database set or was passed.';
	
	const NOT_SUB_MODEL 		= 'Class %s is not a child of Eden_Model';
	const NOT_SUB_COLLECTION 	= 'Class %s is not a child of Eden_Collection';
	
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