<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Xend Express - Base
 *
 * @package    Eden
 * @category   xend
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Xend_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const SHIPMENT_WSDL = 'https://www.xend.com.ph/api/ShipmentService.asmx?wsdl';
	const TRACKING_WSDL = 'https://www.xend.com.ph/api/TrackingService.asmx?wsdl';
	const RATE_WSDL		= 'https://www.xend.com.ph/api/RateService.asmx?wsdl';
	const BOOKING_WSDL	= 'https://xend.com.ph/api/BookingService.asmx?wsdl';
	const HEADER		= 'https://www.xend.com.ph/api/';
	const WAY_BILL_NO	= 'WaybillNo';
	const USER_TOKEN	= 'UserToken';
	const AUTH_HEADER	= 'AuthHeader';	
	const LENGTH		= 'DimensionL';			
	const WIDTH			= 'DimensionW';			
	const HEIGHT		= 'DimensionH';			
	const VALUE			= 'DeclaredValue';
	
	const TEST_SHIPMENT_WSDL			= 'https://www.xend.com.ph/apitest/ShipmentService.asmx?wsdl';
	const TEST_BOOKING_WSDL				= 'https://xend.com.ph/apitest/BookingService.asmx?wsdl';
	const TEST_HEADER					= 'https://www.xend.com.ph/apitest/';
	const METRO_MANILA_EXPRESS			= 'MetroManilaExpress';
	const PROVINCIAL_EXPRESS			= 'ProvincialExpress';
	const INTERNATIONAL_POSTAL			= 'InternationalPostal';
	const INTERNATIONAL_EMS				= 'InternationalEMS';
	const INTERNATIONAL_EXPRESS			= 'InternationalExpress';
	const RIZAL_METRO_MANILA_EXPRESS	= 'RizalMetroManilaExpress';
	const DOCUMENT						= 'Document';
	const PARCEL						= 'Parcel';
	const BOOKING_DATE					= 'BookingDate';
	const REFERENCE_NUMBER				= 'AddressRefNo';
	const REMARKS						= 'Remarks';
	const WEIGHT						= 'Weight';	
	const DESTINATION_VALUE				= 'DestinationValue';
	const INSURANCE						= 'AddInsurance';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userToken	= NULL;
	protected $_test		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($userToken, $test = true) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_userToken	= $userToken;
		$this->_test		= $test;
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}