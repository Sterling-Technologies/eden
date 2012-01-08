<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Facebook
 *
 * @package    Eden
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: tool.php 3 2010-01-06 01:16:54Z blanquera $
 */
class Eden_Facebook extends Eden_Class {
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
	 * Returns Facebook Auth
	 *
	 * @param string
	 * @param string
	 * @return Eden_Facebook_Auth
	 */
	public function auth($key, $secret) {
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
			
		return Eden_Facebook_Auth::i($key, $secret);
	}
	
	/**
	 * Returns Facebook Graph
	 *
	 * @param string
	 * @return Eden_Facebook_Graph
	 */
	public function graph($token) {
		Eden_Facebook_Error::i()->argument(1, 'string');
		return Eden_Facebook_Graph::i($token);
	}
	
	/**
	 * Returns Facebook Post
	 *
	 * @param string
	 * @return Eden_Facebook_Post
	 */
	public function post($token) {
		Eden_Facebook_Error::i()->argument(1, 'string');
		return Eden_Facebook_Post::i($token);
	}
	
	/**
	 * Returns Facebook FQL
	 *
	 * @param string
	 * @return Eden_Facebook_Fql
	 */
	public function fql($token) {
		Eden_Facebook_Error::i()->argument(1, 'string');
		return Eden_Facebook_Fql::i($token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}