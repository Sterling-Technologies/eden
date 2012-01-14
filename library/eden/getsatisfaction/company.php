<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Company Methods
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_GetSatisfaction_Company extends Eden_Getsatisfaction_Base {
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
	public function setActivity($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_ACTIVITY, $company);
		return $this;
	}
	
	public function setUser($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_PEOPLE, $user);
		return $this;
	}
	
	public function setProduct($product) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_PRODUCT, $product);
		return $this;
	}
	
	public function setKeyword($keyword) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		
		$this->_query['query'] = $keyword;
		
		return $this;
	}
	
	public function showPublic() {
		$this->_query['show'] = 'public';
		return $this;
	}
	
	public function showVisible() {
		$this->_query['show'] = 'not_hidden';
		return $this;
	}
	
	public function showPrivate() {
		$this->_query['show'] = 'private';
		return $this;
	}
	
	public function sortByCreated() {
		$this->_query['sort'] = 'recently_created';
		return $this;
	}
	
	public function sortByActive() {
		$this->_query['sort'] = 'recently_active';
		return $this;
	}

	public function sortByAlphabet() {
		$this->_query['sort'] = 'alpha';
		return $this;
	}
	
	public function setPage($page = 0) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'int');
		
		if($page < 0) {
			$page = 0;
		}
		
		$this->_query['page'] = $page;
		
		return $this;
	}
	
	public function setLimit($limit = 10) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'int');
		
		if($limit < 0) {
			$limit = 10;
		}
		
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	public function getList() {
		if(isset($this->_query['status']) && is_array($this->_query['status'])) {
			$this->_query['status'] = implode(',', $this->_query['status']);
		}
		
		return $this->_getResponse($this->_url, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}