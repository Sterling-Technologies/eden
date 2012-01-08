<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Reply Methods
 *
 * @package    Eden
 * @category   Get Satisfaction
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function i($key, $secret) {
		return self::_getMultiple(__CLASS__, $key, $secret);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setUser($user) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_PEOPLE, $user);
		return $this;
	}
	
	public function setTopic($topic) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$this->_url = sprintf(self::URL_TOPIC, $topic);
		return $this;
	}
	
	public function filterBest() {
		$this->_query['filter'] = 'best';
		
		return $this;
	}
	
	public function filterStarPromoted() {
		$this->_query['filter'] = 'star_promoted';
		
		return $this;
	}
	
	public function filterCompanyPromoted() {
		$this->_query['filter'] = 'company_promoted';
		
		return $this;
	}
	
	public function filterFlatPromoted() {
		$this->_query['filter'] = 'flat_promoted';
		
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
	
	public function reply($topic, $content, $face = NULL, $feeling = NULL, $intensity = NULL) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string', 'numeric')
			->argument(2, 'string')
			->argument(3, 'string', 'null')
			->argument(4, 'string', 'null')
			->argument(5, 'int', 'null');
		
		$url = sprintf(self::URL_REPLY, $topic);
		
		$query = array('content' => $content);
		
		if($face && in_array($face, $this->_validFaces)) {
			$query['emotitag']['face'] = $face;
		}
		
		if($feeling) {
			$query['emotitag']['feeling'] = $feeling;
		}
		
		if($intensity && $intensity > -1 && $intensity < 4) {
			$query['emotitag']['intensity'] = $intensity;
		}
		
		return $this->_post($url, array('reply' => $query));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}