<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Tumblr_Blog extends Eden_Tumblr_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_LIST		= 'http://api.tumblr.com/v2/blog/kamoteche.tumblr.com/info'; 
	const URL_GET_AVATAR	= 'http://api.tumblr.com/v2/blog/kamoteche.tumblr.com/avatar/512';
	const URL_GET_FOLLOWER	= 'api.tumblr.com/v2/blog/{tumblr.poptech.org}/followers';
	const URL_GET_POST		= 'http://api.tumblr.com/v2/blog/posts.json'; 
	const URL_GET_DRAFT		= 'api.tumblr.com/v2/blog/{kamoteche.tumblr.com}/posts/draft';
	const URL_GET_SUBMISION	= 'http://api.tumblr.com/v2/blog/posts/submission.json';
	const URL_ADD_BLOG		= 'http://api.tumblr.com/v2/blog/posts.json';
	const URL_UPDATE		= 'http://api.tumblr.com/v2/blog/edit.json';
	const URL_REBLOG		= 'http://api.tumblr.com/v2/blog/reblog.json';
	const URL_REMOVE		= 'http://api.tumblr.com/v2/blog/kamoteche.tumblr.com/post/delete';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * This method returns general information about the blog,  	
	 * such as the title, number of posts, and other high-level data.
	 *
	 * @param hostName is a string
	 * @param apiKey is a string
	 * @return $this
	 */
	 public function getList($hostName, $apiKey) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string');			//Argument 2 must be a string
			
		$query = array('base-hostname' => $hostName, 'api_key' => $apiKey);
		
		return $this->_getResponse(self::URL_GET_LIST, $query);
	 }
	 /**
	 * You can get a blog's avatar in 9 different sizes. 	
	 * The default size is 64x64. 
	 *
	 * @param hostName is a string
	 * @param size is an integer
	 * @return $this
	 */
	 public function getAvatar($hostName, $size = NULL) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'integer', 'null');			//Argument 2 must be a integer or null
			
		$query = array('base-hostname' => $hostName);
		//if it is not empty
		if(!is_null($size)) {
			//lets put it in the query
			$query['size'] = $size;
		}
		
		return $this->_getResponse(self::URL_GET_AVATAR, $query);
	 }
	 /**
	 * Get followers
	 *
	 * @param hostName is a string
	 * @param limit is an integer
	 * @param offset is an integer
	 * @return $this
	 */
	 public function getFollower($hostName, $limit = NULL, $offset = NULL) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'integer', 'null')				//Argument 2 must be a integer or null
			->argument(3, 'integer', 'null');			//Argument 2 must be a integer or null
			
		$query = array('base-hostname' => $hostName);
		//if it is not empty
		if(!is_null($limit)) {
			//lets put it in the query
			$query['limit'] = $limit;
		}
		//if it is not empty
		if(!is_null($offset)) {
			//lets put it in the query
			$query['offset'] = $offset;
		}
		
		return $this->_getResponse(self::URL_GET_FOLLOWER, $query);
	 }
	 /**
	 * Retrieve published post such as text, photo, quote, link
	 * Chat, Audio, Video and Answer
	 *
	 * @param hostName is a string
	 * @param apiKey is a string
	 * @param type is a string 
	 * @param id is integer
	 * @param tag is a string
	 * @param limit is integer
	 * @param offset is a string
	 * @param reblog is a boolean
	 * @param notes is a boolean
	 * @param format is a string
	 * @return $this
	 */
	 public function getPost($hostName, $apiKey, $type = NULL, $id = NULL, $tag = NULL,
							 $limit = NULL, $offset = NULL, $reblog = NULL, $notes = NULL, $format = NULL) {
		//Argument Test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string')					//Argument 2 must be a string
			->argument(3, 'string', 'null')			//Argument 3 must be a string or null
			->argument(4, 'integer', 'null')		//Argument 4 must be a integer or null
			->argument(5, 'string', 'null')			//Argument 5 must be a string or null
			->argument(6, 'integer', 'null')		//Argument 6 must be a integer or null
			->argument(7, 'integer', 'null')		//Argument 7 must be a integer or null
			->argument(8, 'boolean', 'null')		//Argument 8 must be a boolean or null
			->argument(9, 'boolean', 'null')		//Argument 9 must be a boolean or null
			->argument(10, 'string', 'null');		//Argument 10 must be a string or null
			
			
		$query = array('base-hostname' => $hostName, 'api_key' => $apiKey);
		//if it is not empty
		if(!is_null($type)) {
			//lets put it in the query
			$query['type'] = $type;
		}
		//if it is not empty
		if(!is_null($id)) {
			//lets put it in the query
			$query['id'] = $id;
		}
		//if it is not empty
		if(!is_null($tag)) {
			//lets put it in the query
			$query['tag'] = $tag;
		}
		//if it is not empty
		if(!is_null($limit)) {
			//lets put it in the query
			$query['limit'] = $limit;
		}
		//if it is not empty
		if(!is_null($offset)) {
			//lets put it in the query
			$query['offset'] = $offset;
		}
		//if its reblog
		if($reblog) {
			$query['reblog_info'] = 0;
		}
		//if its reblog
		if($notes) {
			$query['notes_info'] = 0;
		}
		//if it is not empty
		if(!is_null($format)) {
			//lets put it in the query
			$query['format'] = $format;
		}
		
		return $this->_getResponse(self::URL_GET_POST, $query);
	 }
	 /**
	 * Get complete set draft post
	 *
	 * @return $this
	 */
	 public function getDraft() {
		return $this->_getResponse(self::URL_GET_DRAFT);
	 }
	 /**
	 * Get complete set submmision post
	 *
	 * @return $this
	 */
	 public function getSubmission() {
		return $this->_getResponse(self::URL_GET_SUBMISION);
	 }
	 /**
	 * Add or create a blog
	 *
	 * @param type is string
	 * @param state is string
	 * @param tag is string
	 * @param tweets is string
	 * @param date is string
	 * @param markdown is boolean
	 * @param slug is string
	 * @return $this
	 */
	 public function add($type, $state = NULL, $tag = NULL, $tweets = NULL, $date = NULL, $markdown = NULL, $slug = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string', 'null')			//Argument 2 must be a string or null
			->argument(3, 'string', 'null')			//Argument 3 must be a string or null
			->argument(4, 'string', 'null')			//Argument 4 must be a string or null
			->argument(5, 'string', 'null')			//Argument 5 must be a string or null
			->argument(6, 'boolean', 'null')		//Argument 6 must be a boolean or null
			->argument(7, 'string', 'null');		//Argument 7 must be a string or null
			
		$query = array('type' => $type);
		//if it is not empty
		if(!is_null($state)) {
			//lets put it in query
			$query['state'] = $state;
		}
		//if it is not empty
		if(!is_null($tag)) {
			//lets put it in query
			$query['tag'] = $tag;
		}
		//if it is not empty
		if(!is_null($tweets)) {
			//lets put it in query
			$query['tweets'] = $tweets;
		}
		//if it is not empty
		if(!is_null($tweets)) {
			//lets put it in query
			$query['tweets'] = $tweets;
		}
		//if it is not empty
		if(!is_null($date)) {
			//lets put it in query
			$query['date'] = $date;
		}
		//if its markdown
		if($markdown) {
			$query['markdown'] = 0;
		}
		//if it is not empty
		if(!is_null($slug)) {
			//lets put it in query
			$query['slug'] = $slug;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $type);
		return $this->_post($url,$query);
	 }
	/**
	 * Add text
	 *
	 * @param body is string
	 * @param title is string
	 * @return $this
	 */
	 public function addText($body, $title = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string', 'null');		//Argument 2 must be a string or null
			
		$query = array('body' => $body);
		//if it is not empty
		if(!is_null($title)) {
			//lets put it in query
			$query['title'] = $title;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $body);
		return $this->_post($url,$query);
	 }
	/**
	 * Add photo
	 *
	 * @param source is a string
	 * @param data is array
	 * @param caption is a string
	 * @param link is a string
	 * @return $this
	 */
	 public function addPhoto($source, $data, $caption = NULL, $link = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'array')					//Argument 1 must be a array
			->argument(3, 'string', 'null')			//Argument 1 must be a array
			->argument(4, 'string', 'null');		//Argument 2 must be a string or null
			
		$query = array('body' => $body,'data' =>$data);
		//if it is not empty
		if(!is_null($caption)) {
			//lets put it in query
			$query['caption'] = $caption;
		}
		//if it is not empty
		if(!is_null($link)) {
			//lets put it in query
			$query['link'] = $link;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $source);
		return $this->_post($url,$query);
	 }
	/**
	 * Add quote
	 *
	 * @param quote is a string
	 * @param source is a string
	 * @return $this
	 */
	 public function addQuote($quote, $source = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string', 'null');		//Argument 1 must be a string	
			
		$query = array('qoute' => $qoute);
		//if it is not empty
		if(!is_null($source)) {
			//lets put it in query
			$query['source'] = $source;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $qoute);
		return $this->_post($url,$query);
	 }
	 /**
	 * Add link
	 *
	 * @param url is a string
	 * @param title is a string
	 * @param description is string
	 * @return $this
	 */
	 public function addLink($url, $title = NULL, $description = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string', 'null')			//Argument 2 must be a string
			->argument(3, 'string', 'null');		//Argument 3 must be a string	
			
		$query = array('url' => $url);
		//if it is not empty
		if(!is_null($title)) {
			//lets put it in query
			$query['title'] = $title;
		}
		//if it is not empty
		if(!is_null($description)) {
			//lets put it in query
			$query['description'] = $description;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $url);
		return $this->_post($url,$query);
	 }
	 /**
	 * Add chat
	 *
	 * @param conversation is a string
	 * @param title is a string
	 * @return $this
	 */
	 public function addChat($conversation, $title = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string', 'null');		//Argument 2 must be a string	
			
		$query = array('conversation' => $conversation);
		//if it is not empty
		if(!is_null($title)) {
			//lets put it in query
			$query['title'] = $title;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $conversation);
		return $this->_post($url,$query);
	 }
	 /**
	 * Add audio
	 *
	 * @param data is a string
	 * @param externalis a string
	 * @param caption is a string
	 * @return $this
	 */
	 public function addAudio($data, $external, $caption = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string')					//Argument 2 must be a string
			->argument(3, 'string', 'null');		//Argument 3 must be a string	
			
		$query = array('data' => $data, 'external_url' => $external);
		//if it is not empty
		if(!is_null($caption)) {
			//lets put it in query
			$query['caption'] = $caption;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $data);
		return $this->_post($url,$query);
	 }
	 /**
	 * Add video
	 *
	 * @param data is string
	 * @param embed is string
	 * @param caption is string
	 * @return $this
	 */
	 public function addVideo($data, $embed, $caption = NULL) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'string')					//Argument 1 must be a string
			->argument(2, 'string')					//Argument 2 must be a string
			->argument(3, 'string', 'null');		//Argument 3 must be a string	
			
		$query = array('data' => $data, 'embed' => $embed);
		//if it is not empty
		if(!is_null($caption)) {
			//lets put it in query
			$query['caption'] = $caption;
		}
		
		$url = sprintf(self::URL_ADD_BLOG, $data);
		return $this->_post($url,$query);
	 }
	 /**
	 * update blog post
	 *
	 * @param $id is a integer
	 * @return $this
	 */
	 public function update($Id) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer');					//Argument 1 must be a integer
			
		$query = array('Id' => $Id);
		
		$url = sprintf(self::URL_UPDATE, $Id);
		return $this->_post($url,$query);
	 }
	 /**
	 * reblog a post
	 *
	 * @param id is a integer
	 * @param reblog is a integer
	 * @param comment is a string
	 * @return $this
	 */
	 public function reblog($Id, $reblog, $comment) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer')				//Argument 1 must be a integer
			->argument(2, 'integer')				//Argument 2 must be a integer
			->argument(3, 'string');					//Argument 3 must be a integer
			
		$query = array('Id' => $Id, 'reblog_key' => $reblog);
		//if it is not empty
		if(!is_null($comment)) {
			$query['comment'] = $comment;
		}
		
		$url = sprintf(self::URL_REBLOG, $Id);
		return $this->_post($url,$query);
	 }
	 /**
	 * delete a post
	 *
	 * @param id is a integer
	 * @return $this
	 */
	 public function remove($Id) {
		 //Argument Test
		 Eden_Tumblr_Error::i()
			->argument(1, 'integer');				//Argument 1 must be a integer 
			
		$query = array('Id' => $Id);
		
		$url = sprintf(self::URL_REMOVE, $Id);
		return $this->_post($url,$query);
	 }
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}