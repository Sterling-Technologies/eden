<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube message
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Message extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_MESSAGE		= 'https://gdata.youtube.com/feeds/api/users/%s/inbox';
	const URL_YOUTUBE_MESSAGE_GET	= 'https://gdata.youtube.com/feeds/api/users/%s/inbox/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId		= 'default';
	protected $_userName	= NULL;
	protected $_videoId		= NULL;
	protected $_summary		= NULL;
	
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
			
		$this->_token 		= $token;
		$this->_developerId = $developerId; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * YouTube user ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * YouTube video ID.
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
	 * YouTube message ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setMessageId($messageId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_messageId = $messageId;
		
		return $this;
	}
	
	/**
	 * Set message summary.
	 *
	 * @param string
	 * @return this
	 */
	public function setSummary($summary) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_summary = $summary;
		
		return $this;
	}
	
	/**
	 * Set user name or channel name.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserName($userName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userName = $userName;
		
		return $this;
	}
	
	/**
	 * Retrieve all user's contacts
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_MESSAGE, $this->_userId), $query);
	}
	
	/**
	 * Send a video message
	 *
	 * @return array
	 */
	public function sendMessage() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::VIDEO_ID, $this->_videoId)
			->set(self::SUMMARY, $this->_summary)
			->parsePHP(dirname(__FILE__).'/template/sendmessage.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_MESSAGE, $this->_userName), $query);
	}
	
	/**
	 * Delete a message 
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_MESSAGE_GET, $this->_userId, $this->_messageId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}