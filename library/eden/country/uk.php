<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * United Kingdom
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Country_Uk extends Eden_Class {
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
	 * Returns a list of counties
	 *
	 * @return array
	 */
	public function getCounties() {
		return self::$_counties;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	/* Large Data
	-------------------------------*/
	protected static $_counties = array(
	'Aberdeenshire', 				'Alderney', 
	'Angus/Forfarshire',			'Argyllshire', 
	'Avon',							'Ayrshire', 
	'Banffshire', 					'Bedfordshire', 
	'Berkshire', 					'Berwickshire', 
	'Buckinghamshire',				'Buteshire', 
	'Caithness', 					'Cambridgeshire', 
	'Cheshire', 					'Clackmannanshire', 
	'Clwyd', 						'Cornwall', 
	'County Antrim', 				'County Armagh', 
	'County Down', 					'County Fermanagh', 
	'County Londonderry', 			'County Tyrone', 
	'Cumbria', 						'Derbyshire', 
	'Devon', 						'Dorset', 
	'Dumbartonshire', 				'Dumfriesshire', 
	'Durham', 						'Dyfed', 
	'East Lothian', 				'East Sussex', 
	'East Yorkshire', 				'Essex', 
	'Fair Isle', 					'Fife', 
	'Gloucestershire', 				'Greater London', 
	'Greater Manchester', 			'Guernsey', 
	'Gwent', 						'Gwynedd', 
	'Hampshire', 					'Herefordshire', 
	'Herm', 						'Hertfordshire', 
	'Huntingdonshire', 				'Inner Hebrides', 
	'Inverness-shire', 				'Isle of Man', 
	'Isle of Wight', 				'Isles of Scilly', 
	'Jersey', 						'Kent', 
	'Kincardineshire', 				'Kinross-shire', 
	'Kirkcudbrightshire', 			'Lanarkshire', 
	'Lancashire', 					'Leicestershire', 
	'Lincolnshire', 				'Merseyside', 
	'Mid Glamorgan', 				'Middlesex', 
	'Midlothian/Edinburghshire',	'Morayshire', 
	'Nairnshire', 					'Norfolk', 
	'North Yorkshire', 				'Northamptonshire', 
	'Northumberland', 				'Nottinghamshire', 
	'Orkney', 						'Outer Hebrides', 
	'Oxfordshire', 					'Peeblesshire', 
	'Perthshire', 					'Powys', 
	'Renfrewshire', 				'Ross-shire', 
	'Roxburghshire', 				'Rutland', 
	'Sark', 						'Selkirkshire', 
	'Shetland', 					'Shropshire', 
	'Somerset', 					'South Glamorgan', 
	'South Yorkshire', 				'Staffordshire', 
	'Stirlingshire', 				'Suffolk', 
	'Surrey', 						'Sutherland', 
	'Tyne and Wear', 				'Warwickshire', 
	'West Glamorgan', 				'West Lothian/Linlithgowshire', 
	'West Midlands', 				'West Sussex', 
	'West Yorkshire', 				'Wigtownshire', 
	'Wiltshire', 					'Worcestershire');
}