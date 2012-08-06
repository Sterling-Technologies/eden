<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */ 

/**
 * Google youtube playlist
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Playlist extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_PLAYLIST			= 'https://gdata.youtube.com/feeds/api/users/%s/playlists';
	const URL_YOUTUBE_PLAYLIST_UPDATE	= 'https://gdata.youtube.com/feeds/api/users/%s/playlists/%s';
	const URL_YOUTUBE_PLAYLIST_DELETE	= 'https://gdata.youtube.com/feeds/api/users/%s/playlists/%s';
	const URL_YOUTUBE_PLAYLIST_GET		= 'https://gdata.youtube.com/feeds/api/playlists/%s';  
	const URL_YOUTUBE_PLAYLIST_VIDEO	= 'https://gdata.youtube.com/feeds/api/playlists/%s/%s'; 
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId 		= 'default';
	protected $_title		= NULL;
	protected $_summary		= NULL;
	protected $_developerId	= NULL;
	protected $_position	= NULL;
	protected $_playlistId	= NULL;
	protected $_videoId		= NULL;
	protected $_entryId		= NULL;
	
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
		
		$this->_developerId	= $developerId;
		$this->_token		= $token; 
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Set youtube user id
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
	 * Set playlist entry id
	 *
	 * @param string
	 * @return this
	 */
	public function setPlaylistEntryId($entryId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_entryId = $entryId;
		
		return $this;
	}
	
	/**
	 * Set youtube playlist id
	 *
	 * @param string
	 * @return this
	 */
	public function setPlaylistId($playlistId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_playlistId = $playlistId;
		
		return $this;
	}
	
	/**
	 * Set youtube playlist id
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
	 * Set video position in the playlist
	 *
	 * @param integer
	 * @return this
	 */
	public function setVideoPosition($position) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_position = $position;
		
		return $this;
	}
	
	/**
	 * Set playlist title
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_title = $title;
		
		return $this;
	}
	
	/**
	 * Set playlist summary
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
	 * Returns user playlist
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);	
				
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_PLAYLIST, $this->_userId), $query);
	}
	
	/**
	 * Create a playlist
	 *
	 * @return array
	 */
	public function create() {
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $this->_title)
			->set(self::SUMMARY, $this->_summary)
			->parsePHP(dirname(__FILE__).'/template/createplaylist.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_PLAYLIST, $this->_userId), $query);
	}
	
	/**
	 * Create a playlist
	 *
	 * @return array
	 */
	public function update() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $this->_title)
			->set(self::SUMMARY, $this->_summary)
			->parsePHP(dirname(__FILE__).'/template/createplaylist.php');
		
		return $this->_put(sprintf(self::URL_YOUTUBE_PLAYLIST_UPDATE, $this->_userId, $this->_playlistId), $query);
	}
	
	/**
	 * Add video to a playlist
	 *
	 * @return array
	 */
	public function addVideo() {

		//make a xml template
		$query = Eden_Template::i()
			->set(self::VIDEO_ID, $this->_videoId)
			->set(self::POSITION, $this->_position)
			->parsePHP(dirname(__FILE__).'/template/addvideo.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_PLAYLIST_GET, $this->_playlistId), $query);
	}
	
	/**
	 * Add video to a playlist
	 *
	 * @return array
	 */
	public function updateVideo() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::POSITION, $this->_position)
			->parsePHP(dirname(__FILE__).'/template/addvideo.php');
		
		return $this->_put(sprintf(self::URL_YOUTUBE_PLAYLIST_VIDEO, $this->_playlistId, $this->_entryId), $query);
	}
	
	/**
	 * Remove a video in the playlist 
	 *
	 * @return array
	 */
	public function removeVideo() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_PLAYLIST_VIDEO, $this->_playlistId, $this->_entryId));
	}
	
	/**
	 * Delete a playlist 
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_PLAYLIST_DELETE, $this->_userId, $this->_playlistId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}