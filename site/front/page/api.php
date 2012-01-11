<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 */

/**
 * Default logic to output a page
 *
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: index.php 14 2010-01-13 03:39:03Z blanquera $
 */
class Front_Page_Api extends Front_Page {
	/* Constants
	-------------------------------*/
	const REPO_URL 	= 'http://svn.openovate.com/edenv2/trunk/library';
	const REPO_USER = 'cblanquera';
	const REPO_PASS = 'gphead';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden - API';
	protected $_class = 'api';
	protected $_template = '/api.php';
	
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
		$source 	= $this->_request['get']['source'];
		$pathArray 	= $this->_request['request']['variables']->get(false);
		$path 		= '/'.implode('/', $pathArray);
		$code 		= $minify =NULL;
		$notes 		= array();
		
		if($path == '/') {
			$path = NULL;
		}
		
		if(strpos($path, '.') !== false) {
			$code = $this->Eden_Curl()
				->setUrl(self::REPO_URL.$path)
				->setUserPwd(self::REPO_USER.':'.self::REPO_PASS)
				->setHttpAuth(CURLAUTH_BASIC)
				->getResponse();
			
			$minify = $this->_getMinify($code);
			
			$notes = strpos($path, '.php') ? $this->_getNotes($code) : array();
		}
		
		$this->_body = array(
			'minify'	=> $minify,
			'source'	=> $source,
			'path'		=> $path,
			'code' 		=> $code,
			'notes' 	=> $notes);
		
		return $this->_renderPage();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getNotes($code) {
		$lines = explode("\n", $code);
		$notes = array();
		$section = 'unknown';
		$class = 'unknown';
		foreach($lines as $i => $line) {
			if(preg_match("#-+\*/#", $line)) {
				$section = trim(str_replace('/*', '', $lines[$i-1]));
				$notes[$class][$section] = array();
				continue;
			}
			
			if(strpos(trim($line), '/**') === 0) {
				$doc = $this->_getJavaDoc($lines, $i);
				if($doc['meta']['type'] == 'class') {
					$class = $doc['meta']['name'];
					$notes[$class] = $doc;
					continue;
				}
				
				$notes[$class][$section][] = $doc;
				continue;
			} 
			
			if(strpos(trim($line), 'const') === 0) {
				list($key, $value) = explode('=', str_replace(array('const', ';', '\'', '"'), '', $line));
				if($value === true) {
					$value = 'true';
				} else if($value === false) {
					$value = 'false';
				} else if(is_null($value)) {
					$value = 'null';
				}
				$notes[$class]['Constants'][trim($key)] = trim($value);
				continue;
			}
			
			if(strpos(trim($line), 'public $') === 0) {
				list($key, $value) = explode('=', str_replace('public', '', $line));
				$notes[$class]['Public Properties'][] = trim($key);
				continue;
			}
			
			if(strpos(trim($line), 'protected $') === 0) {
				list($key, $value) = explode('=', str_replace('protected', '', $line));
				$notes[$class]['Public Properties'][] = trim($key);
				continue;
			}
			
			if(strpos(trim($line), 'private $') === 0) {
				list($key, $value) = explode('=', str_replace('private', '', $line));
				$notes[$class]['Public Properties'][] = trim($key);
				continue;
			}
		}
		
		return $notes;
	}
	
	protected function _getJavaDoc($lines, &$i) {
		$description = $code = NULL;
		$attributes = $meta = array();
		$meta['type'] = 'unknown';
		$mode = true;
		for($i++; $i < count($lines); $i++) {
			$line = trim(preg_replace("/^\s+\*\s*/", '', $lines[$i]));
			
			if($line == '/') {
				$i++;
				break;
			} 
			
			if(strpos($line, '@') === 0) {
				$mode = false;
				list($key, $value) = explode(' ', substr($line, 1), 2);
				if(isset($attributes[$key])) {
					if(!is_array($attributes[$key])) {
						$attributes[$key] = array($attributes[$key]);
					}
					
					$attributes[$key][] = trim($value);
					continue;
				}
				
				$attributes[$key] = trim($value);
				continue;
			}
			
			if(!$mode) {
				if(is_array($attributes[$key])) {
					$attributes[$key][count($attributes[$key])-1] .= ' '.$line;
					continue;
				}
				
				$attributes[$key] .= ' '.$line;
				continue;
			}
			
			$description[] = $line;
		}
		
		if(isset($lines[$i]) && strpos($lines[$i], 'class') !== false) {
			$meta = array(
				'name'			=> NULL,
				'type' 			=> 'class',
				'abstract' 		=> false,
				'extends' 		=> NULL,
				'implements' 	=> array());
				
			preg_match("/class\s([a-zA-Z0-9-_]+)/", $lines[$i], $matches);
			if(isset($matches[1])) {
				$meta['name'] = $matches[1];
			}
			
			preg_match("/extends\s([a-zA-Z0-9-_]+)/", $lines[$i], $matches);
			if(isset($matches[1])) {
				$meta['extends'] = $matches[1];
			}
			
			preg_match("/implements\s([a-zA-Z0-9-_\,\s]+)/", $lines[$i], $matches);
			if(isset($matches[1])) {
				$meta['implements'] = explode(',', $matches[1]);
			}
		}
		
		if(isset($lines[$i]) && strpos($lines[$i], 'function') !== false) {
			$meta = array(
				'name'			=> NULL,
				'type' 			=> 'function',
				'abstract' 		=> false,
				'static' 		=> false,
				'access' 		=> NULL);
			
			preg_match("/function\s([a-zA-Z0-9-_]+)/", $lines[$i], $matches);
			$meta['name'] = $matches[1];
			
			if(strpos($lines[$i], 'static') !== false) {
				$meta['static'] = true;
			}
			
			if(strpos($lines[$i], 'public') !== false) {
				$meta['access'] = 'public';
			}
			
			if(strpos($lines[$i], 'protected') !== false) {
				$meta['access'] = 'protected';
			}
			
			if(strpos($lines[$i], 'private') !== false) {
				$meta['access'] = 'private';
			}
		}
		
		if(isset($lines[$i]) && strpos($lines[$i], 'abstract') !== false) {
			$meta['abstract'] = true;
		}
		
		if(isset($lines[$i])) {
			$code = trim(preg_replace("/\s*\{/", '', $lines[$i]));
		}
			
		return array(
			'code' 			=> $code,
			'meta' 			=> $meta,
			'description' 	=> $description, 
			'attributes' 	=> $attributes);
	}
	
	protected function _getMinify($code) {
		if (!defined('T_ML_COMMENT')) {
		   define('T_ML_COMMENT', T_COMMENT);
		} else {
		   define('T_DOC_COMMENT', T_ML_COMMENT);
		}

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
		
		return $minify;
	}
	
	/* Private Methods
	-------------------------------*/
}
