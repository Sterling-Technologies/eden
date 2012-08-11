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
require_once dirname(__FILE__).'/country/us.php';
require_once dirname(__FILE__).'/country/ca.php';
require_once dirname(__FILE__).'/country/uk.php';
require_once dirname(__FILE__).'/country/au.php';

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
	public function au() {
		return Eden_Country_Au::i();
	}
	
	public function ca() {
		return Eden_Country_Ca::i();
	}
	
	public function getList() {
		return self::$_countries;
	}
	
	public function uk() {
		return Eden_Country_Uk::i();
	}
	
	public function us() {
		return Eden_Country_Us::i();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
	/* Large Data
	-------------------------------*/
	protected static $_countries = array(
	'GB' => 'United Kingdom',					'US' => 'United States',
	'AF' => 'Afghanistan',						'AL' => 'Albania',
	'DZ' => 'Algeria',							'AS' => 'American Samoa',
	'AD' => 'Andorra',							'AO' => 'Angola',
	'AI' => 'Anguilla',							'AQ' => 'Antarctica',
	'AG' => 'Antigua And Barbuda',				'AR' => 'Argentina',
	'AM' => 'Armenia',							'AW' => 'Aruba',
	'AU' => 'Australia',						'AT' => 'Austria',
	'AZ' => 'Azerbaijan',						'BS' => 'Bahamas',
	'BH' => 'Bahrain',							'BD' => 'Bangladesh',
	'BB' => 'Barbados',							'BY' => 'Belarus',
	'BE' => 'Belgium',							'BZ' => 'Belize',
	'BJ' => 'Benin',							'BM' => 'Bermuda',
	'BT' => 'Bhutan',							'BO' => 'Bolivia',
	'BA' => 'Bosnia And Herzegowina',			'BW' => 'Botswana',
	'BV' => 'Bouvet Island',					'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory',	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',							'BF' => 'Burkina Faso',
	'BI' => 'Burundi',							'KH' => 'Cambodia',
	'CM' => 'Cameroon',							'CA' => 'Canada',
	'CV' => 'Cape Verde',						'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',			'TD' => 'Chad',
	'CL' => 'Chile',							'CN' => 'China',
	'CX' => 'Christmas Island',					'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',							'KM' => 'Comoros',
	'CG' => 'Congo',							'CD' => 'Congo, The Democratic Republic Of The',
	'CK' => 'Cook Islands',						'CR' => 'Costa Rica',
	'CI' => 'Cote D\'Ivoire',					'HR' => 'Croatia (Local Name: Hrvatska)',
	'CU' => 'Cuba',								'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',					'DK' => 'Denmark',
	'DJ' => 'Djibouti',							'DM' => 'Dominica',
	'DO' => 'Dominican Republic',				'TP' => 'East Timor',
	'EC' => 'Ecuador',							'EG' => 'Egypt',
	'SV' => 'El Salvador',						'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',							'EE' => 'Estonia',
	'ET' => 'Ethiopia',							'FK' => 'Falkland Islands (Malvinas)',
	'FO' => 'Faroe Islands',					'FJ' => 'Fiji',
	'FI' => 'Finland',							'FR' => 'France',
	'FX' => 'France, Metropolitan',				'GF' => 'French Guiana',
	'PF' => 'French Polynesia',					'TF' => 'French Southern Territories',
	'GA' => 'Gabon',							'GM' => 'Gambia',
	'GE' => 'Georgia',							'DE' => 'Germany',
	'GH' => 'Ghana',							'GI' => 'Gibraltar',
	'GR' => 'Greece',							'GL' => 'Greenland',
	'GD' => 'Grenada',							'GP' => 'Guadeloupe',
	'GU' => 'Guam',								'GT' => 'Guatemala',
	'GN' => 'Guinea',							'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',							'HT' => 'Haiti',
	'HM' => 'Heard And Mc Donald Islands',		'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',							'HK' => 'Hong Kong',
	'HU' => 'Hungary',							'IS' => 'Iceland',
	'IN' => 'India',							'ID' => 'Indonesia',
	'IR' => 'Iran (Islamic Republic Of)',		'IQ' => 'Iraq',
	'IE' => 'Ireland',							'IL' => 'Israel',
	'IT' => 'Italy',							'JM' => 'Jamaica',
	'JP' => 'Japan',							'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',						'KE' => 'Kenya',
	'KI' => 'Kiribati',							'KP' => 'Korea, Democratic People\'s Republic Of',
	'KR' => 'Korea, Republic Of',				'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',						'LA' => 'Lao People\'s Democratic Republic',
	'LV' => 'Latvia',							'LB' => 'Lebanon',
	'LS' => 'Lesotho',							'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',			'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',						'LU' => 'Luxembourg',
	'MO' => 'Macau',							'MK' => 'Macedonia, Former Yugoslav Republic Of',
	'MG' => 'Madagascar',						'MW' => 'Malawi',
	'MY' => 'Malaysia',							'MV' => 'Maldives',
	'ML' => 'Mali',								'MT' => 'Malta',
	'MH' => 'Marshall Islands',					'MQ' => 'Martinique',
	'MR' => 'Mauritania',						'MU' => 'Mauritius',
	'YT' => 'Mayotte',							'MX' => 'Mexico',
	'FM' => 'Micronesia, Federated States Of',	'MD' => 'Moldova, Republic Of',
	'MC' => 'Monaco',							'MN' => 'Mongolia',
	'MS' => 'Montserrat',						'MA' => 'Morocco',
	'MZ' => 'Mozambique',						'MM' => 'Myanmar',
	'NA' => 'Namibia',							'NR' => 'Nauru',
	'NP' => 'Nepal',							'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',				'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',						'NI' => 'Nicaragua',
	'NE' => 'Niger',							'NG' => 'Nigeria',
	'NU' => 'Niue',								'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',			'NO' => 'Norway',
	'OM' => 'Oman',								'PK' => 'Pakistan',
	'PW' => 'Palau',							'PA' => 'Panama',
	'PG' => 'Papua New Guinea',					'PY' => 'Paraguay',
	'PE' => 'Peru',								'PH' => 'Philippines',
	'PN' => 'Pitcairn',							'PL' => 'Poland',
	'PT' => 'Portugal',							'PR' => 'Puerto Rico',
	'QA' => 'Qatar',							'RE' => 'Reunion',
	'RO' => 'Romania',							'RU' => 'Russian Federation',
	'RW' => 'Rwanda',							'KN' => 'Saint Kitts And Nevis',
	'LC' => 'Saint Lucia',						'VC' => 'Saint Vincent And The Grenadines',
	'WS' => 'Samoa',							'SM' => 'San Marino',
	'ST' => 'Sao Tome And Principe',			'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',							'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',						'SG' => 'Singapore',
	'SK' => 'Slovakia (Slovak Republic)',		'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',					'SO' => 'Somalia',
	'ZA' => 'South Africa',						'GS' => 'South Georgia, South Sandwich Islands',
	'ES' => 'Spain',							'LK' => 'Sri Lanka',
	'SH' => 'St. Helena',						'PM' => 'St. Pierre And Miquelon',
	'SD' => 'Sudan',							'SR' => 'Suriname',
	'SJ' => 'Svalbard And Jan Mayen Islands',	'SZ' => 'Swaziland',
	'SE' => 'Sweden',							'CH' => 'Switzerland',
	'SY' => 'Syrian Arab Republic',				'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',						'TZ' => 'Tanzania, United Republic Of',
	'TH' => 'Thailand',							'TG' => 'Togo',
	'TK' => 'Tokelau',							'TO' => 'Tonga',
	'TT' => 'Trinidad And Tobago',				'TN' => 'Tunisia',
	'TR' => 'Turkey',							'TM' => 'Turkmenistan',
	'TC' => 'Turks And Caicos Islands',			'TV' => 'Tuvalu',
	'UG' => 'Uganda',							'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',				'UM' => 'United States Minor Outlying Islands',
	'UY' => 'Uruguay',							'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',							'VE' => 'Venezuela',
	'VN' => 'Viet Nam',							'VG' => 'Virgin Islands (British)',
	'VI' => 'Virgin Islands (U.S.)',			'WF' => 'Wallis And Futuna Islands',
	'EH' => 'Western Sahara',					'YE' => 'Yemen',
	'YU' => 'Yugoslavia',						'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe');
}