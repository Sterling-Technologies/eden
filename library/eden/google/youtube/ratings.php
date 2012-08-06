<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google Youtube ratings
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Ratings extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_RATINGS	= 'https://gdata.youtube.com/feeds/api/videos/%s/ratings';	
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_videoId 	= NULL;
	protected $_ratings 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token	 	= $token;
		$this->_developerId = $developerId;
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Youtube video id
	 *
	 * @param string
	 * @return this
	 */
	public function setVideoId($videoId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_videoId = $videoId;
		
		return $this;
	}
	
	/**
	 * Set video rating (1- 5)
	 *
	 * @param integer
	 * @return this
	 */
	public function setRatings($ratings) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_ratings = $ratings;
		
		return $this;
	}
	
	/**
	 * Add a numeric (1-5) video rating
	 *
	 * @return array
	 */
	public function addRating() {
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::RATINGS, $this->_ratings)
			->parsePHP(dirname(__FILE__).'/template/addratings.php');
			
		return $this->_post(sprintf(self::URL_YOUTUBE_RATINGS, $this->_videoId), $query);
	}
	
	/**
	 * Like a video
	 *
	 * @return array
	 */
	public function like() {
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::VALUE, self::LIKE)
			->parsePHP(dirname(__FILE__).'/template/like.php');
			
		return $this->_post(sprintf(self::URL_YOUTUBE_RATINGS, $this->_videoId), $query);
	}
	
	/**
	 * Dislike a video
	 *
	 * @return array
	 */
	public function dislike() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::VALUE, self::DISLIKE)
			->parsePHP(dirname(__FILE__).'/template/like.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_RATINGS, $this->_videoId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}