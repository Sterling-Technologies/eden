<?php //-->
/**
 * Route Errors
 */
class Eden_Route_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const CLASS_NOT_EXISTS 		= 'Invalid class call: %s->%s(). Class does not exist.';
	const METHOD_NOT_EXISTS 	= 'Invalid class call: %s->%s(). Method does not exist.';
	const STATIC_ERROR 			= 'Invalid class call: %s::%s().';
	const FUNCTION_ERROR 		= 'Invalid function run: %s().';
	
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