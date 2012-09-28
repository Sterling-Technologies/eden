<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Tags
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Tags extends Eden_Amazon_Ec2_Base {
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
		return self::_getMultiple(__CLASS__);
	} 
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds or overwrites one or more tags for the specified resource or resources. 
	 *
	 * @return array
	 */
	public function createTags() {	
		
		$this->_query['Action'] = 'CreateTags';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a specific set of tags from a specific set of resources. This call 
	 * is designed to follow a DescribeTags call. You first determine what tags a 
	 * resource has, and then you call DeleteTags with the resource ID and the specific 
	 * tags you want to delete.
	 *
	 * @return array
	 */
	public function deleteTags() {	
		
		$this->_query['Action'] = 'DeleteTags';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Lists your tags.
	 *
	 * @return array
	 */
	public function describeTags() {	
		
		$this->_query['Action'] = 'DescribeTags';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The key for a tag.
	 *
	 * @param string
	 * @return array
	 */
	public function setTagKey($tagKey) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Tag_Key']
			[isset($this->_query['Tag_Key'])?
			count($this->_query['Tag_Key'])+1:1] = $tagKey;
		
		return $this;
	}
	
	/**
	 * The value for a tag. If you don't want the tag to have a value, specify 
	 * the parameter with no value, and we set the value to an empty string.
	 *
	 * @param string
	 * @return array
	 */
	public function setTagValue($tagValue) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Tag_Value']
			[isset($this->_query['Tag_Value'])?
			count($this->_query['Tag_Value'])+1:1] = $tagValue;
		
		return $this;
	}
	
	/**
	 * The ID of a resource to tag. For example, ami-1a2b3c4d. You can specify 
	 * multiple resources to assign the tags to.
	 *
	 * @param string
	 * @return array
	 */
	public function setResourceId($resourceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ResourceId_']
			[isset($this->_query['ResourceId_'])?
			count($this->_query['ResourceId_'])+1:1] = $resourceId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	