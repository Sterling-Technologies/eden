<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Reply Methods
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction_Replies extends Eden_Getsatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST		= 'http://api.getsatisfaction.com/replies.json';
	const URL_TOPIC		= 'http://api.getsatisfaction.com/topics/%s/replies.json';
	const URL_PEOPLE	= 'http://api.getsatisfaction.com/people/%s/replies.json';
	const URL_REPLY		= 'http://api.getsatisfaction.com/topics/%s/replies';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query 	= array();
	protected $_url 	= self::URL_LIST;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Filter by best
	 *
	 * @return this
	 */
	public function filterByBest() {
		$this->_query['filter'] = 'best';
		
		return $this;
	}
	
	/**
	 * Filter by company promoted
	 *
	 * @return this
	 */
	public function filterByCompanyPromoted() {
		$this->_query['filter'] = 'company_promoted';
		
		return $this;
	}
	
	/**
	 * Filter by flat promoted
	 *
	 * @return this
	 */
	public function filterByFlatPromoted() {
		$this->_query['filter'] = 'flat_promoted';
		
		return $this;
	}
	
	/**
	 * Filter by star promoted
	 *
	 * @return this
	 */
	public function filterByStarPromoted() {
		$this->_query['filter'] = 'star_promoted';
		
		return $this;
	}
	
	/**
	 * Returns a list of companies
	 *
	 * @return array
	 */
	public function getResponse() {
		return $this->_getResponse($this->_url, $this->_query);
	}
	
	/**
	 * Sets topic URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function searchByTopic($topic) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_TOPIC, $topic);
		return $this;
	}
	/**
	 * Sets user URL
	 * 
	 * @param int|string
	 * @return this
	 */
	public function searchByUser($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_PEOPLE, $user);
		return $this;
	}
	
	/**
	 * Set page
	 *
	 * @param int
	 * @return this
	 */
	public function setPage($page = 0) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'int');
		
		if($page < 0) {
			$page = 0;
		}
		
		$this->_query['page'] = $page;
		
		return $this;
	}
	
	/**
	 * Set range
	 *
	 * @param int
	 * @return this
	 */
	public function setRange($limit = 10) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'int');
		
		if($limit < 0) {
			$limit = 10;
		}
		
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}