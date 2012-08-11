<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.st.
 */

/**
 * Facebook Authentication
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Graph extends Eden_Class {
	/* Constants
	-------------------------------*/
	const GRAPH_URL	= 'https://graph.facebook.com/';
	const LOGOUT_URL = 'https://www.facebook.com/logout.php?next=%s&access_token=%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token = NULL;
	
	protected $_list = array(
		'Friends',		'Home',
		'Feed',			'Likes',
		'Movies',		'Music',
		'Books',		'Photos',
		'Albums',		'Videos',
		'VideoUploads', 'Events',
		'Groups',		'Checkins');
	
	protected $_search = array(
		'Posts',		'Users',
		'Pages',		'Likes',
		'Places',		'Events',
		'Groups',		'Checkins');
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __call($name, $args) {
		//if the method starts with get
		if(strpos($name, 'get') === 0 && in_array(substr($name, 3), $this->_list)) {
			$key = preg_replace("/([A-Z])/", "/$1", $name);
			//get rid of get
			$key = strtolower(substr($key, 4));
			
			$id = 'me';
			if(!empty($args)) {
				$id = array_shift($args);
			}
			
			array_unshift($args, $id, $key);
			
			return call_user_func_array(array($this, '_getList'), $args);
		} else if(strpos($name, 'search') === 0 && in_array(substr($name, 6), $this->_search)) {

			//get rid of get
			$key = strtolower(substr($name, 6));
			
			array_unshift($args, $key);
			
			return call_user_func_array(array($this, '_search'), $args);
		} 
	}
	
	public function __construct($token) {
		$this->_token = $token;
	}
	/* Public Methods
	-------------------------------*/	
	
	/**
	 * Add an album
	 *
	 * @param string|int the object ID to place the album
	 * @param string
	 * @param string the album description
	 * @return int the album ID
	 */
	public function addAlbum($id, $name, $message) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string');			//Argument 3 must be a string
		
		//form the URL
		$url 		= self::GRAPH_URL.$id.'/albums';
		$post 		= array('name'=>$name,'message'=>$message);
		$query 		= array('access_token' => $this->_token);
		$url 		.= '?'.http_build_query($query);
		$results 	= json_decode($this->_call($url, $post), true);
		
		return $results['id'];
	}
	
	/**
	 * Adds a comment to a post
	 *
	 * @param int the post ID commenting on
	 * @param string
	 * @return int the comment ID
	 */
	public function addComment($id, $message) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'int')		//Argument 1 must be an integer
			->argument(2, 'string');	//Argument 2 must be a string
		
		//form the URL	
		$url 		= self::GRAPH_URL.$id.'/comments';
		$post 		= array('message' => $message);
		$query 		= array('access_token' => $this->_token);
		$url 		.= '?'.http_build_query($query);
		$results 	= json_decode($this->_call($url, $post), true);
		
		return $results['id'];
	}
	
	/**
	 * Attend an event
	 *
	 * @param int the event ID
	 * @return this
	 */
	public function attendEvent($id) {
		Eden_Facebook_Error::i()->argument(1, 'int');
		
		$url 	= self::GRAPH_URL.$id.'/attending';
		$query 	= array('access_token' => $this->_token);
		$url 	.= '?'.http_build_query($query);
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	/**
	 * Check into a place
	 *
	 * @param string|int the checkin ID
	 * @param string 
	 * @param float
	 * @param float
	 * @param int the place ID
	 * @param string|array
	 * @return int
	 */
	public function checkin($id, $message, $latitude, $longitude, $place, $tags) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or integer
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'float')				//Argument 3 must be a string
			->argument(4, 'float')				//Argument 4 must be a string
			->argument(5, 'int')				//Argument 5 must be a string
			->argument(6, 'string', 'array');	//Argument 6 must be a string
			
		$url 	= self::GRAPH_URL.$id.'/checkins';
		$post 	= array('message' => $message);
		$query 	= array('access_token' => $this->_token);
		$url 	.= '?'.http_build_query($query);
			
		//if message
		if($message) {
			//add it
			$post['message'] = $message;
		}
		
		//if coords
		if($latitude && $longitute) {
			//add it
			$post['coordinates'] = json_encode(array(
				'latitude' 	=> $latitude,
				'longitude' => $longitude));
		}
		
		//if place
		if($place) {
			//add it
			$post['place'] = $place;
		}
		
		//if tags
		if($tags) {
			//add it
			$post['tags'] = $tags;
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	/**
	 * Add a note
	 *
	 * @param int|string object ID where to put the note
	 * @param string
	 * @param string
	 * @return int
	 */
	public function createNote($id = 'me', $subject, $message) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')	//Argument 1 must be a string or integer
			->argument(2, 'string')			//Argument 2 must be a string
			->argument(3, 'string');		//Argument 3 must be a string
		
		//form the URL	
		$url 		= self::GRAPH_URL.$id.'/notes';
		$post 		= array('subject' => $subject, 'message' => $message);
		$query 		= array('access_token' => $this->_token);
		$url 		.= '?'.http_build_query($query);
		$results 	= json_decode($this->_call($url, $post), true);
		
		return $results['id'];
	}
	
	/**
	 * Decline an event
	 *
	 * @param int event ID
	 * @return this
	 */
	public function declineEvent($id) {
		Eden_Facebook_Error::i()->argument(1, 'int');
		$url 	= self::GRAPH_URL.$id.'/declined';
		$query 	= array('access_token' => $this->_token);
		$url 	.= '?'.http_build_query($query);
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	/**
	 * Add an event
	 *
	 * @param string name of event
	 * @param string|int string date or time format
	 * @param string|int string date or time format
	 * @return Eden_Facebook_Event
	 */
	public function event($name, $start, $end) {
		return Eden_Facebook_Event::i($this->_token, $name, $start, $end);
	}
	/**
	 * Returns specific fields of an object
	 *
	 * @param string|int
	 * @param string|array
	 * @return array
	 */
	public function getFields($id = 'me', $fields) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or int
			->argument(2, 'string', 'array');	//Argument 2 must be a string or array
		
		//if fields is an array	
		if(is_array($fields)) {
			//make it into a string
			$fields = implode(',', $fields);
		}
		
		//call it
		return $this->getObject($id, NULL, array('fields' => $fields));
	}
	
	/**
	 * Returns the logout URL
	 *
	 * @param string
	 * @return string
	 */
	public function getLogoutUrl($redirect) {
		Eden_Facebook_Error::i()->argument(1, 'url');
		return sprintf(self::LOGOUT_URL, urlencode($redirect), $this->_token);
	}
	
	/** 
	 * Returns the detail of any object
	 *
	 * @param string|int
	 * @param string|null
	 * @param array
	 * @param bool
	 * @return array
	 */
	public function getObject($id = 'me', $connection = NULL, array $query = array(), $auth = true) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or int
			->argument(2, 'string', 'null')		//Argument 2 must be a string or null
			->argument(3, 'array')				//Argument 3 must be an array
			->argument(4, 'bool');				//Argument 4 must be a boolean
		
		//if we have a connection	
		if($connection) {
			//prepend a slash
			$connection = '/'.$connection;
		}
		
		//for the url
		$url = self::GRAPH_URL.$id.$connection;
		
		//if this requires authentication
		if($auth) {
			//add the token
			$query['access_token'] = $this->_token;
		}
		
		//if we have a query
		if(!empty($query)) {
			//append it to the url
			$url .= '?'.http_build_query($query);
		}
		
		//call it
		$object = $this->_call($url);
		$object = json_decode($object, true);
		
		//if there is an error
		if (isset($object['error'])) {
			//throw it
			Eden_Facebook_Error::i()
				->setMessage(Eden_Facebook_Error::GRAPH_FAILED)
				->addVariable($url)
				->addVariable($object['error']['type'])
				->addVariable($object['error']['message'])
				->trigger();
		}
		
		return $object;
	}
	
	/**
	 * Returns user permissions
	 *
	 * @param string|int
	 * @return array
	 */
	public function getPermissions($id = 'me') {
		Eden_Facebook_Error::i()->argument(1, 'string', 'int');
		$permissions = $this->getObject($id, 'permissions');
		return $permissions['data'];
	}
	
	/**
	 * Returns the user's image
	 *
	 * @param string|int
	 * @param bool
	 * @return string
	 */
	public function getPictureUrl($id = 'me', $token = true) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or int
			->argument(2, 'bool');				//Argument 2 must be a boolean
		
		//for the URL	
		$url = self::GRAPH_URL.$id.'/picture';
		
		//if this needs a token
		if($token) {
			//add it
			$url .= '?access_token='.$this->_token;
		}
		
		return $url;
	}
	
	/**
	 * Returns the user info
	 *
	 * @return array
	 */
	public function getUser() {
		return $this->getObject('me');
	}
	
	/**
	 * Like an object
	 *
	 * @param int|string object ID
	 * @return array
	 */
	public function like($id) {
		Eden_Facebook_Error::i()->argument(1, 'string', 'int');
		$url = self::GRAPH_URL.$id.'/likes';
		$query = array('access_token' => $this->_token);
		$url .= '?'.http_build_query($query);
		
		$this->_call($url);
		return $this;
	}
	
	/**
	 * Add a link
	 *
	 * @param string
	 * @return Eden_Facebook_Link
	 */
	public function link($url) {
		return Eden_Facebook_Link::i($this->_token, $url);
	}
	
	/**
	 * Maybe an event
	 *
	 * @param int event ID
	 * @return this
	 */
	public function maybeEvent($id) {
		Eden_Facebook_Error::i()->argument(1, 'int');
		
		$url 	= self::GRAPH_URL.$id.'/maybe';
		$query 	= array('access_token' => $this->_token);
		$url 	.= '?'.http_build_query($query);
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	/**
	 * Returns Facebook Post
	 *
	 * @param string
	 * @return Eden_Facebook_Post
	 */
	public function post($message) {
		return Eden_Facebook_Post::i($this->_token, $message);
	}
	
	/**
	 * Uploads a file of your album
	 *
	 * @param int|string
	 * @param string
	 * @param string|null
	 * @return int photo ID
	 */
	public function uploadPhoto($albumId, $file, $message = NULL) {
		//Argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string', 'int')		//Argument 1 must be a string or integer
			->argument(2, 'file')				//Argument 2 must be a file
			->argument(3, 'string', 'null');	//Argument 3 must be a string or null
			
		//form the URL
		$url 		= self::GRAPH_URL.$albumId.'/photos';
		$post 		= array('source' => '@'.$file);
		$query 		= array('access_token' => $this->_token);
		
		//if there is a message
		if($message) {
			$post['message'] = $message;
		}
		
		$url .= '?'.http_build_query($query);
		
		//send it off
		$results = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setUserAgent(Eden_Facebook_Auth::USER_AGENT)
			->setHeaders('Expect')
			->when(!empty($post), 2)
			->setPost(true)
			->setPostFields($post)
			->getJsonResponse();
		
		return $results['id'];
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _call($url, array $post = array()) {
		return Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setUserAgent(Eden_Facebook_Auth::USER_AGENT)
			->setHeaders('Expect')
			->when(!empty($post), 2)
			->setPost(true)
			->setPostFields(http_build_query($post))
			->getResponse();
		
	}
	
	protected function _getList($id, $connection, $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		$query = array();
		if($start > 0) {
			$query['offset'] = $start;
		}
		
		if($range > 0) {
			$query['limit'] = $range;
		}
		
		if(is_string($since)) {
			$since = strtotime($since);
		}
		
		if(is_string($until)) {
			$until = strtotime($until);
		}
		
		if($since !== 0) {
			$query['since'] = $since;
		}
		
		if($until !== 0) {
			$query['until'] = $until;
		}
		
		$list = $this->getObject($id, $connection, $query);
		
		return $list['data'];
	}
	
	protected function _search($connection, $query, $fields = NULL) {
		$query = array('type' => $connection, 'q' => $query);
		
		if(is_array($fields)) {
			$fields = implode(',', $fields);
		}
		
		if($fields) {
			$query['fields'] = $fields;
		}
		
		$results = $this->getObject('search', NULL, $query);
		
		return $results['data'];
	}
	
	/* Private Methods
	-------------------------------*/
}