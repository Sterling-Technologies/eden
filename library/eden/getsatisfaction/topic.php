<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Topic Methods  
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_GetSatisfaction_Topic extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL_LIST				= 'http://api.getsatisfaction.com/topics.json';
	const URL_COMPANY			= 'http://api.getsatisfaction.com/companies/%s/topics.json';
	const URL_COMPANY_PRODUCT	= 'http://api.getsatisfaction.com/companies/%s/products/%s/topics.json';
	const URL_COMPANY_TAG		= 'http://api.getsatisfaction.com/companies/%s/tags/%s/topics.json';
	const URL_PEOPLE			= 'http://api.getsatisfaction.com/people/%s/topics.json';
	const URL_PEOPLE_FOLLOWED	= 'http://api.getsatisfaction.com/people/%s/followed/topics.json';
	const URL_PRODUCT			= 'http://api.getsatisfaction.com/products/%s/topics.json';
	
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
	 * Filter by company
	 *
	 * @param string|int
	 * @return this
	 */
	public function filterByCompany($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_query['company'] = $company;
		
		return $this;
	}
	
	/**
	 * Filter by defined
	 *
	 * @param string|int
	 * @return this
	 */
	public function filterByDefined($defined) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_query['user_defined_code'] = $defined;
		
		return $this;
	}
	
	/**
	 * Filter by product
	 *
	 * @param string|int|array
	 * @return this
	 */
	public function filterByProduct($product) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int', 'array');
		
		if(is_array($product)) {
			$product = implode(',', $product);
		}
		
		$this->_query['product'] = $product;
		
		return $this;
	}
	
	/**
	 * Filter by since
	 *
	 * @param string|int
	 * @return this
	 */
	public function filterBySince($since) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($since)) {
			$since = strtotime($since);
		}
		
		$this->_query['active_since'] = $since;
		
		return $this;
	}
	
	/**
	 * Filter by active status
	 *
	 * @return this
	 */
	public function filterByStatusActive() {
		if(!isset($this->_filter['status']) || !in_array('active', $this->_filter['status'])) {
			$this->_filter['status'][] = 'active';
		}
		
		return $this;
	}
	
	/**
	 * Filter by complete status
	 *
	 * @return this
	 */
	public function filterByStatusComplete() {
		if(!isset($this->_filter['status']) || !in_array('complete', $this->_filter['status'])) {
			$this->_filter['status'][] = 'complete';
		}
		
		return $this;
	}
	
	/**
	 * Filter by no status
	 *
	 * @return this
	 */
	public function filterByStatusNone() {
		if(!isset($this->_filter['status']) || !in_array('none', $this->_filter['status'])) {
			$this->_filter['status'][] = 'none';
		}
		
		return $this;
	}
	
	/**
	 * Filter by pending status
	 *
	 * @return this
	 */
	public function filterByStatusPending() {
		if(!isset($this->_filter['status']) || !in_array('pending', $this->_filter['status'])) {
			$this->_filter['status'][] = 'pending';
		}
		
		return $this;
	}
	
	/**
	 * Filter by rejected status
	 *
	 * @return this
	 */
	public function filterByStatusRejected() {
		if(!isset($this->_filter['status']) || !in_array('rejected', $this->_filter['status'])) {
			$this->_filter['status'][] = 'rejected';
		}
		
		return $this;
	}
	
	/**
	 * Filter by tag
	 *
	 * @param string
	 * @return this
	 */
	public function filterByTag($tag) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		
		$this->_query['tag'] = $tag;
		
		return $this;
	}
	
	/**
	 * Filter by user
	 *
	 * @param string|int
	 * @return this
	 */
	public function filterByUser($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_query['user'] = $user;
		
		return $this;
	}
	
	/**
	 * Returns a list of companies
	 *
	 * @return array
	 */
	public function getResponse() {
		if(isset($this->_query['status']) && is_array($this->_query['status'])) {
			$this->_query['status'] = implode(',', $this->_query['status']);
		}
		
		return $this->_getResponse($this->_url, $this->_query);
	}
	
	/**
	 * Sets company URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function setCompany($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_COMPANY, $company);
		return $this;
	}
	
	/**
	 * Sets company URL
	 *
	 * @param string|int
	 * @param string|int
	 * @return this
	 */
	public function setCompanyProduct($company, $product) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string', 'int')
			->argument(2, 'string', 'int');
		
		$this->_url = sprintf(self::URL_COMPANY_PRODUCT, $company, $product);
		return $this;
	}
	
	/**
	 * Sets company URL
	 *
	 * @param string|int
	 * @param string|int
	 * @return this
	 */
	public function setCompanyTag($company, $tag) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string', 'int')
			->argument(2, 'string', 'int');
			
		$this->_url = sprintf(self::URL_COMPANY_TAG, $company, $tag);
		return $this;
	}
	
	/**
	 * Sets company URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function setFollowed($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_PEOPLE_FOLLOWED, $user);
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
	 * Sets company URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function setProduct($product) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_PRODUCT, $product);
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
	 * Sets company URL
	 *
	 * @param string|int
	 * @return this
	 */
	public function setUser($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$this->_url = sprintf(self::URL_PEOPLE, $user);
		return $this;
	}
	/**
	 * Sort by updates
	 *
	 * @return this
	 */
	public function showUpdates() {
		$this->_query['style'] = 'update';
		return $this;
	}
	
	/**
	 * Sort by ideas
	 *
	 * @return this
	 */
	public function showIdeas() {
		$this->_query['style'] = 'idea';
		return $this;
	}
	
	/**
	 * Sort by praise
	 *
	 * @return this
	 */
	public function showPraise() {
		$this->_query['style'] = 'praise';
		return $this;
	}
	
	/**
	 * Sort by problems
	 *
	 * @return this
	 */
	public function showProblems() {
		$this->_query['style'] = 'question';
		return $this;
	}
	
	/**
	 * Sort by questions
	 *
	 * @return this
	 */
	public function showQuestions() {
		$this->_query['style'] = 'question';
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
	 * Sort by created
	 *
	 * @return this
	 */
	public function sortByCreated() {
		$this->_query['sort'] = 'recently_created';
		return $this;
	}
	
	/**
	 * Sort by priority
	 *
	 * @return this
	 */
	public function sortByPriority() {
		$this->_query['sort'] = 'priority';
		return $this;
	}
	
	/**
	 * Sort by replies
	 *
	 * @return this
	 */
	public function sortByReplies() {
		$this->_query['sort'] = 'most_replies';
		return $this;
	}
	
	/**
	 * Sort by unanswered
	 *
	 * @return this
	 */
	public function sortByUnanswered() {
		$this->_query['sort'] = 'answered';
		return $this;
	}
	
	/**
	 * Sort by votes
	 *
	 * @return this
	 */
	public function sortByVotes() {
		$this->_query['sort'] = 'most_me_toos';
		return $this;
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}