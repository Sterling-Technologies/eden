<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/country/error.php';
require_once dirname(__FILE__).'/country/unitedstates.php';
require_once dirname(__FILE__).'/country/canada.php';
require_once dirname(__FILE__).'/country/unitedkingdom.php';
require_once dirname(__FILE__).'/country/australia.php';

/**
 * Country Factory
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Country extends Eden_Class {
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
	public function unitedStates() {
		return Eden_Country_Unitedstates::i();
	}
	
	public function canada() {
		return Eden_Country_Canada::i();
	}
	
	public function unitedKingdom() {
		return Eden_Country_Unitedkingdom::i();
	}
	
	public function australia() {
		return Eden_Country_Australia::i();
	}
	
	public function getList() {
		return include(dirname(__FILE__).'/country/data.php');
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}