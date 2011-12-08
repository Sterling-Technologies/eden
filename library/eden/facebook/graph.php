<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.st.
 */

/**
 * Facebook Authentication
 *
 * @package    Eden
 * @subpackage file
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: model.php 4 2010-01-06 04:41:07Z blanquera $
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
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($token) {
		return self::_getMultiple(__CLASS__, $token);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($token) {
		$this->_token = $token;
	}
	
	/* Public Methods
	-------------------------------*/
	public function getObject($id = 'me', $connection = NULL, array $query = array(), $auth = true) {
		if($connection) {
			$connection = '/'.$connection;
		}
		
		$url = self::GRAPH_URL.$id.$connection;
		
		if($auth) {
			if(!$this->_token) {
				throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
			}
			
			$query['access_token'] = $this->_token;
		}
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$object = $this->_call($url);
		$object = json_decode($object, true);
		
		if (isset($object['error'])) {
			throw new Eden_Facebook_Error(sprintf(
				Eden_Facebook_Error::GRAPH_FAILED, 
				$url, $object['error']['type'], 
				$object['error']['message']));
		}
		
		return $object;
	}
	
	public function getFields($id = 'me', $fields) {
		if(is_array($fields)) {
			$fields = implode(',', $fields);
		}
		
		return $this->getObject($id, NULL, array('fields' => $fields));
	}
	
	public function getUser() {
		return $this->getObject('me');
	}
	
	public function getPictureUrl($id = 'me', $token = true) {
		$url = self::GRAPH_URL.$id.'/picture';
		
		if($token) {
			$url .= '?access_token='.$this->_token;
		}
		
		return $url;
	}
	
	public function getLogoutUrl($redirect) {
		return sprintf(self::LOGOUT_URL, urlencode($redirect), $this->_token);
	}
	
	public function getFriends($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'friends', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getNews($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'home', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getWall($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'feed', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getLikes($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'likes', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getMovies($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'movies', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getMusic($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'music', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getBooks($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'books', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getPermissions($id = 'me') {
		$permissions = $this->getObject($id, 'permissions');
		return $permissions['data'];
	}
	
	public function getPhotos($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'photos', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getAlbums($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'albums', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getVideos($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'videos', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getVideoUploads($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'videos/uploaded', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getEvents($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'events', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getGroups($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'groups', $start, $range, $since, $until, $dateFormat);
	}
	
	public function getCheckIns($id = 'me', $start = 0, $range = 0, $since = 0, $until = 0, $dateFormat = NULL) {
		return $this->_getList($id, 'checkins', $start, $range, $since, $until, $dateFormat);
	}
	
	public function searchPosts($query, $fields = NULL) {
		return $this->_search('post', $query, $fields);
	}
	
	public function searchUsers($query, $fields = NULL) {
		return $this->_search('user', $query, $fields);
	}
	
	public function searchPages($query, $fields = NULL) {
		return $this->_search('page', $query, $fields);
	}
	
	public function searchEvents($query, $fields = NULL) {
		return $this->_search('event', $query, $fields);
	}
	
	public function searchGroups($query, $fields = NULL) {
		return $this->_search('group', $query, $fields);
	}
	
	public function searchPlaces($query, $fields = NULL) {
		return $this->_search('place', $query, $fields);
	}
	
	public function searchCheckins($query, $fields = NULL) {
		return $this->_search('checkin', $query, $fields);
	}
	
	public function addPost($message, $id = 'me', $link = NULL, $picture = NULL, 
		$video = NULL, $caption = NULL, $linkName = NULL, $linkDescription = NULL) {
		
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('message' => $message);
		
		if($link) {
			$post['link'] = $link;
		}
		
		if($picture) {
			$post['picture'] = $picture;
		}
		
		if($video) {
			$post['source'] = $video;
		}
		
		if($caption) {
			$post['caption'] = $caption;
		}
		
		if($linkName) {
			$post['name'] = $linkName;
		}
		
		if($linkDescription) {
			$post['description'] = $linkDescription;
		}
		
		$url = self::GRAPH_URL.$id.'/feed';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}

	public function addComment($id, $message) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('message' => $message);
		
		$url = self::GRAPH_URL.$id.'/comments';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	public function like($id) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$url = self::GRAPH_URL.$id.'/likes';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$this->_call($url);
		
		return $this;
	}
	
	public function addNote($id, $subject, $message) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('subject' => $subject, 'message' => $message);
		
		$url = self::GRAPH_URL.$id.'/notes';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	public function addEvent($name, $start, $end) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('name'=>$name,'start_time'=>$start,'end_time'=>$end);
		
		$url = self::GRAPH_URL.$id.'/events';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	public function attendEvent($id) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$url = self::GRAPH_URL.$id.'/attending';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	public function maybeEvent($id) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$url = self::GRAPH_URL.$id.'/maybe';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	public function declineEvent($id) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$url = self::GRAPH_URL.$id.'/declined';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		json_decode($this->_call($url), true);
		
		return $this;
	}
	
	public function addLink($id, $url, $message = NULL, $name = NULL, $description = NULL, $picture = NULL, $caption = NULL) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('url' => $url);
		
		if($message) {
			$post['message'] = $message;
		}
		
		if($name) {
			$post['name'] = $name;
		}
		
		if($description) {
			$post['description'] = $description;
		}
		
		if($picture) {
			$post['picture'] = $picture;
		}
		
		if($caption) {
			$post['caption'] = $caption;
		}
		
		$url = self::GRAPH_URL.$id.'/links';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	public function addAlbum($id, $name, $message) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('name'=>$name,'message'=>$message);
		
		$url = self::GRAPH_URL.$id.'/albums';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	public function addPhoto($id, $data) {}
	
	public function addCheckin($id, $message, $coordinates, $place, $tags) {
		if(!$this->_token) {
			throw new Eden_Facebook_Error(sprintf(Eden_Facebook_Error::REQUIRES_AUTH, $url));
		}
		
		$post = array('message' => $message);
		
		if($message) {
			$post['message'] = $message;
		}
		
		if($coordinates) {
			$post['coordinates'] = $coordinates;
		}
		
		if($place) {
			$post['place'] = $place;
		}
		
		if($tags) {
			$post['tags'] = $tags;
		}
		
		$url = self::GRAPH_URL.$id.'/checkins';
		
		$query = array('access_token' => $this->_token);
		
		if(!empty($query)) {
			$url .= '?'.http_build_query($query);
		}
		
		$results = json_decode($this->_call($url, $post), true);
		return $results['id'];
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _call($url, array $post = array()) {
		//Argument 1 must be a string
		Eden_Facebook_Error::get()->argument(1, 'string');
		
		return Eden_Curl::get()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setUserAgent(Eden_Facebook_Auth::USER_AGENT)
			->setHeaders('Expect')
			->when(!empty($post))
			->setPost(true)
			->setPostFields(http_build_query($post))
			->endWhen()
			->getResponse();
		
	}
	
	protected function _getList($id, $connection, $start, $range, $since = 0, $until = 0, $dateFormat = NULL) {
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
	
	protected function _search($connection, $query, $fields) {
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