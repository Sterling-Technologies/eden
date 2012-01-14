<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/facebook/error.php';
require_once dirname(__FILE__).'/facebook/auth.php';
require_once dirname(__FILE__).'/facebook/graph.php';
require_once dirname(__FILE__).'/facebook/post.php';

/**
 * Facebook API factory. This is a factory class with 
 * methods that will load up different Facebook classes.
 * Facebook classes are organized as described on their 
 * developer site: auth, graph, FQL. We also added a post 
 * class for more advanced options when posting to Facebook.
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
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
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
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