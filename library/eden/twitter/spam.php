<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter spam reporting
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Spam extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_REPORT_SPAM	= 'https://api.twitter.com/1.1/users/report_spam.json';
	
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
	 * The user specified in the id is blocked by the
	 * authenticated user and reported as a spammer
	 *
	 * @param sting|null
	 * @param string|null
	 * @return array
	 */
	public function reportSpam($id = NULL, $name = NULL) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string', 'null')		//Argument 1 must be a string or null
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null		
		
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in query
			$this->_query['user_id'] = $id;
		}
		
		//if it is not empty
		if(!is_null($name)) {
			//lets put it in query
			$this->_query['screen_name'] = $name;
		}
		
		return $this->_post(self::URL_REPORT_SPAM, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}