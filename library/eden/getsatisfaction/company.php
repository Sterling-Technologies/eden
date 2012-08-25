<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Various ways to get a list of companies in Get Satisfaction
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction_Company extends Eden_Getsatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST		= 'http://api.getsatisfaction.com/companies.json';
	const URL_PEOPLE	= 'http://api.getsatisfaction.com/people/%s/companies.json';
	const URL_PRODUCT	= 'http://api.getsatisfaction.com/products/%s/companies.json';
	const URL_ACTIVITY	= 'http://api.getsatisfaction.com/companies/%s/last_activity_at.json';
	
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
	 * Set keyword filter
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
	 * Sets activity URL
	 * 
	 * @param int|string
	 * @return this
	 */
	public function searchByActivity($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_ACTIVITY, $company);
		return $this;
	}
	
	/**
	 * Set product URL
	 * 
	 * @param int|string
	 * @return this
	 */
	public function searchByProduct($product) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_PRODUCT, $product);
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
	 * Show private companies
	 *
	 * @return this
	 */
	public function showPrivate() {
		$this->_query['show'] = 'private';
		return $this;
	}
	
	/**
	 * Show public companies
	 *
	 * @return this
	 */
	public function showPublic() {
		$this->_query['show'] = 'public';
		return $this;
	}
	
	/**
	 * Show visible companies
	 *
	 * @return this
	 */
	public function showVisible() {
		$this->_query['show'] = 'not_hidden';
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
	
	/**
	 * Sort by active
	 *
	 * @return this
	 */
	public function sortByActive() {
		$this->_query['sort'] = 'recently_active';
		return $this;
	}

	/**
	 * Sort by letters
	 *
	 * @return this
	 */
	public function sortByAlphabet() {
		$this->_query['sort'] = 'alpha';
		return $this;
	}
	
	/**
	 * Sort by created
	 *
	 * @return this
	 */
	public function sortByCreated() {
		$this->_query['sort'] = 'recently_created';
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}