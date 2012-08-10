<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */ 

/**
 * Google youtube comments
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Comment extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_GET_COMMENTS	= 'https://gdata.youtube.com/feeds/api/videos/%s/comments';
	const URL_YOUTUBE_COMMENTS		= 'https://gdata.youtube.com/feeds/api/videos/%s/comments/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
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
		
		$this->_token			= $token; 	
		$this->_developerId 	= $developerId; 
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function getList($videoId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $videoId));
	}
	
	/**
	 * Returns a specific comment
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($videoId, $commentId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_COMMENTS, $videoId, $commentId));
	}
	
	/**
	 * Add comment to a video
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function addComment($videoId, $comment) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::COMMENT, $comment)
			->parsePHP(dirname(__FILE__).'/template/addcomment.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $videoId), $query);
	}
		
	/**
	 * Reply to a comment in a video
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function replyToComment($videoId,$commentId, $comment) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string

		//make a xml template file
		$query = Eden_Template::i()
			->set(self::COMMENT, $comment)
			->set(self::COMMENT_ID, $commentId)
			->set(self::VIDEO_ID, $videoId)
			->parsePHP(dirname(__FILE__).'/template/replytocomment.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $videoId), $query);
	}
	
	/**
	 * Delete a comment
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($videoId, $commentId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
	 
		return $this->_delete(sprintf(self::URL_YOUTUBE_COMMENTS, $videoId, $commentId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}