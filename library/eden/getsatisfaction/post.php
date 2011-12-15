<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Post Methods
 *
 * @package    Eden
 * @category   Get Satisfaction
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Getsatisfaction_Post extends Eden_Getsatisfaction_Base {
	/* Constants
	-------------------------------*/
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
	public function setTitle($title) {
		$this->_query['subject'] = $title;
		return $this;
	}
	
	public function setDetail($detail) {
		$this->_query['additional_detail'] = $detail;
		return $this;
	}
	
	public function setQuestion() {
		$this->_query['style'] = 'question';
		return $this;
	}
	
	public function setProblem() {
		$this->_query['style'] = 'problem';
		return $this;
	}
	
	public function setPraise() {
		$this->_query['style'] = 'praise';
		return $this;
	}
	
	public function setIdea() {
		$this->_query['style'] = 'idea';
		return $this;
	}
	
	public function setUpdate() {
		$this->_query['style'] = 'update';
		return $this;
	}
	
	public function setTags($tags) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'array');
		
		if(is_array($tags)) {
			$tags = implode(',', $tags);
		}
		
		$this->_query['keywords'] = $tags;
	}
	
	public function setOverwriteKeywords() {
		$this->_query['overwrite_keywords'] = 'true';
		return $this;
	}
	
	public function setProducts($products) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'array');
		
		if(is_array($products)) {
			$tags = implode(',', $products);
		}
		
		$this->_query['products'] = $products;
		return $this;
	}
	
	public function setFeeling($feeling) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string');
		
		$this->_query['emotitag']['feeling'] = $feeling;
		return $this;
	}
	
	public function setHappyFace() {
		$this->_query['emotitag']['face'] = 'happy';
		return $this;
	}
	
	public function setSadFace() {
		$this->_query['emotitag']['face'] = 'sad';
		return $this;
	}
	
	public function setSillyFace() {
		$this->_query['emotitag']['face'] = 'silly';
		return $this;
	}
	
	public function setIndifferentFace() {
		$this->_query['emotitag']['face'] = 'indifferent';
		return $this;
	}
	
	public function setIntensity($intensity) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'int');
		
		if($intensity < 0) {
			$intensity = 0;
		} else if($intensity > 5) {
			$intensity = 5;
		}
		
		$this->_query['emotitag']['intensity'] = $intensity;
		return $this;
	}
	
	public function add($company) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'numeric');
		
		$url = sprintf(Eden_GetSatisfaction_Topic::URL_COMPANY, $company);
		
		return $this->_post($url, array('topic' => $this->_query), true);
	}
	
	public function edit($topic) {
		Eden_Getsatisfaction_Error::get()->argument(1, 'string', 'numeric');
		
		$url = sprintf(Eden_GetSatisfaction_Detail::URL, $topic);
		
		return $this->_post($url, array('topic' => $this->_query), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}