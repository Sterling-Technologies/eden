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
	const INFO = 'svn info %s --xml --non-interactive 2>&1';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden - Downloads';
	protected $_class = 'download';
	protected $_template = '/download.phtml';
	
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
			foreach($package as $set) {
				$pack = '_'.$set;
				if(isset($this->$pack)) {
					$classes = array_merge($classes, $this->$pack);
				}
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
		
		$post = $this->_request['post']->get(false);
		
			
		//$library = 'http://svn.openovate.com/edenv2/trunk/library';
		$library = $this->_request['path']['library'];
		
		//get the revision
		exec(sprintf(self::INFO, $library), $info);
		$info = implode("\n", $info);
		$info = simplexml_load_string($info);
		$revision = (string)$info->entry->commit['revision'];
		
		if(isset($post['download'])) {		
			//check to see if this zip exists
			$zip = $this->_request['path']['web'].'/'.$revision.'.tar.gz';
			$file = $this->File($zip);
			
			//if it's not a file
			$library = $this->_request['path']['library'];
			if(!$file->isFile()) {
				exec('svn export '.$library.' '.$library.'/../../library;');
				exec('cd '.$library.'/../..; tar -cvzf '.$zip.' library;');
				exec('rm -rf '.$library.'/../../../library;');
			}
			
			header('Content-Type: text/plain');
			header('Content-Length: '.$file->getSize());
			header('Content-Disposition: attachment; filename="eden-v0.2.'.$revision.'.tar.gz"');
			return $file->getContent();
		}
		
		$this->_body['version'] = $revision;
		
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
	/* Large Data
	-------------------------------*/
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
		'Eden_Debug', 
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
		'Eden_Timezone_Error',
		'Eden_Timezone_Validation',
		'Eden_Timezone',
		'Eden_Country_Error',
		'Eden_Country_Au',
		'Eden_Country_Ca',
		'Eden_Country_Uk',
		'Eden_Country_Us',
		'Eden_Country',
		'Eden_Language');
	
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
		'Eden_Oauth',
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Amazon_Error',
		'Eden_Amazon_S3');
		
	protected $_eventbrite = array(
		'Eden_Oauth',
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
		'Eden_Facebook_Error',
		'Eden_Facebook_Auth',
		'Eden_Facebook_Graph',
		'Eden_Facebook_Post',
		'Eden_Facebook_Select',
		'Eden_Facebook_Search',
		'Eden_Facebook_Fql');
		
	protected $_getsatisfaction = array(
		'Eden_Oauth',
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
		'Eden_Getsatisfaction_Reply',
		'Eden_Getsatisfaction_Tag',
		'Eden_Getsatisfaction_Topic');
	
	protected $_tumblr = array(
		'Eden_Oauth',
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Tumblr',
		'Eden_Tumblr_Error',
		'Eden_Tumblr_Base',
		'Eden_Tumblr_Oauth',
		'Eden_Tumblr_Blog',
		'Eden_Tumblr_User');
	
	protected $_twitter = array(
		'Eden_Oauth',
		'Eden_Oauth_Error',
		'Eden_Oauth_Base',
		'Eden_Oauth_Consumer',
		'Eden_Twitter',
		'Eden_Twitter_Error',
		'Eden_Twitter_Base',
		'Eden_Twitter_Oauth',
		'Eden_Twitter_Accounts',
		'Eden_Twitter_Block',
		'Eden_Twitter_Directmessage',
		'Eden_Twitter_Favorites',
		'Eden_Twitter_Friends',
		'Eden_Twitter_Geo',
		'Eden_Twitter_Help',
		'Eden_Twitter_Legal',
		'Eden_Twitter_List',
		'Eden_Twitter_Localtrends',
		'Eden_Twitter_Notification',
		'Eden_Twitter_Saved',
		'Eden_Twitter_Search',
		'Eden_Twitter_Spam',
		'Eden_Twitter_Suggestions',
		'Eden_Twitter_Timelines',
		'Eden_Twitter_Trends',
		'Eden_Twitter_Tweets',
		'Eden_Twitter_Users');
	
	protected $_paypal = array(
		'Eden_Paypal_Error',
		'Eden_Paypal_Base',
		'Eden_Paypal_Authorization',
		'Eden_Paypal_Billing',
		'Eden_Paypal_Checkout',
		'Eden_Paypal_Direct',
		'Eden_Paypal_Recurring',
		'Eden_Paypal_Transaction',
		'Eden_Paypal');
	
	protected $_jabber = array('Eden_Jabber');
	
	protected $_xend = array(
		'Eden_Xend_Error',
		'Eden_Xend_Base',
		'Eden_Xend_Booking',
		'Eden_Xend_Rate',
		'Eden_Xend_Shipment',
		'Eden_Xend_Tracking',
		'Eden_Xend');
	
	protected $_authorizenet = array(
		'Eden_Authorizenet_Error',
		'Eden_Authorizenet_Base',
		'Eden_Authorizenet_Customer',
		'Eden_Authorizenet_Direct',
		'Eden_Authorizenet_Payment',
		'Eden_Authorizenet_Server',
		'Eden_Authorizenet_Recurring',
		'Eden_Authorizenet');
}