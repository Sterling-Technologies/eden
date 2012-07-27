<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Post Methods
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction_Post extends Eden_Getsatisfaction_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query 	= array();
	
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
	 * Creates the post
	 *
	 * @param string|int
	 * @return array
	 */
	public function create($company) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		$url = sprintf(Eden_Getsatisfaction_Topic::URL_COMPANY, $company);
		
		return $this->_post($url, array('topic' => $this->_query), true);
	}
	
	/**
	 * Overwrite keywords
	 *
	 * @return this
	 */
	public function overwriteKeywords() {
		$this->_query['overwrite_keywords'] = 'true';
		return $this;
	}
	
	/**
	 * Set topic detail
	 *
	 * @param string
	 * @return this
	 */
	public function setDetail($detail) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		$this->_query['additional_detail'] = $detail;
		return $this;
	}
	
	/**
	 * Set topic mood
	 *
	 * @param string
	 * @return this
	 */
	public function setFeeling($feeling) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		
		$this->_query['emotitag']['feeling'] = $feeling;
		return $this;
	}
	
	/**
	 * Add happy face
	 *
	 * @return this
	 */
	public function setHappyFace() {
		$this->_query['emotitag']['face'] = 'happy';
		return $this;
	}
	
	/**
	 * Set topic style to idea format
	 *
	 * @return this
	 */
	public function setIdea() {
		$this->_query['style'] = 'idea';
		return $this;
	}
	
	/**
	 * Add lame face
	 *
	 * @return this
	 */
	public function setIndifferentFace() {
		$this->_query['emotitag']['face'] = 'indifferent';
		return $this;
	}
	
	/**
	 * Set topic intensity
	 *
	 * @param int 0-5
	 * @return this
	 */
	public function setIntensity($intensity) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'int');
		
		if($intensity < 0) {
			$intensity = 0;
		} else if($intensity > 5) {
			$intensity = 5;
		}
		
		$this->_query['emotitag']['intensity'] = $intensity;
		return $this;
	}
	
	/**
	 * Set topic style to praise format
	 *
	 * @return this
	 */
	public function setPraise() {
		$this->_query['style'] = 'praise';
		return $this;
	}
	
	/**
	 * Set topic style to problem format
	 *
	 * @return this
	 */
	public function setProblem() {
		$this->_query['style'] = 'problem';
		return $this;
	}
	
	/**
	 * Set products this topic is related to
	 *
	 * @param string|array
	 * @return this
	 */
	public function setProducts($products) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($products)) {
			$tags = implode(',', $products);
		}
		
		$this->_query['products'] = $products;
		return $this;
	}
	
	/**
	 * Set topic style to question format
	 *
	 * @return this
	 */
	public function setQuestion() {
		$this->_query['style'] = 'question';
		return $this;
	}
	
	/**
	 * Add sad face
	 *
	 * @return this
	 */
	public function setSadFace() {
		$this->_query['emotitag']['face'] = 'sad';
		return $this;
	}
	
	/**
	 * Add silly face
	 *
	 * @return this
	 */
	public function setSillyFace() {
		$this->_query['emotitag']['face'] = 'silly';
		return $this;
	}
	
	/**
	 * Add tags
	 *
	 * @param string|array
	 * @return this
	 */
	public function setTags($tags) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($tags)) {
			$tags = implode(',', $tags);
		}
		
		$this->_query['keywords'] = $tags;
	}
	
	/**
	 * Set title
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		$this->_query['subject'] = $title;
		return $this;
	}
	
	/**
	 * Set topic style to update format
	 *
	 * @return this
	 */
	public function setUpdate() {
		$this->_query['style'] = 'update';
		return $this;
	}
	
	/**
	 * Updates the post
	 *
	 * @param string|int
	 * @return array
	 */
	public function update($topic) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'numeric');
		
		$url = sprintf(Eden_GetSatisfaction_Detail::URL, $topic);
		
		return $this->_post($url, array('topic' => $this->_query), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}