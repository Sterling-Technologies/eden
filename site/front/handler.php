<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */
 
/**
 * Defines the starting point of every application call.
 * Starts laying out how classes and methods are handled.
 *  
 * @package    Back
 */
class Front_Handler extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i(Eden $app) {
		return self::_getSingleton(__CLASS__, $app);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct(Eden $app) {
		$app->listen('request', $this, 'sessionStart');
	}
	
	/* Public Methods
	-------------------------------*/
	public function sessionStart() {
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}