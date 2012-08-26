<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos API factory. This is a factory class with 
 * methods that will load up different Zappos classes.
 * Xend classes are organized as described on their 
 * developer site: search, image, product, statistics
 * brand, review, core values, autocomplete and similarity. 
 *
 * @package    Eden
 * @category   Zappos
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Zappos extends Eden_Class {
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
	 * Returns Zappos Auto complete
	 *
	 * @param *string api key
	 * @return Eden_Zappos_AutoComplete
	 */
	public function autoComplete($apiKey) {
		return Eden_Zappos_AutoComplete::i($apiKey);
	}
		
	/**
	 * Returns Zappos brand
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Brand
	 */
	public function getBrand($apiKey) {
		return Eden_Zappos_Brand::i($apiKey);
	}
	
	/**
	 * Returns Zappos core values
	 *
	 * @param *string api key
	 * @return Eden_Zappos_AutoComplete
	 */
	public function getCoreValues($apiKey) {
		return Eden_Zappos_Values::i($apiKey);
	}
	
	/**
	 * Returns Zappos images
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Search
	 */
	public function getImage($apiKey) {
		return Eden_Zappos_Image::i($apiKey);
	}
	
	/**
	 * Returns Zappos products
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Product
	 */
	public function getProduct($apiKey) {
		return Eden_Zappos_Product::i($apiKey);
	}
	
	/**
	 * Returns Zappos review
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Review
	 */
	public function getReview($apiKey) {
		return Eden_Zappos_Review::i($apiKey);
	}
	
	/**
	 * Returns Zappos search results
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Search
	 */
	public function search($apiKey) {
		return Eden_Zappos_Search::i($apiKey);
	}
	
	/**
	 * Returns Zappos similarity
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Similarity
	 */
	public function getSimilarity($apiKey) {
		return Eden_Zappos_Similarity::i($apiKey);
	}
	
	/**
	 * Returns Zappos statistics
	 *
	 * @param *string api key
	 * @return Eden_Zappos_Product
	 */
	public function getStatistics($apiKey) {
		return Eden_Zappos_Product::i($apiKey);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
