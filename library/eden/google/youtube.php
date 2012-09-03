<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube extends Eden_Google_Base {
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
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token 	= $token;
		$this->_developerId	= $developerId;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Factory method for youtube activity
	 *
	 * @return Eden_Google_Youtube_Activity
	 */
	public function activity() {
		return Eden_Google_Youtube_Activity::i($this->_token, $this->_developerId);
	}
	
	/**
	 * Factory method for youtube channel
	 *
	 * @return Eden_Google_Youtube_Channel
	 */
	public function channel() {
		return Eden_Google_Youtube_Channel::i($this->_token);
	}
	
	/**
	 * Factory method for youtube comment
	 *
	 * @return Eden_Google_Youtube_Activity
	 */
	public function comment() {
		return Eden_Google_Youtube_Comment::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube contacts
	 *
	 * @return Eden_Google_Youtube_Contacts
	 */
	public function contacts() {
		return Eden_Google_Youtube_Contacts::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube favorites
	 *
	 * @return Eden_Google_Youtube_Favorites
	 */
	public function favorites() {
		return Eden_Google_Youtube_Favorites::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube history
	 *
	 * @return Eden_Google_Youtube_History
	 */
	public function history() {
		return Eden_Google_Youtube_History::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube message
	 *
	 * @return Eden_Google_Youtube_Message
	 */
	public function message() {
		return Eden_Google_Youtube_Message::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube playlist
	 *
	 * @return Eden_Google_Youtube_Playlist
	 */
	public function playlist() {
		return Eden_Google_Youtube_Playlist::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube profile
	 *
	 * @return Eden_Google_Youtube_Profile
	 */
	public function profile() {
		return Eden_Google_Youtube_Profile::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube ratings
	 *
	 * @return Eden_Google_Youtube_Ratings
	 */
	public function ratings() {
		return Eden_Google_Youtube_Ratings::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube search
	 *
	 * @return Eden_Google_Youtube_Search
	 */
	public function search() {
		return Eden_Google_Youtube_Search::i($this->_token);
	}
	
	/**  
	 * Factory method for youtube subscription
	 *
	 * @return Eden_Google_Youtube_Subscription
	 */
	public function subscription() {
		return Eden_Google_Youtube_Subscription::i($this->_token, $this->_developerId);
	}
	
	/**  
	 * Factory method for youtube upload
	 *
	 * @return Eden_Google_Youtube_Upload
	 */
	public function upload() {
		return Eden_Google_Youtube_Upload::i($this->_token, $this->_developerId);
	}
	
	/** 
	 * Factory method for youtube video
	 *
	 * @return Eden_Google_Youtube_Video
	 */
	public function video() {
		return Eden_Google_Youtube_Video::i($this->_token);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}