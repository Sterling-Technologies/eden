<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction Detail Methods  
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_GetSatisfaction_Detail extends Eden_GetSatisfaction_Base {
	/* Constants
	-------------------------------*/
	const URL = 'http://api.getsatisfaction.com/topics/%s.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
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
	 * Returns topic details
	 *
	 * @param string|int
	 * @return array
	 */
	public function getTopic($topic) {
		Eden_Getsatisfaction_Error::i()->argument(1, 'string', 'int');
		
		return $this->_getResponse(sprintf(self::URL, $topic));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}