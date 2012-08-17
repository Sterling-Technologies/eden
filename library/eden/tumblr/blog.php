<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Tumblr blog
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Tumblr_Blog extends Eden_Tumblr_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.tumblr.com/v2/blog/%s/info'; 
	const URL_GET_AVATAR	= 'http://api.tumblr.com/v2/blog/%s/avatar/';
	const URL_GET_FOLLOWER	= 'http://api.tumblr.com/v2/blog/%s/followers';
	const URL_GET_POST		= 'http://api.tumblr.com/v2/blog/posts.json'; 
	const URL_GET_DRAFT		= 'http://api.tumblr.com/v2/blog/%s/posts/draft';
	const URL_GET_SUBMISION	= 'http://api.tumblr.com/v2/blog/posts/submission.json';
	const URL_ADD_BLOG		= 'http://api.tumblr.com/v2/blog/posts.json';
	const URL_UPDATE		= 'http://api.tumblr.com/v2/blog/edit.json';
	const URL_REBLOG		= 'http://api.tumblr.com/v2/blog/reblog.json';
	const URL_REMOVE		= 'http://api.tumblr.com/v2/blog/%s/post/delete';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_hostname		= NULL;
	protected $__apiKey			= NULL;
	protected $__size			= NULL;
	protected $__limit			= NULL;
	protected $__offset			= NULL;
	protected $__type			= NULL;
	protected $__id				= NULL;
	protected $__tag			= NULL;
	protected $__format			= NULL;
	protected $__state			= NULL;
	protected $__tweets			= NULL;
	protected $__date			= NULL;
	protected $__slug			= NULL;
	protected $__title			= NULL;
	protected $__caption		= NULL;
	protected $__link			= NULL;
	protected $__source			= NULL;
	protected $__description	= NULL;
	protected $__reblog			= true;
	protected $__notes			= true;
	protected $__markdown		= true;
	
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
	 * Add or create a blog
	 *
	 * @param string
	 * @return array
	 */
	public function add($type) {
		 //Argument 1 must be a string
		 Eden_Tumblr_Error::i()->argument(1, 'string');				
			
		//populate fields
		$query = array(
			'type' 		=> $type,
			'state'		=> $this->_state,
			'tag'		=> $this->_tag,
			'tweets'	=> $this->_tweets,
			'date'		=> $this->_date,
			'slug'		=> $this->_slug,
			'markdown'	=> $this->_markdown);
		
		$url = sprintf(self::URL_ADD_BLOG, $type);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add audio
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function addAudio($data, $external) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string	
		
		//populate fields
		$query = array(
			'data'			=> $data, 
			'external_url'	=> $external,
			'caption'		=> $this->_caption);
		
		$url = sprintf(self::URL_ADD_BLOG, $data);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add chat
	 *
	 * @param string
	 * @return array
	 */
	public function addChat($conversation) {
		 //Argument 1 must be a string
		 Eden_Tumblr_Error::i()->argument(1, 'string');				
		
		//populate fields	
		$query = array(
			'conversation'	=> $conversation,
			'title'			=> $this->_title);
		
		$url = sprintf(self::URL_ADD_BLOG, $conversation);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add link
	 *
	 * @param string
	 * @return array
	 */
	public function addLink($url) {
		 //Argument 1 must be a string
		 Eden_Tumblr_Error::i()->argument(1, 'string');				
		
		//populate fields
		$query = array(
			'url' 			=> $url,
			'title'			=> $this->_title,
			'description'	=> $this->_description);
		
		$url = sprintf(self::URL_ADD_BLOG, $url);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add photo
	 *
	 * @param string
	 * @param array
	 * @return array
	 */
	public function addPhoto($source, $data) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')	//Argument 1 must be a string
			->argument(2, 'array');	//Argument 2 must be a array
		
		//populate fields
		$query = array(
			'body' 		=> $body,
			'data' 		=> $data,
			'caption'	=> $this->_caption,
			'link'		=> $this->_link);
		
		$url = sprintf(self::URL_ADD_BLOG, $source);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add quote
	 *
	 * @param string
	 * @return array
	 */
	public function addQuote($quote) {
		 //Argument 1 must be a string
		 Eden_Tumblr_Error::i()->argument(1, 'string');				
		
		//populate fields
		$query = array(
			'qoute' 	=> $qoute,
			'source'	=> $this->_source);
		
		$url = sprintf(self::URL_ADD_BLOG, $qoute);
		return $this->_post($url, $query);
	}
	
	/**
	 * Add text
	 *
	 * @param string
	 * @return array
	 */
	public function addText($body) {
		//Argument 1 must be a string
		 Eden_Tumblr_Error::i()->argument(1, 'string');				
			
		$query = array(
			'body' 	=> $body,
			'title'	=> $this->_title);
		
		$url = sprintf(self::URL_ADD_BLOG, $body);
		return $this->_post($url, $query);
	}
	 
	/**
	 * Add video
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function addVideo($data, $embed) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$query = array(
			'data'		=> $data,
			'embed' 	=> $embed,
			'caption'	=> $this->_caption);
		
		$url = sprintf(self::URL_ADD_BLOG, $data);
		return $this->_post($url, $query);
	}
	
	/**
	 * You can get a blog's avatar in 9 different sizes. 	
	 * The default size is 64x64. 
	 *
	 * @param string
	 * @return array
	 */
	public function getAvatar($hostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');				
		
		//populate fields
		$query = array(
			'base-hostname' => $hostName,
			'size'			=> $this->_size);
		
		return $this->_getResponse(self::URL_GET_AVATAR, $query);
	}
	
	/**
	 * Get complete set draft post
	 *
	 * @return array
	 */
	public function getDraft() {
		return $this->_getResponse(self::URL_GET_DRAFT);
	}
	
	/**
	 * Get followers
	 *
	 * @param string
	 * @return array
	 */
	public function getFollower($hostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');				
		
		//populate fields
		$query = array(
			'base-hostname' => $hostName,
			'limit'			=> $this->_limit,
			'offset'		=> $this->_offset);
		
		return $this->_getResponse(self::URL_GET_FOLLOWER, $query);
	}
	
	/**
	 * This method returns general information about the blog,  	
	 * such as the title, number of posts, and other high-level data.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getList($hostName, $apiKey) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$query = array('base-hostname' => $hostName, 'api_key' => $apiKey);
		
		return $this->_getResponse(self::URL_GET_LIST, $query);
	}
	
	/**
	 * Retrieve published post such as text, photo, quote, link
	 * Chat, Audio, Video and Answer
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getPost($hostName, $apiKey) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		//populate fields	
		$query = array(
			'base-hostname' => $hostName, 
			'api_key'		=> $apiKey,
			'type'			=> $this->_type,
			'id'			=> $this->_id,
			'tag'			=> $this->_tag,
			'limit'			=> $this->_limit,
			'offset'		=> $this->_offset,
			'format'		=> $this->_format,
			'reblog_info'	=> $this->_reblog,
			'notes_info'	=> $this->_notes);
		
		return $this->_getResponse(self::URL_GET_POST, $query);
	}
	
	/**
	 * Get complete set submmision post
	 *
	 * @return array
	 */
	public function getSubmission() {
		return $this->_getResponse(self::URL_GET_SUBMISION);
	}
	
	/**
	 * Reblog a post
	 *
	 * @param integer
	 * @param integer
	 * @param string
	 * @return array
	 */
	public function reblog($Id, $reblog, $comment) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')	//Argument 1 must be an integer
			->argument(2, 'integer')	//Argument 2 must be an integer
			->argument(3, 'string');	//Argument 3 must be a string
			
		$query = array('Id' => $Id, 'reblog_key' => $reblog);
		
		//if it is not empty
		if(!is_null($comment)) {
			$query['comment'] = $comment;
		}
		
		$url = sprintf(self::URL_REBLOG, $Id);
		return $this->_post($url, $query);
	}
	
	/**
	 * Delete a post
	 *
	 * @param integer
	 * @return array
	 */
	public function remove($Id) {
		 //Argument 1 must be an integer 
		 Eden_Tumblr_Error::i()->argument(1, 'integer');				
			
		$query = array('Id' => $Id);
		
		$url = sprintf(self::URL_REMOVE, $Id);
		return $this->_post($url, $query);
	}
	
	/**
	 * Set api key
	 *
	 * @param string
	 * @return this
	 */
	public function setApiKey($apiKey) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_apiKey = $apiKey;
		return $this;
	}
	
	/**
	 * Set caption
	 *
	 * @param string
	 * @return this
	 */
	public function setCaption($caption) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_caption = $caption;
		return $this;
	}
	
	/**
	 * Set date
	 *
	 * @param string
	 * @return this
	 */
	public function setDate($date) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_date = $date;
		return $this;
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_description = $description;
		return $this;
	}
	
	/**
	 * Set format
	 *
	 * @param string
	 * @return this
	 */
	public function setFormat($format) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_format = $format;
		return $this;
	}
	
	/**
	 * Set hostname
	 *
	 * @param string
	 * @return this
	 */
	public function setHostname($hostname) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_hostname = $hostname;
		return $this;
	}
	
	/**
	 * Set id
	 *
	 * @param integer
	 * @return this
	 */
	public function setId($id) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_id = $id;
		return $this;
	}
	
	/**
	 * Set limit
	 *
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_limit = $limit;
		return $this;
	}
	
	/**
	 * Set link
	 *
	 * @param string
	 * @return this
	 */
	public function setLink($link) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_link = $link;
		return $this;
	}
	
	/**
	 * Set markdown
	 *
	 * @return this
	 */
	public function setMarkdown() {
		$this->_markdown = false;
		return $this;
	}
	
	/**
	 * Set notes
	 *
	 * @return this
	 */
	public function setNotes() {
		$this->_notes = false;
		return $this;
	}
	
	/**
	 * Set offset
	 *
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//Argument 1 must be an integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		
		$this->_offset = $offset;
		return $this;
	}
	
	/**
	 * Set reblog
	 *
	 * @return this
	 */
	public function setReblog() {
		$this->_reblog = false;
		return $this;
	}
	
	/**
	 * Set size
	 *
	 * @param string
	 * @return this
	 */
	public function setSize($size) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_size = $size;
		return $this;
	}
	
	/**
	 * Set slug
	 *
	 * @param string
	 * @return this
	 */
	public function setSlug($slug) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_slug = $slug;
		return $this;
	}
	
	/**
	 * Set source
	 *
	 * @param string
	 * @return this
	 */
	public function setSource($source) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_source = $source;
		return $this;
	}
	
	/**
	 * Set state
	 *
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_state = $state;
		return $this;
	}
	
	/**
	 * Set tag
	 *
	 * @param string
	 * @return this
	 */
	public function setTag($tag) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_tag = $tag;
		return $this;
	}
	
	/**
	 * Set title
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_title = $title;
		return $this;
	}
	
	/**
	 * Set tweets
	 *
	 * @param string
	 * @return this
	 */
	public function setTweets($tweets) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_tweets = $tweets;
		return $this;
	}
	
	/**
	 * Set type
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		$this->_type = $type;
		return $this;
	}
	 
	/**
	 * Update blog post
	 *
	 * @param integer
	 * @return array
	 */
	public function update($Id) {
		//Argument 1 must be a integer
		 Eden_Tumblr_Error::i()->argument(1, 'integer');					
			
		$query = array('Id' => $Id);
		
		$url = sprintf(self::URL_UPDATE, $Id);
		return $this->_post($url, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
