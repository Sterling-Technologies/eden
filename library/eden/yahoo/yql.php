<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Abstractly defines a layout of available methods to
 * connect to and query a database. This class also lays out 
 * query building methods that auto renders a valid query
 * the specific database will understand without actually 
 * needing to know the query language.
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Yahoo_Yql extends Eden_Class {
	/* Constants
	-------------------------------*/
	const SELECT 		= 'Eden_Yahoo_Select';
	const YQL_URL		= 'http://query.yahooapis.com/v1/public/yql';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_queries = array();
	protected $_token = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct() {
		//$this->_token = $token;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the select query builder
	 *
	 * @return Eden_Yahoo_Select
	 */ 
	public function select($select = '*') {
		//Argument 1 must be a string or array
		Eden_Yahoo_Error::i()->argument(1, 'string', 'array');
		
		return Eden_Yahoo_Select::i()->select($select);
	}
	
	/**
	 * Returns search
	 *
	 * @return Eden_Facebook_Search
	 */
	public function search() {
		return Eden_Yahoo_Search::i($this);
	}
	
	/**
	 * Returns a 1 row result given the column name and the value
	 *
	 * @param string table
	 * @param string name
	 * @param string value
	 * @return array
	 */
	public function getRow($table, $name, $value) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'numeric');	//Argument 3 must be a string or number
		
		$query = $this->select()
			->from($table)
			->where($name.' = '.$value)
			->limit(0, 1);
		
		$results = $this->query($query);
		
		return isset($results[0]) ? $results[0] : NULL;
	}
	
	/**
	 * Returns a list of results given the query parameters
	 *
	 * @param string table
	 * @param array filter
	 * @param array sort
	 * @param int start
	 * @param int range
	 * @return array
	 */
	public function getRows($table, $filters = NULL, array $sort = array(), $start = 0, $range = 0, $index = NULL) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'string', 'array', 'null')	//Argument 3 must be a string number or null
			->argument(4, 'numeric')					//Argument 5 must be a number
			->argument(5, 'numeric')					//Argument 6 must be a number
			->argument(6, 'numeric', 'null');			//Argument 7 must be a number or null
		
		$query = $this->select()->from($table);
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				if(!is_array($filter)) {
					continue;
				}
				
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		if(!is_null($filters)) {
			$query->where($filters);
		}
		
		if(!empty($sort)) {
			foreach($sort as $key => $value) {
				if(is_string($key) && trim($key)) {
					$query->sortBy($key, $value);
				}
			}
		}
		
		if($range) {
			$query->limit($start, $range);
		}
		
		$results = $this->query($query);
		
		if(!is_null($index)) { 
			if(empty($results)) {
				$results = NULL;
			} else {
				if($index == self::FIRST) {
					$index = 0;
				} 
				
				if($index == self::LAST) {
					$index = count($results)-1;
				}
				
				if(isset($results[$index])) {
					$results = $results[$index];
				} else {
					$results = NULL;
				}	
			}
		}
		
		return $results;
	}
	
	/**
	 * Returns the number of results given the query parameters
	 *
	 * @param string table
	 * @param array filter
	 * @return int | false
	 */
	public function getRowsCount($table, $filters = NULL) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'string', 'array', 'null');	//Argument 3 must be a string number or null
		
		$query = $this->select('COUNT(*) as count')->from($table);
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				if(!is_array($filter)) {
					continue;
				}
				
				$format = array_shift($filter);
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		if(!is_null($filters)) {
			$query->where($filters);
		}
		
		$results = $this->query($query);
		
		if(isset($results[0]['count'])) {
			return $results[0]['count'];
		}
		
		return false;
	}
	
	/**
	 * Returns a model given the column name and the value
	 *
	 * @param string table
	 * @param string name
	 * @param string value
	 * @return array|NULL
	 */
	public function getModel($table, $name, $value) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'numeric');	//Argument 3 must be a string or number

		$result = $this->getRow($table, $name, $value);
		
		$model = Eden_Model::i();
		
		if(is_null($result)) {
			return $model;
		}
		
		return $model->set($result);
	}
	
	/**
	 * Returns a collection given the query parameters
	 *
	 * @param string table
	 * @param array filter
	 * @param array sort
	 * @param int start
	 * @param int range
	 * @return array
	 */
	public function getCollection($table, $filters = NULL, array $sort = array(), $start = 0, $range = 0, $index = NULL) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(2, 'string', 'array', 'null')	//Argument 3 must be a string number or null
			->argument(4, 'numeric')					//Argument 5 must be a number
			->argument(5, 'numeric')					//Argument 6 must be a number
			->argument(6, 'numeric', 'null');			//Argument 7 must be a number or null
		
		$results = $this->getRows($table, $filters, $sort, $start, $range, $index);
		
		$collection = Eden_Collection::i();
		
		if(is_null($results)) {
			return $collection;
		}
		
		if(!is_null($index)) {
			return $this->model($results);
		}
		
		return $collection->set($results);
	}
	
	/**
	 * Queries the database
	 * 
	 * @param string query
	 * @return array|object
	 */
	public function query($query) {
		//Argument 1 must be a string or null
		Eden_Yahoo_Error::i()->argument(1, 'string', 'array', self::SELECT);
		
		if(!is_array($query)) {
			$query = array('q' => (string) $query);
		} else {
			foreach($query as $key => $select) {
				$query[$key] = (string) $select;
			}
			
			$query = array('q' => json_encode($query));
		}
		
		$query['access_token'] = $this->_token;
		$url = str_replace('+', '%20', self::YQL_URL.'?'.http_build_query($query + array('format' => 'json')));
		
		$results = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyPeer(false)
			->setUserAgent(Eden_Facebook_Auth::USER_AGENT)
			->setHeaders('Expect')
			->getJsonResponse();
			
		$this->_queries[] = array(
			'query' 	=> $query['q'],
			'results' 	=> $results);
			
		if(isset($results['error']['message'])) {
			Eden_Facebook_Error::i($query['q'].$results['error']['message'])->trigger();
		}
		
		return $results;
	}
	
	
	/**
	 * Returns the history of queries made still in memory
	 * 
	 * @return array the queries
	 */
	public function getQueries($index = NULL) {
		if(is_null($index)) {
			return $this->_queries;
		}
		
		if($index == self::FIRST) {
			$index = 0;
		}
		
		if($index == self::LAST) {
			$index = count($this->_queries) - 1;
		}
		
		if(isset($this->_queries[$index])) {
			return $this->_queries[$index];
		}
		
		return NULL;
	}
		
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}