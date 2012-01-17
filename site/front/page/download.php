<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 */
class Front_Page_Download extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden - Downloads';
	protected $_class = 'download';
	protected $_template = '/download.php';
	
	protected $_core = array(
		'Eden_Class',
		'Eden_Error',
		'Eden_Event',
		'Eden_Error_Event',
		'Eden_Route_Error',
		'Eden_Route_Class',
		'Eden_Route_Method',
		'Eden_Route_Function',
		'Eden_Route',
		'Eden_When',
		'Eden_Tool', 
		'Eden_Loader',
		'Eden_Type',
		'Eden_Type_Abstract',
		'Eden_Type_Error',
		'Eden_Type_Array',
		'Eden_Type_String',
		'Eden_Collection',
		'Eden_Curl',
		'Eden_Path',
		'Eden_File',
		'Eden_Folder',
		'Eden_Block',
		'Eden_Model',
		'Eden');
	
	protected $_utilities = array(
		'Eden_Template',
		'Eden_Session',
		'Eden_Cookie',
		'Eden_Registry',
		'Eden_Image',
		'Eden_Unit',
		'Eden_Validation');

	protected $_mysql = array(
		'Eden_Sql_Error',
		'Eden_Mysql_Error',
		'Eden_Sql_Database',
		'Eden_Sql_Query',
		'Eden_Sql_Delete',
		'Eden_Sql_Select',
		'Eden_Sql_Update',
		'Eden_Sql_Insert',
		'Eden_Sql_Collection',
		'Eden_Sql_Model',
		'Eden_Sql_Search',
		'Eden_Mysql_Alter',
		'Eden_Mysql_Create',
		'Eden_Mysql_Subselect',
		'Eden_Mysql_Utility',
		'Eden_Mysql');
		
	protected $_postgre = array(
		'Eden_Sql_Error',
		'Eden_Postgre_Error',
		'Eden_Sql_Database',
		'Eden_Sql_Query',
		'Eden_Sql_Delete',
		'Eden_Sql_Select',
		'Eden_Sql_Update',
		'Eden_Sql_Insert',
		'Eden_Sql_Collection',
		'Eden_Sql_Model',
		'Eden_Sql_Search',
		'Eden_Postgre_Alter',
		'Eden_Postgre_Create',
		'Eden_Postgre_Delete',
		'Eden_Postgre_Insert',
		'Eden_Postgre_Select',
		'Eden_Postgre_Update',
		'Eden_Postgre_Utility',
		'Eden_Postgre');
		
	protected $_sqlite = array(
		'Eden_Sql_Error',
		'Eden_Sqlite_Error',
		'Eden_Sql_Database',
		'Eden_Sql_Query',
		'Eden_Sql_Delete',
		'Eden_Sql_Select',
		'Eden_Sql_Update',
		'Eden_Sql_Insert',
		'Eden_Sql_Collection',
		'Eden_Sql_Model',
		'Eden_Sql_Search',
		'Eden_Sqlite_Alter',
		'Eden_Sqlite_Create',
		'Eden_Sqlite_Utility',
		'Eden_Sqlite');
		
	protected $_cache = array(
		'Eden_Cache',
		'Eden_Apc',
		'Eden_Memcache');
	
	protected $_mail = array(
		'Eden_Mail',
		'Eden_Mail_Error',
		'Eden_Mail_Imap',
		'Eden_Mail_Pop3',
		'Eden_Mail_Smtp');
	
	protected $_amazon = array(
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Amazon_Error',
		'Eden_Amazon_S3');
		
	protected $_eventbrite = array(
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Eventbrite',
		'Eden_Eventbrite_Error',
		'Eden_Eventbrite_Base',
		'Eden_Eventbrite_Discount',
		'Eden_Eventbrite_Event',
		'Eden_Eventbrite_Organizer',
		'Eden_Eventbrite_Payment',
		'Eden_Eventbrite_Ticket',
		'Eden_Eventbrite_User',
		'Eden_Eventbrite_Venue',
		'Eden_Eventbrite_Event_Search',
		'Eden_Eventbrite_Event_Set');
	
	protected $_facebook = array(
		'Eden_Facebook',
		'Eden_Facebook_Auth',
		'Eden_Facebook_Graph',
		'Eden_Facebook_Post',
		'Eden_Facebook_Select',
		'Eden_Facebook_Search',
		'Eden_Facebook_Fql');
		
	protected $_getsatisfaction = array(
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Getsatisfaction',
		'Eden_Getsatisfaction_Error',
		'Eden_Getsatisfaction_Base',
		'Eden_Getsatisfaction_Company',
		'Eden_Getsatisfaction_Detail',
		'Eden_Getsatisfaction_Oauth',
		'Eden_Getsatisfaction_People',
		'Eden_Getsatisfaction_Post',
		'Eden_Getsatisfaction_Product',
		'Eden_Getsatisfaction_Replies',
		'Eden_Getsatisfaction_Tag',
		'Eden_Getsatisfaction_Topic');
	
	protected $_paypal = array(
		'Eden_Paypal_Error',
		'Eden_Paypal_Base',
		'Eden_Paypal_Authorization',
		'Eden_Paypal_Billing',
		'Eden_Paypal_Checkout',
		'Eden_Paypal_Direct',
		'Eden_Paypal_Recurring',
		'Eden_Paypal_Transaction');
	
	protected $_jabber = array('Eden_Jabber');
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i(Eden_Registry $request = NULL) {
		return self::_getMultiple(__CLASS__, $request);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		if (!defined('T_ML_COMMENT')) {
		   define('T_ML_COMMENT', T_COMMENT);
		} else {
		   define('T_DOC_COMMENT', T_ML_COMMENT);
		}
		
		$package = $this->_request['post']['package'];
		
		if(!empty($package)) {
			$classes = $this->_core;
			
			if($package->inArray('utilities')) {
				$classes = array_merge($classes, $this->_utilities);
			}
			
			if($package->inArray('mail')) {
				$classes = array_merge($classes, $this->_mail);
			}
			
			if($package->inArray('mysql')) {
				$classes = array_merge($classes, $this->_mysql);
			}
			
			if($package->inArray('postgre')) {
				$classes = array_merge($classes, $this->_postgre);
			}
			
			if($package->inArray('sqlite')) {
				$classes = array_merge($classes, $this->_sqlite);
			}
			
			if($package->inArray('cache')) {
				$classes = array_merge($classes, $this->_cache);
			}
			
			if($package->inArray('amazon')) {
				$classes = array_merge($classes, $this->_amazon);
			}
			
			if($package->inArray('eventbrite')) {
				$classes = array_merge($classes, $this->_eventbrite);
			}
			
			if($package->inArray('facebook')) {
				$classes = array_merge($classes, $this->_facebook);
			}
			
			if($package->inArray('getsatisfaction')) {
				$classes = array_merge($classes, $this->_getsatisfaction);
			}
			
			if($package->inArray('paypal')) {
				$classes = array_merge($classes, $this->_paypal);
			}
			
			if($package->inArray('jabber')) {
				$classes = array_merge($classes, $this->_jabber);
			}
			
			$classes = array_unique($classes);
			
			$bundle = '<?php ';
			foreach($classes as $class) {
				$bundle .= "/* ".$class." */\n".$this->_getClass($class)."\n";
			}
			
			header('Content-Type: text/plain');
			header('Content-Length: '.strlen($bundle));
			header('Content-Disposition: attachment; filename="eden.php"');
			return $bundle;
		}
		
		return $this->_renderPage();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getClass($class) {	
		$path = strtolower('/'.str_replace('_', '/', $class)).'.php';
		$code = $this->File($this->_request['path']['library'].$path)->getContent();
			
		return $this->_getMinify($code);
	}
	
	protected function _getMinify($code) {
		$tokens = token_get_all($code);
		
		$minify = NULL;
		
		foreach ($tokens as $token) {
		   if (is_string($token)) {
			   // simple 1-character token
			   $minify .= $token;
			   continue;
		   }
		   
		   // token array
		   list($id, $text) = $token;
	
		   switch ($id) { 
			   case T_COMMENT: 
			   case T_ML_COMMENT: // we've defined this
			   case T_DOC_COMMENT: // and this
				   // no action on comments
				   break;
			   default:
				   // anything else -> output "as is"
				   $minify .= $text;
				   break;
		   }
		}
		
		$minify = str_replace('<?php', '', $minify);
		$minify = str_replace("\n", '', $minify);
		$minify = preg_replace("/\s\s+/is", ' ', $minify);
		$minify = preg_replace("/\s*\-\>\s*/is", '->', $minify);
		$minify = preg_replace("/\s*\=\>\s*/is", '=>', $minify);
		$minify = preg_replace("/\s*\=\s*/is", '=', $minify);
		$minify = preg_replace("/\s*\,\s*/is", ',', $minify);
		$minify = preg_replace("/\s*\{\s*/is", '{', $minify);
		$minify = preg_replace("/\s*\}\s*/is", '}', $minify);
		$minify = preg_replace("/\s*\;\s*/is", ';', $minify);
		$minify = preg_replace("/\s*\.\s*/is", '.', $minify);
		
		if(strpos($minify, 'function ') !== false 
		&& (strpos($minify, 'class ') === false 
		|| strpos($minify, 'function ') < strpos($minify, 'class '))) {
			$minify = substr($minify, strpos($minify, 'function '));
		} else if(strpos($minify, 'abstract ') !== false) {
			$minify = substr($minify, strpos($minify, 'abstract '));
		} else if(strpos($minify, 'class ') !== false) {
			$minify = substr($minify, strpos($minify, 'class '));
		}
		
		return $minify;
	}
	
	/* Private Methods
	-------------------------------*/
}