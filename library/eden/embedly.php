<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram API factory. This is a factory class with 
 *
 * @package    Eden
 * @category   Embedly
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Embedly extends Eden_Class {
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
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Embedly oEmbed Instance
	 *
	 * @param *string 
	 * @param *string 
	 * @return Eden_Embedly_Oembed
	 */
	public function oembed($key) {
		//Argument test
		Eden_Error::i()
			->argument(1, 'string');	//Argument 1 must be a string
		
		return Eden_Embedly_Oembed::i($key);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}