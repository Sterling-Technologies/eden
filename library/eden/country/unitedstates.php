<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * United States
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Country_Unitedstates extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_codes = array(
		'AK9950099929', 'AL3500036999', 'AR7160072999', 'AR7550275505',
		'AZ8500086599', 'CA9000096199', 'CO8000081699', 'CT0600006999',
		'DC2000020099', 'DC2020020599', 'DE1970019999', 'FL3200033999',
		'FL3410034999', 'GA3000031999', 'HI9670096798', 'HI9680096899',
		'IA5000052999', 'ID8320083899', 'IL6000062999', 'IN4600047999',
		'KS6600067999', 'KY4000042799', 'KY4527545275', 'LA7000071499',
		'LA7174971749', 'MA0100002799', 'MD2033120331', 'MD2060021999',
		'ME0380103801', 'ME0380403804', 'ME0390004999', 'MI4800049999',
		'MN5500056799', 'MO6300065899', 'MS3860039799', 'MT5900059999',
		'NC2700028999', 'ND5800058899', 'NE6800069399', 'NH0300003803',
		'NH0380903899', 'NJ0700008999', 'NM8700088499', 'NV8900089899',
		'NY0040000599', 'NY0639006390', 'NY0900014999', 'OH4300045999',
		'OK7300073199', 'KY7340074999', 'OR9700097999', 'PA1500019699',
		'RI0280002999', 'RI0637906379', 'SC2900029999', 'SD5700057799',
		'TN3700038599', 'TN7239572395', 'TX7330073399', 'TX7394973949',
		'TX7500079999', 'TX8850188599', 'UT8400084799', 'VA2010520199',
		'VA2030120301', 'VA2037020370', 'VA2200024699', 'VT0500005999',
		'WA9800099499', 'WI4993649936', 'WI5300054999', 'WV2470026899',
		'WY8200083199');
		
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
	 * Returns a list of US territories
	 *
	 * @return array
	 */
	public function getTerritories() {
		return include(dirname(__FILE__).'/unitedstates/territories.php');
	}
	
	/**
	 * Returns a list of US states
	 *
	 * @return array
	 */
	public function getStates() {
		return include(dirname(__FILE__).'/unitedstates/states.php');
	}
	
	/**
	 * Returns a state abbreviation based on zip code
	 *
	 * @param int
	 * @return string
	 */
	public function getStateFromPostal($postal) {
		Eden_Country_Error::i()->argument(1, 'int');
		
		if(strlen((string) $postal) < 5) {
			return false;
		}
							
		for($i=0; $i < count(self::$_codes); $i++) {
			if($postal < substr(self::$_codes[$i],2,5) 
			|| $postal > substr(self::$_codes[$i],7,5)) {
				continue;
			}
			
			return substr(self::$_codes[$i], 0, 2);
		}
		
		return false;
							
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}