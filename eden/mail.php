<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/mail/error.php';
require_once dirname(__FILE__).'/mail/smtp.php';
require_once dirname(__FILE__).'/mail/pop3.php';
require_once dirname(__FILE__).'/mail/imap.php';

/**
 * Mail API factory. This is a factory class with 
 * methods that will load up SMTP, IMAP, POP3
 *
 * @package    Eden
 * @category   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Mail IMAP
	 *
	 * @param string
	 * @param string
	 * @return Eden_Mail_Imap
	 */
	public function imap($host, $user, $pass, $port = NULL, $ssl = false, $tls = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'int', 'null')
			->argument(5, 'bool')
			->argument(6, 'bool');
			
		return Eden_Mail_Imap::i($host, $user, $pass, $port, $ssl, $tls);
	}
	
	/**
	 * Returns Mail POP3
	 *
	 * @param string
	 * @param string
	 * @return Eden_Mail_Pop3
	 */
	public function pop3($host, $user, $pass, $port = NULL, $ssl = false, $tls = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'int', 'null')
			->argument(5, 'bool')
			->argument(6, 'bool');
			
		return Eden_Mail_Pop3::i($host, $user, $pass, $port, $ssl, $tls);
	}
	
	/**
	 * Returns Mail SMTP
	 *
	 * @param string
	 * @param string
	 * @return Eden_Mail_Smtp
	 */
	public function smtp($host, $user, $pass, $port = NULL, $ssl = false, $tls = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'int', 'null')
			->argument(5, 'bool')
			->argument(6, 'bool');
			
		return Eden_Mail_Smtp::i($host, $user, $pass, $port, $ssl, $tls);
	}
		
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}