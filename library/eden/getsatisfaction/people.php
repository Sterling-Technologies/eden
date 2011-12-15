<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction People Methods
 *
 * @package    Eden
 * @category   Get Satisfaction
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function get($key, $secret) {
		return self::_getMultiple(__CLASS__, $key, $secret);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setCompany($company) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_COMPANY, $company);
		return $this;
	}
	
	public function setEmployee($company) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_EMPLOYEE, $company);
		return $this;
	}
	
	public function setTopic($topic) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_TOPIC, $topic);
		return $this;
	}
	
	public function setKeyword($keyword) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string');
		
		$this->_query['query'] = $keyword;
		
		return $this;
	}
	
	public function setPage($page = 0) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'int');
		
		if($page < 0) {
			$page = 0;
		}
		
		$this->_query['page'] = $page;
		
		return $this;
	}
	
	public function setLimit($limit = 10) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'int');
		
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