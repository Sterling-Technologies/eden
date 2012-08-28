<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Various ways to get a list of people in Get Satisfaction
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_GetSatisfaction_People extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST			= 'http://api.getsatisfaction.com/people.json';
	const URL_EMPLOYEE		= 'http://api.getsatisfaction.com/companies/%s/employees.json';
	const URL_COMPANY		= 'http://api.getsatisfaction.com/companies/%s/people.json';
	const URL_TOPIC			= 'http://api.getsatisfaction.com/topics/%s/people';
	
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
	 * Filter by keyword
	 *
	 * @param string
	 * @return this
	 */
	public function filterByKeyword($keyword) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		
		$this->_query['query'] = $keyword;
		
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
	 * Sets company URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function searchByCompany($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_COMPANY, $company);
		return $this;
	}
	
	/**
	 * Sets Employee URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function searchByEmployee($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_EMPLOYEE, $company);
		return $this;
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