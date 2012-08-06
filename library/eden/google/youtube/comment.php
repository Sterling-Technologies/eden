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
	protected $_videoId 	= NULL;
	protected $_developerId	= NULL;
	protected $_comment		= NULL;
	protected $_commentId	= NULL;
	protected $_version		= '2';
	
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
	 * Youtube comment id
	 *
	 * @param string
	 * @return this
	 */
	public function setCommentId($commentId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_commentId = $commentId;
		
		return $this;
	}
	
	/**
	 * Set text comment
	 *
	 * @param string
	 * @return this
	 */
	public function setComment($comment) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_comment = $comment;
		
		return $this;
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $this->_videoId));
	}
	
	/**
	 * Returns a specific comment
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_COMMENTS, $this->_videoId, $this->_commentId));
	}
	
	/**
	 * Add comment to a video
	 *
	 * @return array
	 */
	public function addComment() {
		
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::COMMENT, $this->_comment)
			->parsePHP(dirname(__FILE__).'/template/addcomment.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $this->_videoId), $query);
	}
		
	/**
	 * Reply to a comment in a video
	 *
	 * @return array
	 */
	public function replyToComment() {

		//make a xml template file
		$query = Eden_Template::i()
			->set(self::COMMENT, $this->_comment)
			->set(self::COMMENT_ID, $this->_commentId)
			->set(self::VIDEO_ID, $this->_videoId)
			->parsePHP(dirname(__FILE__).'/template/replytocomment.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_GET_COMMENTS, $this->_videoId), $query);
	}
	
	/**
	 * Delete a comment
	 *
	 * @return array
	 */
	public function delete() {
	 
		return $this->_delete(sprintf(self::URL_YOUTUBE_COMMENTS, $this->_videoId, $this->_commentId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}