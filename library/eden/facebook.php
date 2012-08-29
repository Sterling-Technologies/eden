<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/oauth2.php';
require_once dirname(__FILE__).'/facebook/error.php';
require_once dirname(__FILE__).'/facebook/auth.php';
require_once dirname(__FILE__).'/facebook/graph.php';
require_once dirname(__FILE__).'/facebook/post.php';
require_once dirname(__FILE__).'/facebook/event.php';
require_once dirname(__FILE__).'/facebook/link.php';
require_once dirname(__FILE__).'/facebook/select.php';
require_once dirname(__FILE__).'/facebook/search.php';
require_once dirname(__FILE__).'/facebook/fql.php';

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
	const RSS = 'https://www.facebook.com/feeds/page.php?id=%s&format=rss20';
	const RSS_AGENT = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13';
	
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
	 * @param string
	 * @return Eden_Facebook_Auth
	 */
	public function auth($key, $secret, $redirect) {
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string');
			
		return Eden_Facebook_Auth::i($key, $secret, $redirect);
	}
	
	/**
	 * Add an event
	 *
	 * @param string
	 * @param string
	 * @param string|int
	 * @param string|int
	 * @return Eden_Facebook_Event
	 */
	public function event($token, $name, $start, $end) {
		return Eden_Facebook_Event::i($token, $name, $start, $end);
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
	 * Add a link
	 *
	 * @param string
	 * @param string
	 * @return Eden_Facebook_Post
	 */
	public function link($token, $url) {
		return Eden_Facebook_Link::i($token, $url);
	}
		
	/**
	 * Returns Facebook Post
	 *
	 * @param string
	 * @param string
	 * @return Eden_Facebook_Post
	 */
	public function post($token, $message) {
		return Eden_Facebook_Post::i($token, $message);
	}

	/**
	 * Returns an RSS feed to a public id
	 *
	 * @param int
	 * @return SimpleXml
	 */
	public function rss($id) {
		Eden_Facebook_Error::i()->argument(1, 'int');
		return Eden_Curl::i()
			->setUrl(sprintf(self::RSS, $id))
			->setUserAgent(self::RSS_AGENT)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->getSimpleXmlResponse();
	}
	
	/**
	 * Returns Facebook subscribe
	 *
	 * @param string
	 * @param string
	 * @return Eden_Facebook_Subscribe
	 */
	public function subscribe($clientId, $secret) {
		return Eden_Facebook_Subscribe::i($clientId, $secret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}