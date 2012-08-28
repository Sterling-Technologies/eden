<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/../event.php';
require_once dirname(__FILE__).'/../collection.php';
require_once dirname(__FILE__).'/../model.php';
require_once dirname(__FILE__).'/error.php';
require_once dirname(__FILE__).'/query.php';
require_once dirname(__FILE__).'/delete.php';
require_once dirname(__FILE__).'/select.php';
require_once dirname(__FILE__).'/update.php';
require_once dirname(__FILE__).'/insert.php';
require_once dirname(__FILE__).'/collection.php';
require_once dirname(__FILE__).'/model.php';
require_once dirname(__FILE__).'/search.php';

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
abstract class Eden_Sql_Database extends Eden_Event {
	/* Constants
	-------------------------------*/
	const QUERY = 'Eden_Sql_Query';
	
	const FIRST = 'first';
	const LAST	= 'last';
	
	const MODEL 		= 'Eden_Sql_Model';
	const COLLECTION 	= 'Eden_Sql_Collection';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_queries = array();
	
	protected $_connection 	= NULL;
	protected $_binds 		= array();
	
	protected $_model 		= self::MODEL;
	protected $_collection 	= self::COLLECTION;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Connects to the database
	 * 
	 * @param array the connection options
	 * @return this
	 */
	abstract public function connect(array $options = array());
	
	/**
	 * Binds a value and returns the bound key
	 *
	 * @param string
	 * @return string
	 */
	public function bind($value) {
		//Argument 1 must be an array, string or number
		Eden_Sql_Error::i()->argument(1, 'array', 'string', 'numeric', 'null');
		
		if(is_array($value)) {
			foreach($value as $i => $item) {
				$value[$i] = $this->bind($item);
			}
			
			return '('.implode(",",$value).')';
		} else if(is_numeric($value)) {
			return $value;
		}
		
		$name = ':bind'.count($this->_binds).'bind';
		$this->_binds[$name] = $value;
		return $name;
	}
	
	/**
	 * Returns collection
	 *
	 * @return Eden_Sql_Collection
	 */
	public function collection(array $data = array()) {
		$collection = $this->_collection;
		return $this->$collection()
			->setDatabase($this)
			->setModel($this->_model)
			->set($data);
	}
	
	/**
	 * Returns the delete query builder
	 *
	 * @return Eden_Sql_Delete
	 */ 
	public function delete($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Delete::i($table);
	}
	
	/**
	 * Removes rows that match a filter
	 *
	 * @param string table
	 * @param array filter
	 * @return var
	 */
	public function deleteRows($table, $filters = NULL) {
		//Argument 1 must be a string
		Eden_Sql_Error::i()->argument(1, 'string');
		
		$query = $this->delete($table);
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				
				foreach($filter as $j => $value) {
					$filter[$j] = $this->bind($value);
				}
				
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		$query->where($filters);
		
		//run the query
		$this->query($query, $this->getBinds());	
		
		$this->trigger($table, $filters);
		
		return $this;
	}
	
	/**
	 * Returns all the bound values of this query
	 *
	 * @param void
	 * @return array
	 */
	public function getBinds() {
		return $this->_binds;
	}
	
	/**
	 * Returns a collection given the query parameters
	 *
	 * @param string table
	 * @param array joins
	 * @param array filter
	 * @param array sort
	 * @param int start
	 * @param int range
	 * @return array
	 */
	public function getCollection($table, array $joins = array(), $filters = NULL, 
		array $sort = array(), $start = 0, $range = 0, $index = NULL) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(3, 'string', 'array', 'null')	//Argument 3 must be a string number or null
			->argument(5, 'numeric')					//Argument 5 must be a number
			->argument(6, 'numeric')					//Argument 6 must be a number
			->argument(7, 'numeric', 'null');			//Argument 7 must be a number or null
		
		$results = $this->getRows($table, $joins, $filters, $sort, $start, $range, $index);
		
		$collection = $this->collection()
			->setTable($table)
			->setModel($this->_model);
		
		if(is_null($results)) {
			return $collection;
		}
		
		if(!is_null($index)) {
			return $this->model($results)->setTable($table);
		}
		
		return $collection->set($results);
	}
	
	/**
	 * Returns the connection object
	 * if no connection has been made 
	 * it will attempt to make it
	 *
	 * @param array connection options
	 * @return PDO connection resource
	 */
	public function getConnection() {
		if(!$this->_connection) {
			$this->connect();
		}
		
		return $this->_connection;
	}
	
	/**
	 * Returns the last inserted id
	 *
	 * @return int the id
	 */
	public function getLastInsertedId() {
		return $this->getConnection()->lastInsertId();
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
		Eden_Sql_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'numeric');	//Argument 3 must be a string or number

		$result = $this->getRow($table, $name, $value);
		
		$model = $this->model()->setTable($table);
		
		if(is_null($result)) {
			return $model;
		}
		
		return $model->set($result);
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
		Eden_Sql_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'numeric');	//Argument 3 must be a string or number
		
		$query = $this->select()
			->from($table)
			->where($name.' = '.$this->bind($value))
			->limit(0, 1);
		
		$results = $this->query($query, $this->getBinds());
		
		$this->trigger($table, $name, $value, $results);
		
		return isset($results[0]) ? $results[0] : NULL;
	}
	
	/**
	 * Returns a list of results given the query parameters
	 *
	 * @param string table
	 * @param array joins
	 * @param array filter
	 * @param array sort
	 * @param int start
	 * @param int range
	 * @return array
	 */
	public function getRows($table, array $joins = array(), $filters = NULL, 
		array $sort = array(), $start = 0, $range = 0, $index = NULL) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(3, 'string', 'array', 'null')	//Argument 3 must be a string number or null
			->argument(5, 'numeric')					//Argument 5 must be a number
			->argument(6, 'numeric')					//Argument 6 must be a number
			->argument(7, 'numeric', 'null');			//Argument 7 must be a number or null
		
		$query = $this->select()->from($table);
		
		foreach($joins as $join) {
			if(!is_array($join) || count($join) < 3) {
				continue;
			}
			
			if(count($join) == 3) {
				$join[] = true;
			}
			
			$query->join($join[0], $join[1], $join[2], $join[3]);
		}
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				
				foreach($filter as $j => $value) {
					$filter[$j] = $this->bind($value);
				}
				
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
		
		$results = $this->query($query, $this->getBinds());
		
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
		
		$this->trigger($table, $joins, $filters, $sort, $start, $range, $index, $results);
		
		return $results;
	}
	
	/**
	 * Returns the number of results given the query parameters
	 *
	 * @param string table
	 * @param array filter
	 * @return int | false
	 */
	public function getRowsCount($table, array $joins = array(), $filters = NULL) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')						//Argument 1 must be a string
			->argument(3, 'string', 'array', 'null');	//Argument 3 must be a string number or null
		
		$query = $this->select('COUNT(*) as count')->from($table);
		
		foreach($joins as $join) {
			if(!is_array($join) || count($join) < 3) {
				continue;
			}
			
			if(count($join) == 3) {
				$join[] = true;
			}
			
			$query->join($join[0], $join[1], $join[2], $join[3]);
		}
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				$filter = $this->bind($filter);
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		$query->where($filters);
		
		$results = $this->query($query, $this->getBinds());
		
		if(isset($results[0]['count'])) {
			$this->trigger($table, $joins, $filters, $results[0]['count']);
			return $results[0]['count'];
		}
		
		$this->trigger($table, $joins, $filters, false);
		
		return false;
	}
	
	/**
	 * Returns the insert query builder
	 *
	 * @return Eden_Sql_Insert
	 */ 
	public function insert($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Insert::i($table);
	}
	
	/**
	 * Inserts data into a table and returns the ID
	 *
	 * @param string table
	 * @param array setting
	 * @return int
	 */
	public function insertRow($table, array $setting, $bind = true) {
		//Argument 1 must be a string
		Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'array', 'bool');
		
		$query = $this->insert($table);
		
		foreach($setting as $key => $value) {
			if(is_null($value) || is_bool($value)) {
				$query->set($key, $value);
				continue;
			}
			
			if((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
				$value = $this->bind($value);
			}
			
			$query->set($key, $value);
		}
		
		//run the query
		$this->query($query, $this->getBinds());	
		
		$this->trigger($table, $setting);
		
		return $this;
	}
	
	/**
	 * Inserts multiple rows into a table
	 *
	 * @param string table
	 * @param array settings
	 * @return void
	 */
	public function insertRows($table, array $settings, $bind = true) {
		//Argument 1 must be a string
		Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'array', 'bool');
		
		$query = $this->insert($table);
		
		foreach($settings as $index => $setting) {
			foreach($setting as $key => $value) {
				if(is_null($value) || is_bool($value)) {
					$query->set($key, $value);
					continue;
				}
				
				if((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
					$value = $this->bind($value);
				}

				$query->set($key, $value, $index);
			}
		}
		
		//run the query
		$this->query($query, $this->getBinds());	
		
		$this->trigger($table, $settings);
		
		return $this;
	}
	
	/**
	 * Returns model
	 *
	 * @return Eden_Sql_Model
	 */
	public function model(array $data = array()) {
		$model = $this->_model;
		return $this->$model($data)->setDatabase($this);
	}
	
	/**
	 * Queries the database
	 * 
	 * @param string query
	 * @param array binded value
	 * @return array|object
	 */
	public function query($query, array $binds = array()) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', self::QUERY);
		
		$connection = $this->getConnection();
		$query 		= (string) $query;
		$stmt 		= $connection->prepare($query);
		
		foreach($binds as $key => $value) {
			$stmt->bindValue($key, $value);
		}
		
		if(!$stmt->execute()) {
			$error = $stmt->errorInfo();
			
			foreach($binds as $key => $value) {
				$query = str_replace($key, "'$value'", $query);
			}
			
			Eden_Sql_Error::i()
				->setMessage(Eden_Sql_Error::QUERY_ERROR)
				->addVariable($query)
				->addVariable($error[2])
				->trigger();
		}
		
		$results = $stmt->fetchAll( PDO::FETCH_ASSOC );
		
		$this->_queries[] = array(
			'query' 	=> $query,
			'binds' 	=> $binds,
			'results' 	=> $results);
		
		$this->_binds = array();
		
		$this->trigger($query, $binds, $results);
		
		return $results;
	}
	
	/**
	 * Returns search
	 *
	 * @return Eden_Sql_Search
	 */
	public function search($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		$search = Eden_Sql_Search::i($this)
			->setCollection($this->_collection)
			->setModel($this->_model);
		
		if($table) {
			$search->setTable($table);
		}
		
		return $search;
	}
	
	/**
	 * Returns the select query builder
	 *
	 * @return Eden_Sql_Select
	 */ 
	public function select($select = '*') {
		//Argument 1 must be a string or array
		Eden_Sql_Error::i()->argument(1, 'string', 'array');
		
		return Eden_Sql_Select::i($select);
	}
	
	/**
	 * Sets all the bound values of this query
	 *
	 * @param array
	 * @return this
	 */
	public function setBinds(array $binds) {
		$this->_binds = $binds;
		return $this;
	}
	
	/**
	 * Sets default collection
	 *
	 * @param string
	 * @return this
	 */
	public function setCollection($collection) {
		$error = Eden_Sql_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($collection, self::COLLECTION)) {
			$error->setMessage(Eden_Sql_Error::NOT_SUB_COLLECTION)
				->addVariable($collection)
				->trigger();
		}
		
		$this->_collection = $collection;
		return $this;
	}
	
	/**
	 * Sets the default model
	 *
	 * @param string
	 * @return this
	 */
	public function setModel($model) {
		$error = Eden_Sql_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($model, self::MODEL)) {
			$error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)
				->addVariable($model)
				->trigger();
		}
		
		$this->_model = $model;
		return $this;
	}
	
	/**
	 * Sets only 1 row given the column name and the value
	 *
	 * @param string table
	 * @param string name
	 * @param string value
	 * @param array setting
	 * @return var
	 */
	public function setRow($table, $name, $value, array $setting) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string', 'numeric');	//Argument 3 must be a string or number
		
		//first check to see if the row exists
		$row = $this->getRow($table, $name, $value);
		
		if(!$row) {
			//we need to insert
			$setting[$name] = $value;
			return $this->insertRow($table, $setting);
		} else {
			//we need to update this row
			return $this->updateRows($table, $setting, array(array($name.'=%s', $value)));
		}
	}
	
	/**
	 * Returns the update query builder
	 *
	 * @return Eden_Sql_Update
	 */ 
	public function update($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Update::i($table);
	}
	
	/**
	 * Updates rows that match a filter given the update settings
	 *
	 * @param string table
	 * @param array setting
	 * @param array filter
	 * @return var
	 */
	public function updateRows($table, array $setting, $filters = NULL, $bind = true) {
		//Argument 1 must be a string
		Eden_Sql_Error::i()->argument(1, 'string')->argument(4, 'array', 'bool');
		
		$query = $this->update($table);
		
		foreach($setting as $key => $value) {
			if(is_null($value) || is_bool($value)) {
				$query->set($key, $value);
				continue;
			}
			
			if((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
				$value = $this->bind($value);
			}
			
			$query->set($key, $value);
		}
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				
				foreach($filter as $j => $value) {
					$filter[$j] = $this->bind($value);
				}
				
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		$query->where($filters);
		
		//run the query
		$this->query($query, $this->getBinds());	
		
		$this->trigger($table, $setting, $filters);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}