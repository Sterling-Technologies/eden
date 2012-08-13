<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 * Abstract definition for common image manipulations per image. 
 * PHP is not limited to creating just HTML output. It can also be 
 * used to create and manipulate image files in a variety of 
 * different image formats, including GIF, PNG, JPEG, WBMP, and 
 * XPM. Even more convenient, PHP can output image streams directly 
 * to a browser. You will need to compile PHP with the GD library 
 * of image functions for this to work. GD and PHP may also require 
 * other libraries, depending on which image formats you want to 
 * work with. 
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Image extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_resource 	= NULL;
	protected $_width		= 0;
	protected $_height		= 0;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($data, $type = NULL, $path = true, $quality = 75) {
		Eden_Image_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null')
			->argument(3, 'bool')
			->argument(4, 'int');
			
		$this->_type = $type;
		
		//some render functions allow you 
		//to set the quality of the render
		$this->_quality = $quality;
		
		//create the resource
		$this->_resource = $this->_getResource($data, $path);
		
		//set the initial with and height
		list($this->_width, $this->_height) = $this->getDimensions();
	}
	
	public function __destruct() {
		if($this->_resource) {
			imagedestroy($this->_resource);
		}
	}
	
	public function __toString() {
		#imagepng() - Output a PNG image to either the browser or a file
	    #imagegif() - Output image to browser or file
		#imagewbmp() - Output image to browser or file
		#imagejpeg() - Output image to browser or file
		ob_start();
		switch($this->_type) {
			case 'gif':
				imagegif($this->_resource);
				break;
			case 'png':
				$quality = (100 - $this->_quality) / 10;
				
				if($quality > 9) {
					$quality = 9;
				}
				
				imagepng($this->_resource, NULL, $quality);
				break;
			case 'bmp':
			case 'wbmp':
				imagewbmp($this->_resource, NULL, $this->_quality);
				break;
			case 'jpg':
			case 'jpeg':
			case 'pjpeg':
			default:
				imagejpeg($this->_resource, NULL, $this->_quality);
				break;
			
		}
		
		return ob_get_clean();
		
	}
	
	/* Public Methods
	-------------------------------*/			
	/**
	 * Applies the selective blur filter. Blurs the image
	 *
	 * @return Eden_Image_Model
	 */
	public function blur() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_SELECTIVE_BLUR);
		
		return $this;
	}
	
	/**
	 * Applies the brightness filter. Changes the brightness of the image.
	 *
	 * @param *number level
	 * @return Eden_Image_Model
	 */
	public function brightness($level) {
		//Argument 1 must be a number
		Eden_Image_Error::i()->argument(1, 'numeric');
		
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_BRIGHTNESS, $level);
		
		return $this;
	}
		
	/**
	 * Applies the colorize filter. Like greyscale except you can specify the color.
	 *
	 * @param *number red
	 * @param *number blue
	 * @param *number green
	 * @param number alpha
	 * @return Eden_Image_Model
	 */
	public function colorize($red, $blue, $green, $alpha = 0) {
		//argument test
		Eden_Image_Error::i()
			->argument(1, 'numeric')	//Argument 1 must be a number
			->argument(2, 'numeric')	//Argument 2 must be a number
			->argument(3, 'numeric')	//Argument 3 must be a number
			->argument(4, 'numeric');	//Argument 4 must be a number
		
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_COLORIZE, $red, $blue, $green, $alpha);
		
		return $this;
	}
		
	/**
	 * Applies the contrast filter. Changes the contrast of the image. 
	 *
	 * @param *number level
	 * @return Eden_Image_Model
	 */
	public function contrast($level) {
		//Argument 1 must be a number
		Eden_Image_Error::i()->argument(1, 'numeric');
		
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_CONTRAST, $level);
		
		return $this;
	}

	/**
	 * Crops the image
	 *
	 * @param int|null the width; if null will use the original width
	 * @param int|null the height; if null will use the original height
	 * @return Eden_Image_Model
	 */
	public function crop($width = NULL, $height = NULL) {
		//argument test
		Eden_Image_Error::i()
			->argument(1, 'numeric', 'null')	//Argument 1 must be a number or null
			->argument(2, 'numeric', 'null');	//Argument 2 must be a number or null
		
		//get the source width and height
		$orgWidth = imagesx($this->_resource);
		$orgHeight = imagesy($this->_resource);
		
		//set the width if none is defined
		if(is_null($width)) {
			$width = $orgWidth;
		}
		
		//set the height if none is defined
		if(is_null($height)) {
			$height = $orgHeight;
		}
		
		//if the width and height are the same as the originals
		if($width == $orgWidth && $height == $orgHeight) {
			//there's no need to process
			return $this;
		}
		
		//if we are here then we do need to crop
		//create the new resource with the width and height
		$crop = imagecreatetruecolor($width, $height);
		
		//set some defaults
		$xPosition = 0;
		$yPosition = 0;
		
		//if the width is greater than the original width
		//or if the height is greater than the original height
		if($width > $orgWidth || $height > $orgHeight) {
			//save the destination width and height
			//because they will change here
			$newWidth = $width;
			$newHeight = $height;
			
			//if the desired height is larger than the desired width
			if($height > $width) {
				//and adjust the height instead
				$height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
				//if the aspect height is bigger than the desired height
				if($newHeight > $height) {
					//set it back to the desired height
					$height = $newHeight;
					//and adjust the width instead
					$width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
					//now because of the way GD renders we need to find the ratio of desired
					//height if it was brought down to the original height
					$rWidth = $this->_getWidthAspectRatio($newWidth, $newHeight, $orgHeight);
					//set the x Position of the source to the center of the
					//original width image width minus half the rWidth width
					$xPosition = ($orgWidth / 2) - ($rWidth / 2);
				} else {
					//now because of the way GD renders we need to find the ratio of desired
					//height if it was brought down to the original height
					$rHeight = $this->_getHeightAspectRatio($newWidth, $newHeight, $orgWidth);
					//set the y Position of the source to the center of the 
					//new sized image height minus half the desired height
					$yPosition = ($orgHeight / 2) - ($rHeight / 2) ;
				}
			//if the desired height is smaller than the desired width
			} else {
				//get the width aspect ratio
				$width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
				//if the aspect height is bigger than the desired height
				if($newWidth > $width) {
					//set it back to the desired height
					$width = $newWidth;
					//and adjust the width instead
					$height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
					//now because of the way GD renders we need to find the ratio of desired
					//height if it was brought down to the original height
					$rHeight = $this->_getHeightAspectRatio($newWidth, $newHeight, $orgWidth);
					//set the y Position of the source to the center of the 
					//new sized image height minus half the desired height
					$yPosition = ($orgHeight / 2) - ($rHeight / 2) ;
				} else {
					//now because of the way GD renders we need to find the ratio of desired
					//height if it was brought down to the original height
					$rWidth = $this->_getWidthAspectRatio($newWidth, $newHeight, $orgHeight);
					//set the x Position of the source to the center of the
					//original width image width minus half the rWidth width
					$xPosition = ($orgWidth / 2) - ($rWidth / 2);
				}
			}
		} else {
			//if the width is less than the original width
			if($width < $orgWidth) {
				//set the x Position of the source to the center of the
				//original image width minus half the desired width
				$xPosition = ($orgWidth / 2) - ($width / 2);
				//set the destination width to be the original width 
				$width = $orgWidth;
			}
			
			//if the height is less than the original height
			if($height < $orgHeight) {
				//set the y Position of the source to the center of the 
				//original image height minus half the desired height
				$yPosition = ($orgHeight / 2) - ($height / 2);
				//set the destination height to be the original height 
				$height = $orgHeight;
			}
		}
		
		//render the image
		imagecopyresampled($crop, $this->_resource, 0, 0, $xPosition, $yPosition, $width, $height, $orgWidth, $orgHeight);
		
		//destroy the original resource
		imagedestroy($this->_resource);
		
		//assign the new resource
		$this->_resource = $crop;
		
		return $this;
	}

	/**
	 * Applies the edgedetect filter. Uses edge detection to highlight the edges in the image. 
	 *
	 * @return Eden_Image_Model
	 */
	public function edgedetect() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_EDGEDETECT);
		
		return $this;
	}
	
	/**
	 * Applies the emboss filter. Embosses the image. 
	 *
	 * @return Eden_Image_Model
	 */
	public function emboss() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_EMBOSS);
		
		return $this;
	}
	
	/**
	 * Applies the gaussian blur filter. Blurs the image using the Gaussian method. 
	 *
	 * @return Eden_Image_Model
	 */
	public function gaussianBlur() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_GAUSSIAN_BLUR);
		
		return $this;
	}
	
	/**
	 * Returns the size of the image
	 *
	 * @return array
	 */
	public function getDimensions() {
		return array(imagesx($this->_resource), imagesy($this->_resource));
	}
	
	/**
	 * Returns the resource for custom editing
	 *
	 * @return [RESOURCE]
	 */
	public function getResource() {
		return $this->_resource;
	}
		
	/**
	 * Applies the greyscale filter. Converts the image into grayscale. 
	 *
	 * @return Eden_Image_Model
	 */
	public function greyscale() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_GRAYSCALE);
		
		return $this;
	}
	
	/**
	 * Inverts the image.
	 *
	 * @param bool if true invert vertical; if false invert horizontal
	 * @return Eden_Image_Model
	 */
	public function invert($vertical = false) {
		//Argument 1 must be a boolean
		Eden_Image_Error::i()->argument(1, 'bool');
		
		//get the source width and height
		$orgWidth = imagesx($this->_resource);
		$orgHeight = imagesy($this->_resource);
		
		$invert = imagecreatetruecolor($orgWidth, $orgHeight);
		
		if($vertical) {
			imagecopyresampled($invert, $this->_resource, 0, 0, 0, ($orgHeight-1), $orgWidth, $orgHeight, $orgWidth, 0-$orgHeight);
		} else {
			imagecopyresampled($invert, $this->_resource, 0, 0, ($orgWidth-1), 0, $orgWidth, $orgHeight, 0-$orgWidth, $orgHeight);
		}
		
		//destroy the original resource
		imagedestroy($this->_resource);
		
		//assign the new resource
		$this->_resource = $invert;
		
		return $this;
	}
	
	/**
	 * Applies the mean removal filter. Uses mean removal to achieve a "sketchy" effect. 
	 *
	 * @return Eden_Image_Model
	 */
	public function meanRemoval() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_MEAN_REMOVAL);
		
		return $this;
	}
	
	/**
	 * Applies the greyscale filter. Reverses all colors of the image. 
	 *
	 * @return Eden_Image_Model
	 */
	public function negative() {
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_NEGATE);
		
		return $this;
	}
	
	/**
	 * Resizes the image. This is a version of
	 * scale but keeping it's original aspect ratio
	 *
	 * @param int|null the width; if null will use the original width
	 * @param int|null the height; if null will use the original height
	 * @return Eden_Image_Model
	 */
	public function resize($width = NULL, $height = NULL) {
		//argument test
		Eden_Image_Error::i()
			->argument(1, 'numeric', 'null')	//Argument 1 must be a number or null
			->argument(2, 'numeric', 'null');	//Argument 2 must be a number or null
		
		//get the source width and height
		$orgWidth = imagesx($this->_resource);
		$orgHeight = imagesy($this->_resource);
		
		//set the width if none is defined
		if(is_null($width)) {
			$width = $orgWidth;
		}
		
		//set the height if none is defined
		if(is_null($height)) {
			$height = $orgHeight;
		}
		
		//if the width and height are the same as the originals
		if($width == $orgWidth && $height == $orgHeight) {
			//there's no need to process
			return $this;
		}
		
		$newWidth = $width;
		$newHeight = $height;
		
		//if the desired height is larger than the desired width
		if($height < $width) {
			//get the width aspect ratio
			$width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
			//if the aspect width is bigger than the desired width
			if($newWidth < $width) {
				//set it back to the desired width
				$width = $newWidth;
				//and adjust the height instead
				$height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
			}
		//if the desired height is smaller than the desired width
		} else {
			//get the width aspect ratio
			$height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
			//if the aspect height is bigger than the desired height
			if($newHeight < $height) {
				//set it back to the desired height
				$height = $newHeight;
				//and adjust the width instead
				$width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
			}
		}
		
		return $this->scale($width, $height);
	}
	
	/**
	 * Rotates the image.
	 *
	 * @param *int the degree to rotate by
	 * @param int background color code
	 * @return Eden_Image_Model
	 */
	public function rotate($degree, $background = 0) {
		//argument test
		Eden_Image_Error::i()
			->argument(1, 'numeric')	//Argument 1 must be a number
			->argument(2, 'numeric');	//Argument 2 must be a number
		
		//rotate the image
		$rotate = imagerotate($this->_resource, $degree, $background);
		
		//destroy the original resource
		imagedestroy($this->_resource);
		
		//assign the new resource
		$this->_resource = $rotate;
		
		return $this;
	}
	
	/**
	 * Scales the image. If width or height is set 
	 * to NULL a width or height will be auto determined based on the 
	 * aspect ratio
	 *
	 * @param int|null the width; if null will use the original width
	 * @param int|null the height; if null will use the original height
	 * @return Eden_Image_Model
	 */
	public function scale($width = NULL, $height = NULL) {
		//argument test
		Eden_Image_Error::i()
			->argument(1, 'numeric', 'null')	//Argument 1 must be a number or null
			->argument(2, 'numeric', 'null');	//Argument 2 must be a number or null
		
		//get the source width and height
		$orgWidth = imagesx($this->_resource);
		$orgHeight = imagesy($this->_resource);
		
		//set the width if none is defined
		if(is_null($width)) {
			$width = $orgWidth;
		}
		
		//set the height if none is defined
		if(is_null($height)) {
			$height = $orgHeight;
		}
		
		//if the width and height are the same as the originals
		if($width == $orgWidth && $height == $orgHeight) {
			//there's no need to process
			return $this;
		}
		
		//if we are here then we do need to crop
		//create the new resource with the width and height
		$scale = imagecreatetruecolor($width, $height);
		
		//render the image
		imagecopyresampled($scale, $this->_resource, 0, 0, 0, 0, $width, $height, $orgWidth, $orgHeight);
		
		//destroy the original resource
		imagedestroy($this->_resource);
		
		//assign the new resource
		$this->_resource = $scale;
		
		return $this;
	}
	
	public function setTransparency() {
		imagealphablending( $this->_resource, false );
		imagesavealpha( $this->_resource, true );
		
		return $this;
	}
	
	/**
	 * Applies the smooth filter. Makes the image smoother. 
	 *
	 * @param *number level
	 * @return Eden_Image_Model
	 */
	public function smooth($level) {
		//Argument 1 must be a number
		Eden_Image_Error::i()->argument(1, 'numeric');
		
		//apply filter
		imagefilter($this->_resource, IMG_FILTER_SMOOTH, $level);
		
		return $this;
	}
	
	/**
	 * Saves the image data to a file
	 *
	 * @param *string the path to save to
	 * @param string|null the render type
	 * @return this
	 */
	public function save($path, $type = NULL) {
		#imagepng() - Output a PNG image to either the browser or a file
	    #imagegif() - Output image to browser or file
		#imagewbmp() - Output image to browser or file
		#imagejpeg() - Output image to browser or file
		//$path = Eden_Path::i()->getAbsolute($path);
		
		if(!$type) {
			$type = $this->_type;
		}
		
		switch($type) {
			case 'gif':
				imagegif($this->_resource, $path);
				break;
			case 'png':
				$quality = (100 - $this->_quality) / 10;
				
				if($quality > 9) {
					$quality = 9;
				}
				
				imagepng($this->_resource, $path, $quality);
				break;
			case 'bmp':
			case 'wbmp':
				imagewbmp($this->_resource, $path, $this->_quality);
				break;
			case 'jpg':
			case 'jpeg':
			case 'pjpeg':
			default:
				imagejpeg($this->_resource, $path, $this->_quality);
				break;
			
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getHeightAspectRatio($sourceWidth, $sourceHeight, $destinationWidth) {
		$ratio = $destinationWidth / $sourceWidth;
		return  $sourceHeight * $ratio;
	}
	
	protected function _getResource($data, $path) {
		//if the GD Library is not installed
		if(!function_exists('gd_info')) {
			//throw error
			Eden_Image_Error::i(Eden_Image_Error::GD_NOT_INSTALLED)->trigger();
		}
		
		# imagecreatefromgd — Create a new image from GD file or URL
		# imagecreatefromgif — Create a new image from file or URL
		# imagecreatefromjpeg — Create a new image from file or URL
		# imagecreatefrompng — Create a new image from file or URL
		# imagecreatefromstring — Create a new image from the image stream in the string
		# imagecreatefromwbmp — Create a new image from file or URL
		# imagecreatefromxbm — Create a new image from file or URL
		# imagecreatefromxpm — Create a new image from file or URL
		
		$resource = false;
		
		if(!$path) {
			return imagecreatefromstring($data);
		}
		
		//depending on the extension lets load 
		//the file using the right GD loader
		switch($this->_type) {
			case 'gd':
				$resource = imagecreatefromgd($data);
				break;
			case 'gif':
				$resource = imagecreatefromgif($data);
				break;
			case 'jpg':
			case 'jpeg':
			case 'pjpeg':
				$resource = imagecreatefromjpeg($data);
				break;
			case 'png':
				$resource = imagecreatefrompng($data);
				break;
			case 'bmp':
			case 'wbmp':
				$resource = imagecreatefromwbmp($data);
				break;
			case 'xbm':
				$resource = imagecreatefromxbm($data);
				break;
			case 'xpm':
				$resource = imagecreatefromxpm($data);
				break;
		}
		
		//if there is no resource still
		if(!$resource) {
			//throw error
			Eden_Image_Error::i()
				->setMessage(Eden_Image_Error::NOT_VALID_IMAGE_FILE) 
				->addVariable($path);
		}
		
		return $resource;
	}
	
	protected function _getWidthAspectRatio($sourceWidth, $sourceHeight, $destinationHeight) {
		$ratio = $destinationHeight / $sourceHeight;
		return  $sourceWidth * $ratio;
	}
	
	/* Private Methods
	-------------------------------*/
}

/**
 * Image exception
 */
class Eden_Image_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const GD_NOT_INSTALLED 		= 'PHP GD Library is not installed.';
	const NOT_VALID_IMAGE_FILE 	= '%s is not a valid image file.';
	const NOT_STRING_MODEL 		= 'Argument %d is expecting a string or Eden_Image_Model.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}