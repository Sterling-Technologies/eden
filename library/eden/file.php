<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/path.php';

/**
 * General available methods for common file 
 * manipulations and information per file
 *
 * @package    Eden
 * @category   path
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_File extends Eden_Path {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_path = NULL;
	
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
	 * Checks to see if this 
	 * path is a real file
	 *
	 * @return bool
	 */
	public function isFile() {
		return file_exists($this->_data);
	}
		
	/**
	 * Returns the base file name with out the extension
	 *
	 * @return string
	 */
	public function getBase() {
		$pathInfo = pathinfo($this->_data);
		return $pathInfo['filename'];
	}
		
	/**
	 * Returns the contents of a file given the path
	 *
	 * @param var default value if no file is found
	 * @return string
	 */
	public function getContent() {
		$this->absolute();
		
		//if the pat is not a real file
		if(!is_file($this->_data)) {
			//throw an exception
			Eden_File_Error::i()
				->setMessage(Eden_File_Error::PATH_IS_NOT_FILE)
				->addVariable($this->_data)
				->trigger();
		}
		
		return file_get_contents($this->_data);
	}
	
	/**
	 * Returns the executes the specified file and returns the final value
	 *
	 * @return *
	 */
	public function getData() {
		$this->absolute();
		
		return include($this->_data);
	}
		
	/**
	 * Returns the base file name extension
	 *
	 * @return string
	 */
	public function getExtension() {
		$pathInfo = pathinfo($this->_data);
		
		if(!isset($pathInfo['extension'])) {
			return NULL;	
		}
		
		return $pathInfo['extension'];
	}
		
	/**
	 * Returns the file path
	 *
	 * @return string
	 */
	public function getFolder() {
		return dirname($this->_data);
	}
	
	/**
	 * Returns the mime type of a file
	 *
	 * @return string
	 */
	public function getMime() {
		$this->absolute();
		
		//mime_content_type seems to be deprecated in some versions of PHP
		//if it does exist then lets use it
		if(function_exists('mime_content_type')) {
			return mime_content_type($this->_data);
		}
		
		//if not then use the replacement funciton fileinfo
		//see: http://www.php.net/manual/en/function.finfo-file.php
		if(function_exists('finfo_open')) {
			$resource = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($resource, $this->_data);
			finfo_close($finfo);
			
			return $mime;
		}
		
		//ok we have to do this manually
		//get this file extension
		$extension = strtolower($this->getExtension());
		
		//get the list of mimetypes stored locally
		$types = self::$_mimeTypes;
		//if this extension exissts in the types
		if(isset($types[$extension])) {
			//return the mimetype
			return $types[$extension];
		}
		
		//return text/plain by default
		return $types['class'];
	}
	
	/**
	 * Returns the file name
	 *
	 * @return string
	 */
	public function getName() {
		return basename($this->_data);
	}

	/**
	 * Returns the size of a file in bytes
	 *
	 * @return string
	 */
	public function getSize() {
		$this->absolute();
		
		return filesize($this->_data);
	}
	
	/**
	 * Returns the last time file was modified in UNIX time
	 *
	 * @return int
	 */
	public function getTime() {
		$this->absolute();
		
		return filemtime($this->_data);
	}
		
	/**
	 * Creates a file and puts specified content into that file
	 *
	 * @param string content
	 * @return bool
	 */
	public function setContent($content) {
		//argument 1 must be string
		Eden_File_Error::i()->argument(1, 'string');
		
		try {
			$this->absolute();
		} catch(Eden_Path_Error $e) {
			$this->touch();
		}
		
		file_put_contents($this->_data, $content);
		
		return $this;
	}
	
	/**
	 * Creates a php file and puts specified variable into that file
	 *
	 * @param string variable
	 * @return bool
	 */
	public function setData($variable) {
		return $this->setContent("<?php //-->\nreturn ".var_export($variable, true).";");
	}
		
	/**
	 * Removes a file
	 *
	 * @return bool
	 */
	public function remove() {
		$this->absolute();
		
		//if it's a file
		if(is_file($this->_data)) {
			//remove it
			unlink($this->_data);
			
			return $this;
		}
		
		return $this;
	}
	
	/**
	 * Touches a file (effectively creates the file if
	 * it doesn't exist and updates the date if it does)
	 *
	 * @return bool
	 */
	public function touch() {
		touch($this->_data);
		
		return $this;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	/* Large Data
	-------------------------------*/
	protected static $_mimeTypes = array(
	'ai' 		=> 'application/postscript',	    'aif' 		=> 'audio/x-aiff',
    'aifc' 		=> 'audio/x-aiff',				    'aiff' 		=> 'audio/x-aiff',
    'asc' 		=> 'text/plain',				    'atom' 		=> 'application/atom+xml',
    'au' 		=> 'audio/basic',				    'avi' 		=> 'video/x-msvideo',
    'bcpio' 	=> 'application/x-bcpio',		    'bin' 		=> 'application/octet-stream',
    'bmp' 		=> 'image/bmp',					    'cdf' 		=> 'application/x-netcdf',
    'cgm' 		=> 'image/cgm',					    'class' 	=> 'application/octet-stream',
    'cpio' 		=> 'application/x-cpio',		    'cpt' 		=> 'application/mac-compactpro',
    'csh' 		=> 'application/x-csh',			    'css' 		=> 'text/css',
    'dcr' 		=> 'application/x-director',	    'dif' 		=> 'video/x-dv',
    'dir' 		=> 'application/x-director',	    'djv' 		=> 'image/vnd.djvu',
    'djvu' 		=> 'image/vnd.djvu',			    'dll' 		=> 'application/octet-stream',
    'dmg' 		=> 'application/octet-stream',	    'dms' 		=> 'application/octet-stream',
    'doc' 		=> 'application/msword',		    'dtd' 		=> 'application/xml-dtd',
    'dv' 		=> 'video/x-dv',				    'dvi' 		=> 'application/x-dvi',
    'dxr' 		=> 'application/x-director',	    'eps' 		=> 'application/postscript',
    'etx' 		=> 'text/x-setext',				    'exe' 		=> 'application/octet-stream',
    'ez' 		=> 'application/andrew-inset',	    'gif' 		=> 'image/gif',
    'gram' 		=> 'application/srgs',			    'grxml' 	=> 'application/srgs+xml',
    'gtar' 		=> 'application/x-gtar',		    'hdf' 		=> 'application/x-hdf',
    'hqx' 		=> 'application/mac-binhex40',	    'htm' 		=> 'text/html',
    'html' 		=> 'text/html',					    'ice' 		=> 'x-conference/x-cooltalk',
    'ico' 		=> 'image/x-icon',				    'ics' 		=> 'text/calendar',
    'ief' 		=> 'image/ief',					    'ifb' 		=> 'text/calendar',
    'iges' 		=> 'model/iges',				    'igs' 		=> 'model/iges',
    'jnlp' 		=> 'application/x-java-jnlp-file',  'jp2' 		=> 'image/jp2',
    'jpe' 		=> 'image/jpeg',				    'jpeg' 		=> 'image/jpeg',
    'jpg' 		=> 'image/jpeg',				    'js' 		=> 'application/x-javascript',
    'kar' 		=> 'audio/midi',				    'latex' 	=> 'application/x-latex',
    'lha' 		=> 'application/octet-stream',	    'lzh' 		=> 'application/octet-stream',
    'm3u' 		=> 'audio/x-mpegurl',			    'm4a' 		=> 'audio/mp4a-latm',
    'm4b' 		=> 'audio/mp4a-latm',			    'm4p' 		=> 'audio/mp4a-latm',
    'm4u' 		=> 'video/vnd.mpegurl',			    'm4v' 		=> 'video/x-m4v',
    'mac' 		=> 'image/x-macpaint',			    'man' 		=> 'application/x-troff-man',
    'mathml' 	=> 'application/mathml+xml',	    'me' 		=> 'application/x-troff-me',
    'mesh' 		=> 'model/mesh',				    'mid' 		=> 'audio/midi',
    'midi' 		=> 'audio/midi',				    'mif' 		=> 'application/vnd.mif',
    'mov' 		=> 'video/quicktime',			    'movie' 	=> 'video/x-sgi-movie',
    'mp2' 		=> 'audio/mpeg',				    'mp3' 		=> 'audio/mpeg',
    'mp4' 		=> 'video/mp4',					    'mpe' 		=> 'video/mpeg',
    'mpeg' 		=> 'video/mpeg',				    'mpg' 		=> 'video/mpeg',
    'mpga' 		=> 'audio/mpeg',				    'ms' 		=> 'application/x-troff-ms',
    'msh' 		=> 'model/mesh',				    'mxu' 		=> 'video/vnd.mpegurl',
    'nc' 		=> 'application/x-netcdf',		    'oda' 		=> 'application/oda',
    'ogg' 		=> 'application/ogg',			    'pbm' 		=> 'image/x-portable-bitmap',
    'pct' 		=> 'image/pict',				    'pdb' 		=> 'chemical/x-pdb',
    'pdf' 		=> 'application/pdf',			    'pgm' 		=> 'image/x-portable-graymap',
    'pgn' 		=> 'application/x-chess-pgn',	    'pic' 		=> 'image/pict',
    'pict' 		=> 'image/pict',				    'png' 		=> 'image/png',
    'pnm' 		=> 'image/x-portable-anymap',	    'pnt' 		=> 'image/x-macpaint',
    'pntg' 		=> 'image/x-macpaint',			    'ppm' 		=> 'image/x-portable-pixmap',
    'ppt' 		=> 'application/vnd.ms-powerpoint', 'ps' 		=> 'application/postscript',
    'qt' 		=> 'video/quicktime',			    'qti' 		=> 'image/x-quicktime',
    'qtif' 		=> 'image/x-quicktime',			    'ra' 		=> 'audio/x-pn-realaudio',
    'ram' 		=> 'audio/x-pn-realaudio',		    'ras' 		=> 'image/x-cmu-raster',
    'rdf' 		=> 'application/rdf+xml',		    'rgb' 		=> 'image/x-rgb',
    'rm' 		=> 'application/vnd.rn-realmedia',  'roff' 		=> 'application/x-troff',
    'rtf' 		=> 'text/rtf',					    'rtx' 		=> 'text/richtext',
    'sgm' 		=> 'text/sgml',					    'sgml'		=> 'text/sgml',
    'sh' 		=> 'application/x-sh',			    'shar' 		=> 'application/x-shar',
    'silo' 		=> 'model/mesh',				    'sit' 		=> 'application/x-stuffit',
    'skd' 		=> 'application/x-koan',		    'skm' 		=> 'application/x-koan',
    'skp' 		=> 'application/x-koan',		    'skt' 		=> 'application/x-koan',
    'smi' 		=> 'application/smil',			    'smil' 		=> 'application/smil',
    'snd' 		=> 'audio/basic',				    'so' 		=> 'application/octet-stream',
    'spl' 		=> 'application/x-futuresplash',    'src' 		=> 'application/x-wais-source',
    'sv4cpio' 	=> 'application/x-sv4cpio',		    'sv4crc' 	=> 'application/x-sv4crc',
    'svg' 		=> 'image/svg+xml',				    'swf' 		=> 'application/x-shockwave-flash',
    't' 		=> 'application/x-troff',		    'tar' 		=> 'application/x-tar',
    'tcl' 		=> 'application/x-tcl',			    'tex' 		=> 'application/x-tex',
    'texi' 		=> 'application/x-texinfo',		    'texinfo' 	=> 'application/x-texinfo',
    'tif' 		=> 'image/tiff',				    'tiff' 		=> 'image/tiff',
    'tr' 		=> 'application/x-troff',		    'tsv' 		=> 'text/tab-separated-values',
    'txt' 		=> 'text/plain',				    'ustar' 	=> 'application/x-ustar',
    'vcd' 		=> 'application/x-cdlink',		    'vrml' 		=> 'model/vrml',
    'vxml' 		=> 'application/voicexml+xml',	    'wav' 		=> 'audio/x-wav',
    'wbmp' 		=> 'image/vnd.wap.wbmp',		    'wbmxl' 	=> 'application/vnd.wap.wbxml',
    'wml' 		=> 'text/vnd.wap.wml',			    'wmlc' 		=> 'application/vnd.wap.wmlc',
    'wmls' 		=> 'text/vnd.wap.wmlscript',	    'wmlsc' 	=> 'application/vnd.wap.wmlscriptc',
    'wrl'		=> 'model/vrml',				    'xbm' 		=> 'image/x-xbitmap',
    'xht' 		=> 'application/xhtml+xml',		    'xhtml' 	=> 'application/xhtml+xml',
    'xls' 		=> 'application/vnd.ms-excel',	    'xml' 		=> 'application/xml',
    'xpm' 		=> 'image/x-xpixmap',			    'xsl' 		=> 'application/xml',
    'xslt' 		=> 'application/xslt+xml',		    'xul' 		=> 'application/vnd.mozilla.xul+xml',
    'xwd' 		=> 'image/x-xwindowdump',		    'xyz' 		=> 'chemical/x-xyz',
    'zip' 		=> 'application/zip');	
}

/**
 * File Errors
 */
class Eden_File_Error extends Eden_Path_Error {
	/* Constants
	-------------------------------*/
	const PATH_IS_NOT_FILE 		= 'Path %s is not a file in the system.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}