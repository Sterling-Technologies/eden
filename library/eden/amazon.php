<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/amazon/error.php';
require_once dirname(__FILE__).'/amazon/base.php';
require_once dirname(__FILE__).'/amazon/ec2.php';
require_once dirname(__FILE__).'/amazon/ec2/base.php';
require_once dirname(__FILE__).'/amazon/ec2/ami.php';
require_once dirname(__FILE__).'/amazon/ec2/customergateway.php';
require_once dirname(__FILE__).'/amazon/ec2/devpay.php';
require_once dirname(__FILE__).'/amazon/ec2/dhcp.php';
require_once dirname(__FILE__).'/amazon/ec2/elasticbookstore.php';
require_once dirname(__FILE__).'/amazon/ec2/elasticipaddress.php';
require_once dirname(__FILE__).'/amazon/ec2/general.php';
require_once dirname(__FILE__).'/amazon/ec2/instances.php';
require_once dirname(__FILE__).'/amazon/ec2/internetgateway.php';
require_once dirname(__FILE__).'/amazon/ec2/keypairs.php';
require_once dirname(__FILE__).'/amazon/ec2/monitoring.php';
require_once dirname(__FILE__).'/amazon/ec2/networkacl.php';
require_once dirname(__FILE__).'/amazon/ec2/networkinterface.php';
require_once dirname(__FILE__).'/amazon/ec2/placementgroups.php';
require_once dirname(__FILE__).'/amazon/ec2/reservedinstances.php';
require_once dirname(__FILE__).'/amazon/ec2/routetables.php';
require_once dirname(__FILE__).'/amazon/ec2/securitygroups.php';
require_once dirname(__FILE__).'/amazon/ec2/spotinstances.php';
require_once dirname(__FILE__).'/amazon/ec2/tags.php';
require_once dirname(__FILE__).'/amazon/ec2/virtualprivategateways.php';
require_once dirname(__FILE__).'/amazon/ec2/vmexport.php';
require_once dirname(__FILE__).'/amazon/ec2/vmimport.php';
require_once dirname(__FILE__).'/amazon/ec2/vnpconnections.php';
require_once dirname(__FILE__).'/amazon/ec2/vpc.php';
require_once dirname(__FILE__).'/amazon/ec2/windows.php';
require_once dirname(__FILE__).'/amazon/ecs.php';
require_once dirname(__FILE__).'/amazon/s3.php';
require_once dirname(__FILE__).'/amazon/ses.php';
require_once dirname(__FILE__).'/amazon/sns.php'; 

/**
 * Amazon API factory. This is a factory class with 
 * methods that will load up different amazon classes.
 * Amazon classes are organized as described on their 
 * developer site: ec2, ecs, s3 and ses
 *
 * @package    Eden
 * @category   asiapay
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Amazon extends Eden_Class {
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
	/**
	 * Returns Amazon ec2(Elastic Compute Cloud)
	 *
	 * @param *string
	 * @param *string
	 * @return Eden_Amazon_Ec2
	 */
	public function ec2($accessKey, $accessSecret) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Amazon_Ec2::i($accessKey, $accessSecret);
	}
	
	/**
	 * Returns Amazon ecs
	 *
	 * @param *string
	 * @param *string
	 * @return Eden_Amazon_Ecs
	 */
	public function ecs($privateKey, $publicKey) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Amazon_Ecs::i($privateKey, $publicKey);
	}
	
	/**
	 * Returns Amazon s3
	 *
	 * @param *string
	 * @param *string
	 * @return Eden_Amazon_S3
	 */
	public function s3($accessKey, $accessSecret) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Amazon_S3::i($accessKey, $accessSecret);
	}
	
	/**
	 * Returns Amazon ses
	 *
	 * @param *string
	 * @param *string
	 * @return Eden_Amazon_Ses
	 */
	public function ses($privateKey, $publicKey) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Amazon_Ses::i($privateKey, $publicKey);
	}
	
	/**
	 * Returns Amazon sns
	 *
	 * @param *string
	 * @param *string
	 * @return Eden_Amazon_Sns
	 */
	public function sns($accessKey, $accessSecret) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return Eden_Amazon_Sns::i($accessKey, $accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}