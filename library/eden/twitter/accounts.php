<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter Account 
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Accounts extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_LIMIT_STATUS			= 'https://api.twitter.com/1/account/rate_limit_status.json';
	const URL_VERIFY_CREDENTIALS	= 'https://api.twitter.com/1/account/verify_credentials.json';
	const URL_END_SESSION			= 'https://api.twitter.com/1/account/end_session.json';
	const URL_UPDATE_PROFILE		= 'https://api.twitter.com/1/account/update_profile.json';
	const URL_UPDATE_BACKGROUND		= 'https://api.twitter.com/1/account/update_profile_background_image.json';
	const URL_UPDATE_PROFILE_COLOR	= 'https://api.twitter.com/1/account/update_profile_colors.json';
	const URL_ACCOUNT_TOTAL			= 'https://api.twitter.com/1/account/totals.json';
	const URL_ACCOUNT_SETTING		= 'https://api.twitter.com/1/account/settings.json';
	const URL_ACCOUNT_UPLOAD		= 'https://api.twitter.com/1/account/update_profile_image.json';
	
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
	 * Returns the current count of friends, followers, updates (statuses) 
	 * and favorites of the authenticating user.
	 *
	 * @return array
	 */
	public function getAccountAnalytics() {
		
		return $this->_getResponse(self::URL_ACCOUNT_TOTAL);
	}
	
	/**
	 * Returns settings (including current trend, geo and sleep time information)
	 * for the authenticating user.
	 *
	 * @return array
	 */
	public function getAccountSettings() {
		
		return $this->_getResponse(self::URL_ACCOUNT_SETTING);
	}
	
	/**
	 * Returns an HTTP 200 OK response code and
	 * a representation of the requesting user 
	 * if authentication was successful 
	 *
	 * @return array
	 */
	public function getCredentials() {
		
		return $this->_getResponse(self::URL_VERIFY_CREDENTIALS, $this->_query);
	}
	
	/**
	 * Returns the remaining number of API 
	 * requests available to the requesting 
	 * user before the API limit is reached 
	 * for the current hour.
	 *
	 * @return array
	 */
	public function checkRateLimits() {
		
		return $this->_getResponse(self::URL_LIMIT_STATUS);
	} 
	 
	/**
	 * Ends the session of the authenticating user, returning a null cookie. 
	 * Use this method to sign users out of client-facing applications like widgets.
	 *
	 * @return string
	 */
	public function logOut() {
		
		return $this->_post(self::URL_END_SESSION);
	}
	/**
	 * Set profile background color
	 *
	 * @param string
	 * @return this
	 */
	public function setBackgroundColor($background) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_background_color'] = $backgroud;
		
		return $this;
	}
	
	/**
	 * Set profile sibebar border color
	 *
	 * @param string
	 * @return this
	 */
	public function setBorderColor($border) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_sidebar_border_color'] = $border;
		
		return $this;
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
	
	}
	
	/**
	 * Set include entities
	 *
	 * @return this
	 */
	public function setEntities() {
		$this->_query['include_entities'] = true;
		
		return $this;
	}
	
	/**
	 * Set profile sibebar fill color
	 *
	 * @param string
	 * @return this
	 */
	public function setFillColor($fill) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_sidebar_fill_color'] = $fill;
		
		return $this;
	}
	
	/**
	 * Set image
	 *
	 * @param string
	 * @return this
	 */
	public function setImage($image) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['image'] = $image;
		
		return $this;
	}
	
	/**
	 * Set profile link color
	 *
	 * @param string
	 * @return this
	 */
	public function setLinkColor($link) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_link_color'] = $link;
		
		return $this;
	}
	
	/**
	 * Set location
	 *
	 * @param string
	 * @return this
	 */
	public function setLocation($location) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['location'] = $location;
		
		return $this;
	
	}
	
	/**
	 * Set name
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['name'] = $name;
		
		return $this;
	
	}
	
	/**
	 * Set skip status
	 *
	 * @return this
	 */
	public function setStatus() {
		$this->_query['skip_status'] = true;
		
		return $this;
	}
	
	/**
	 * Set profile text color
	 *
	 * @param string
	 * @return this
	 */
	public function setTextColor($textColor) {
		//Argument 3 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['profile_text_color'] = $textColor;
		
		return $this;
	}
	
	/**
	 * Set tile
	 *
	 * @return this
	 */
	public function setToTile() {
		$this->_query['tile'] = true;
		
		return $this;
	}
	
	/**
	 * Set url
	 *
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//Argument 1 must be a string or null
		Eden_Twitter_Error::i()->argument(1, 'string');
		$this->_query['url'] = $url;
		
		return $this;
	
	}
	
	/**
	 * Determines whether to display the profile background image or not
	 *
	 * @return this
	 */
	public function show() {
		$this->_query['use'] = true;
		
		return $this;
	}
	 
	/**
	 * Updates the authenticating user's profile background image. 
	 * This method can also be used to enable or disable the profile 
	 * background image
	 *
	 * @param string
	 * @return array
	 */
	public function updateBackgroundImage($image) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_query['image'] = $image;
		
		return $this->_upload(self::URL_UPDATE_BACKGROUND, $this->_query);
	}
	 
	/**
	 * Sets values that users are able to 
	 * set under the Account tab of their
	 * settings page. Only the parameters 
	 * specified will be updated.
	 *
	 * @return array
	 */
	public function updateProfileColor() {
		
		return $this->_post(self::URL_UPDATE_PROFILE_COLOR, $this->_query);
		
	}
	 
	/**
	 * Sets values that users are able to set 
	 * under the "Account" tab of their settings 
	 * page. Only the parameters specified 
	 * will be updated.
	 *
	 * @return array
	 */
	public function updateProfile() {
		
		return $this->_post(self::URL_UPDATE_PROFILE, $this->_query);
	}
	
	/**
	 * Updates the authenticating user's profile image.
	 *
	 * @param string
	 * @return array
	 */
	public function updateProfileImage($image) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
	
		$this->_query['image'] = $image;
		
		return $this->_upload(self::URL_ACCOUNT_UPLOAD, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/ 
}