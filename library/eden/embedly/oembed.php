<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram auth
 *
 * @package    Eden
 * @category   Embedly / oEmbed
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Embedly_Oembed extends Eden_Class {
	/* Constants
	-------------------------------*/
	const OEMBED_URL		= 'http://api.embed.ly/1/oembed';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key) {
		//argument test
		Eden_Error::i()
			->argument(1, 'string');	//Argument 1 must be a string
			
		$this->_key = $key;
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Gets an oEmbed URL info
	 * @param  String $url    URL you want to get info from
	 * @param  array  $params additional parameters for the URL
	 * @return array         Response from Embedly
	 */
	public function get($url, $params = array())
	{
		$oembed_url = $this->getOembedUrl($url, $params);
		$data = file_get_contents($oembed_url);
		return json_decode($data, true);
	}

	/**
	 * Gets an oEmbed URL
	 * @param  String $url    URL you want to get info from
	 * @param  array  $params additional parameters for the URL
	 * @return [type]         [description]
	 */
	public function getOembedUrl($url, $params = array())
	{
		if( is_array($url) ) {
			$params['urls'] = implode(',', $url);
			var_dump($url);
		} else {
			$params['url'] = $url;
		}
		var_dump(http_build_query($params)); exit;
		$params['key'] = $this->_key;
		$oembed_url = Eden_Embedly_Oembed::OEMBED_URL . '?' . http_build_query($params);

		return $oembed_url;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}