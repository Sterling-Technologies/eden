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
class Eden_Getsatisfaction_Reply extends Eden_Getsatisfaction_Base {
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
	 * @param string
	 * @return array
	 */
	public function create($topic, $content) {
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string', 'int')
			->argument(2, 'string');
		
		$url 	= sprintf(Eden_Getsatisfaction_Replies::URL_REPLY, $topic);
		$query 	= array('content' => $content);
		
		return $this->_post($url, array('reply' => $this->_query), true);
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}