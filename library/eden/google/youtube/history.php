<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */ 

/**
 * Google youtube history
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_History extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_HISTORY		= 'https://gdata.youtube.com/feeds/api/users/default/watch_history';
	const URL_YOUTUBE_HISTORY_GET	= 'https://gdata.youtube.com/feeds/api/users/default/watch_history/%s';
	const URL_YOUTUBE_HISTORY_CLEAR	= 'https://gdata.youtube.com/feeds/api/users/default/watch_history/actions/clear';
	
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
		$this->_developerId		= $developerId;
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Retrieve a user's watch history feed.
	 *
	 * @return array
	 */
	public function getList() {
		
		$this->_query[self::VERSION]	= self::VERSION_TWO;
		$this->_query[self::RESPONSE]	= self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_HISTORY), $this->_query);
	}
	
	/**
	 * Delete a specific history
	 *
	 * @param string
	 * @return array
	 */
	public function deleteSpecific($historyId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
	
		return $this->_delete(sprintf(self::URL_YOUTUBE_HISTORY_GET, $historyId));
	}
	
	/**
	 * Clear history
	 *
	 * @return array
	 */
	public function clearHistory() {
		//call block to format xml files
		$query = $this->Eden_Google_Youtube_Block_Clear();
		
		return $this->_post(sprintf(self::URL_YOUTUBE_HISTORY_CLEAR), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}