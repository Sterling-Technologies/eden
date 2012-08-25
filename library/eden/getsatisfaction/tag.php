<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Tag Methods
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_GetSatisfaction_Tag extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST		= 'http://api.getsatisfaction.com/tags.json';
	const URL_TOPIC		= 'http://api.getsatisfaction.com/topics/%s/tags.json';
	const URL_COMPANY	= 'http://api.getsatisfaction.com/companies/%s/tags.json';
	
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