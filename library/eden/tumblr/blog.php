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
	const URL_BLOG_GET				= 'http://api.tumblr.com/v2/blog/%s/info';
	const URL_BLOG_GET_AVATAR 		= 'http://api.tumblr.com/v2/blog/%s/avatar/%s';
	const URL_BLOG_GET_FOLLOWER		= 'http://api.tumblr.com/v2/blog/%s/followers';
	const URL_BLOG_GET_POST			= 'http://api.tumblr.com/v2/blog/%s/posts/%s';
	const URL_BLOG_GET_QUEUE		= 'http://api.tumblr.com/v2/blog/%s/posts/queue';
	const URL_BLOG_GET_DRAFT		= 'http://api.tumblr.com/v2/blog/%s/posts/draft';
	const URL_BLOG_GET_SUBMISSION	= 'http://api.tumblr.com/v2/blog/%s/posts/submission';
	
	const URL_BLOG_CREATE_POST		= 'http://api.tumblr.com/v2/blog/%s/post';
	const URL_BLOG_DELETE_POST		= 'http://api.tumblr.com/v2/blog/%s/post/delete';
	const URL_BLOG_EDIT_POST		= 'api.tumblr.com/v2/blog/%s/post/edit';
	const URL_BLOG_REBLOG_POST		= 'api.tumblr.com/v2/blog/%s/post/reblog';

	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_size			= 64;
	protected $_postType		= 'text';
	
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
	 * The size of the avatar (square, 
	 * one value for both length and width). 
	 * Must be one of the values:
     * 16, 24, 30, 40, 48, 64, 96, 128, 512
	 *
	 * @param integer
	 * @return this
	 */
	public function setSize($size) {
		//Argument 1 must be a integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_size = $size;
		
		return $this;
		
	}
	
	/**
	 * The number of results to return: 1–20, inclusive
	 *
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//Argument 1 must be a integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['limit'] = $limit;
		
		return $this;
		
	}
	
	/**
	 * Result to start at
	 *
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//Argument 1 must be a integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['offset'] = $offset;
		
		return $this;
		
	}
	
	/**
	 * A specific post ID. Returns the single post 
	 * specified or (if not found) a 404 error.
	 *
	 * @param integer
	 * @return this
	 */
	public function setPostId($postId) {
		//Argument 1 must be a integer
		Eden_Tumblr_Error::i()->argument(1, 'int');
		$this->_query['id'] = $postId;
		
		return $this;
		
	}
	
	/**
	 * The type of post to return. Specify one of the following:  
	 * "text, quote, link, answer, video, audio, photo, chat"
	 *
	 * @param string
	 * @return this
	 */
	public function setPostType($postType) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_postType = $postType;
		
		return $this;
		
	}
	
	/**
	 * Limits the response to posts with the specified tag
	 *
	 * @param string
	 * @return this
	 */
	public function setTag($tag) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['tag'] = $tag;
		
		return $this;
		
	}
	
	/**
	 * The state of the post. Specify one of the following:  
	 * published, draft, queue, private
	 *
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['state'] = $tag;
		
		return $this;
		
	}
	
	/**
	 * Sets the format type of post. Supported formats 
	 * are: html & markdown
	 *
	 * @param string
	 * @return this
	 */
	public function setFormat($format) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['format'] = $format;
		
		return $this;
		
	}
	
	/**
	 * Add a short text summary to the end of the post URL
	 *
	 * @param string
	 * @return this
	 */
	public function setSlug($slug) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['slug'] = $slug;
		
		return $this;
		
	}
	
	/**
	 * The user-supplied caption, HTML allowed
	 *
	 * @param string
	 * @return this
	 */
	public function setCaption($caption) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['caption'] = $caption;
		
		return $this;
		
	}
	
	/**
	 * The "click-through URL" for the photo
	 *
	 * @param url
	 * @return this
	 */
	public function setLink($link) {
		//Argument 1 must be a url
		Eden_Tumblr_Error::i()->argument(1, 'url');
		$this->_query['link'] = $link;
		
		return $this;
		
	}
	
	/**
	 * A user-supplied description, HTML allowed
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		$this->_query['description'] = $description;
		
		return $this;
		
	}
	/**
	 * Returns general information about the blog, 
	 * such as the title, number of posts, and other high-level data.
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */ 
	public function getInfo($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_BLOG_GET, $baseHostName));
	}
		
	/**
	 * Returns users Avatar
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getAvatar($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_BLOG_GET_AVATAR, $baseHostName, $this->_size));
	}
	
	/**
	 * Returns users follower
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getFollower($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getAuthResponse(sprintf(self::URL_BLOG_GET_FOLLOWER, $baseHostName), $this->_query);
	}
	
	/**
	 * Retrieve Published Posts
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getPost($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_BLOG_GET_POST, $baseHostName, $this->_postType), $this->_query);
	}
	
	/**
	 * Retrieve Queued Posts
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getQueuedPost($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getAuthResponse(sprintf(self::URL_BLOG_GET_QUEUE, $baseHostName));
	}
	
	/**
	 * Retrieve Draft Posts
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getDraftPost($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getAuthResponse(sprintf(self::URL_BLOG_GET_DRAFT, $baseHostNamee));
	}
	
	/**
	 * Retrieve Submission Posts
	 *
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function getSubmissionPost($baseHostName) {
		//Argument 1 must be a string
		Eden_Tumblr_Error::i()->argument(1, 'string');
		
		return $this->_getAuthResponse(sprintf(self::URL_BLOG_GET_SUBMISSION, $baseHostName));
	}
	
	/**
	 * Create a New Blog Text Post
	 *
	 * @param string The standard or custom blog hostname
	 * @param string The full post body, HTML allowed
	 * @param string|null Title of the post, HTML entities must be escaped
	 * @return this
	 */
	public function postText($baseHostName, $body, $title = NULL) { 
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		$this->_query['type'] 	= 'text';
		$this->_query['body'] 	= $body;
		$this->_query['title']	= $title;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog Photo Post
	 * Either source or data is required
	 *
	 * @param string The standard or custom blog hostname
	 * @param string|null The photo source URL
	 * @param string|null One or more image files (submit multiple times to create a slide show)
	 * @return this
	 */
	public function postPhoto($baseHostName, $source = NULL, $data = NULL) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null')		//Argument 2 must be a string or null
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		$this->_query['type'] 	= 'photo';
		$this->_query['data'] 	= $data;
		$this->_query['source'] = $source;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog Quote Post
	 *
	 * @param string The standard or custom blog hostname
	 * @param string The full text of the quote, HTML entities must be escpaed
	 * @param string|null One or more image files (submit multiple times to create a slide show)
	 * @return this
	 */
	public function postQuote($baseHostName ,$quote, $source = NULL) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string 
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
		
		$this->_query['type'] 	= 'quote';
		$this->_query['quote'] 	= $quote;
		$this->_query['source'] = $source;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog link Post
	 *
	 * @param string The standard or custom blog hostname
	 * @param string The link
	 * @return this
	 */
	public function postLink($baseHostName ,$url) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string 
		
		$this->_query['type'] 	= 'link';
		$this->_query['url'] 	= $url;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog Chat Post
	 *
	 * @param string The standard or custom blog hostname
	 * @param string The text of the conversation/chat, with dialogue labels (no HTML)
	 * @return this
	 */
	public function postChat($baseHostName ,$conversation) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string 
		
		$this->_query['type'] 			= 'chat';
		$this->_query['conversation'] 	= $conversation;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog Audio Post
	 * either external_url or data is requred
	 *
	 * @param string The standard or custom blog hostname
	 * @param string|null The URL of the site that hosts the audio file (not tumblr)
	 * @param string|null An audio file
	 * @return this
	 */
	public function postAudio($baseHostName ,$externalUrl = NULL, $data = NULL) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null')		//Argument 2 must be a string or null
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null 
		
		$this->_query['type'] 			= 'audio';
		$this->_query['data'] 			= $data;
		$this->_query['externalUrl'] 	= $externalUrl;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Create a New Blog Video Post
	 * either external_url or data is requred
	 *
	 * @param string The standard or custom blog hostname
	 * @param string|null HTML embed code for the video
	 * @param string|null An audio file
	 * @return this
	 */
	public function postVideo($baseHostName ,$embed = NULL, $data = NULL) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null')		//Argument 2 must be a string or null
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null 
		
		$this->_query['type'] 	= 'video';
		$this->_query['embed'] 	= $embed;
		$this->_query['data'] 	= $data;
		
		return $this->_post(sprintf(self::URL_BLOG_CREATE_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Reblog a Post
	 *
	 * @param string The standard or custom blog hostname
	 * @param string The ID of the reblogged post on tumblelog
	 * @param string The reblog key for the reblogged post – get the reblog key with a /posts request
	 * @param string|null A comment added to the reblogged post
	 * @return this
	 */
	public function editPost($baseHostName ,$postId, $reblogKey, $comment = NULL) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string 
			->argument(3, 'string')				//Argument 3 must be a string 
			->argument(4, 'string', 'null');	//Argument 4 must be a string or null 
		
		$this->_query['id'] 		= $postId;	
		$this->_query['comment'] 	= $comment;
		$this->_query['reblog_key'] = $reblogKey;	
		
		return $this->_post(sprintf(self::URL_BLOG_REBLOG_POST, $baseHostName), $this->_query);
	}
	
	/**
	 * Delete Post
	 *
	 * @param string The ID of the post to delete
	 * @param string The standard or custom blog hostname
	 * @return this
	 */
	public function delete($baseHostName, $postId) {
		//Argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$this->_query['id'] = $postId;
		
		return $this->_post(sprintf(self::URL_BLOG_DELETE_POST, $baseHostName), $this->_query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}