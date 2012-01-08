<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Allows you to create JavaScript calls (not properties) in PHP
 *
 * @package    Eden
 * @subpackage javascript
 * @category   javascript
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: javascript.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Javascript extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function load() {
		return Eden_Javascript_Class::i();
	}
	
	public function render() {
		$args = func_get_args();
		return '<script type="text/javascript">'.implode(';', $args).'</script>';
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}