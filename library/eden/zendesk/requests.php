<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk Request 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Requests extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const REQUEST_LIST			= 'https://%s.zendesk.com/api/v2/requests.json';
	const REQUEST_SPECIFIC		= 'https://%s.zendesk.com/api/v2/requests/%s.json';
	const REQUEST_LIST_COMMENT	= 'https://%s.zendesk.com/api/v2/requests/%s/comments.json';
	const REQUEST_GET_COMMENT	= 'https://%s.zendesk.com/api/v2/requests/%s/comments/%s.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Get all request list
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::REQUEST_LIST, $this->_subdomain));
	}
	
	/**
	 * Get specific request 
	 *
	 * @param string 
	 * @return array
	 */
	public function getSpecific($requestId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::REQUEST_SPECIFIC, $this->_subdomain, $requestId));
	}
	
	/**
	 * Creating Requests
	 *
	 * @param string 
	 * @param string 
	 * @return array
	 */
	public function createRequest($subject, $comment) {
		//argument test 
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['request']['subject'] 			= $subject;
		$this->_query['request']['comment']['value'] 	= $comment;
		
		return $this->_post(sprintf(self::REQUEST_LIST, $this->_subdomain), $this->_query);
	}
	
	/**
	 * Update Requests
	 *
	 * @param string 
	 * @return array
	 */
	public function updateRequest($requestId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
			
		return $this->_put(sprintf(self::REQUEST_SPECIFIC, $this->_subdomain, $requestId), $this->_query);
	}
	
	/**
	 * Get all request comment list
	 *
	 * @return array
	 */
	public function getCommentList($requestId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::REQUEST_LIST_COMMENT, $this->_subdomain, $requestId));
	}
	
	/**
	 * Get specific request comment 
	 *
	 * @param string 
	 * @param string 
	 * @return array
	 */
	public function getCommentSpecific($requestId, $commentId) {
		//argument test 
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::REQUEST_GET_COMMENT, $this->_subdomain, $requestId, $commentId));
	}
	
	/**
	 * Set subject
	 *
	 * @param string 
	 * @return this
	 */
	public function setSubject($subject) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['request']['subject'] = $subject;
		
		return $this;
	}
	
	/**
	 * The state of the request, "new", "open", "pending", "hold",
	 * "solved", "closed"
	 *
	 * @param string 
	 * @return this
	 */
	public function setStatus($status) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['request']['status'] = $status;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}