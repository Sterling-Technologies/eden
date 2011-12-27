<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/event.php';
require_once dirname(__FILE__).'/sql/error.php';
require_once dirname(__FILE__).'/mysql/error.php';
require_once dirname(__FILE__).'/sql/database.php';
require_once dirname(__FILE__).'/sql/query.php';
require_once dirname(__FILE__).'/sql/delete.php';
require_once dirname(__FILE__).'/sql/select.php';
require_once dirname(__FILE__).'/sql/update.php';
require_once dirname(__FILE__).'/sql/insert.php';
require_once dirname(__FILE__).'/mysql/alter.php';
require_once dirname(__FILE__).'/mysql/create.php';
require_once dirname(__FILE__).'/mysql/subselect.php';
require_once dirname(__FILE__).'/mysql/utility.php';

/**
 * Abstractly defines a layout of available methods to
 * connect to and query a database. This class also lays out 
 * query building methods that auto renders a valid query
 * the specific database will understand without actually 
 * needing to know the query language.
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: abstract.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Mysql extends Eden_Sql_Database {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_type = NULL;
	protected $_host = 'localhost';
	protected $_name = NULL;
	protected $_user = NULL;
	protected $_pass = NULL;
	protected $_queries = array();
	
	protected $_connection = NULL;
	protected $_binds 	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($host = NULL, $name = NULL, $user = NULL, $pass = NULL) {
		$class = __CLASS__;
		return new $class($host, $name, $user, $pass);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($host, $name, $user, $pass = NULL) {
		//argument test
		Eden_Mysql_Error::get()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string', 'null');	//Argument 4 must be a number or null
		
		$this->_host = $host;
		$this->_name = $name;
		$this->_user = $user;
		$this->_pass = $pass; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Connects to the database
	 * 
	 * @param array the connection options
	 * @return this
	 */
	public function connect(array $options = array()) {
		$connection = 'mysql:host='.$this->_host.';dbname='.$this->_name;
		
		$this->_connection = new PDO($connection, $this->_user, $this->_pass, $options);
		
		$this->trigger();
		
		return $this;
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
	 * Returns the history of queries made still in memory
	 * 
	 * @return array the queries
	 */
	public function getQueries() {
		return $this->_queries;
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
	 * Returns the alter query builder
	 *
	 * @return Eden_Sql_Alter
	 */ 
	public function alter($name = NULL) {
		//Argument 1 must be a string or null
		Eden_Mysql_Error::get()->argument(1, 'string', 'null');
		
		return Eden_Mysql_Alter::get($name);
	}
	
	/**
	 * Returns the create query builder
	 *
	 * @return Eden_Sql_Create
	 */ 
	public function create($name = NULL) {
		//Argument 1 must be a string or null
		Eden_Mysql_Error::get()->argument(1, 'string', 'null');
		
		return Eden_Mysql_Create::get($name);
	}
	
	/**
	 * Returns the Subselect query builder
	 *
	 * @return Eden_Sql_Subselect
	 */ 
	public function subselect($parentQuery, $select = '*') {
		//Argument 2 must be a string
		Eden_Mysql_Error::get()->argument(2, 'string');
		
		return Eden_Mysql_Subselect::get($parentQuery, $select);
	}
	
	/**
	 * Returns the alter query builder
	 *
	 * @return Eden_Sql_Utility
	 */ 
	public function utility() {
		return Eden_Mysql_Utility::get();
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
		Eden_Mysql_Error::get()
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
		Eden_Mysql_Error::get()
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
				$filter = $this->bind($filter);
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
		
		if($index == 'first' && count($results) > 0) {
			return $results[0];
		}
		
		else if($index == 'last' && count($results) > 0) {
			return array_pop($results);
		}
		
		else if(is_numeric($index)) {
			if(isset($results[$index])) {
				return $results[$index];
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
		Eden_Mysql_Error::get()
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
	 * Inserts data into a table and returns the ID
	 *
	 * @param string table
	 * @param array setting
	 * @return int
	 */
	public function insertRow($table, array $setting, $bind = true) {
		//Argument 1 must be a string
		Eden_Mysql_Error::get()->argument(1, 'string')->argument(3, 'array', 'bool');
		
		$query = $this->insert($table);
		
		foreach($setting as $key => $value) {
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
		Eden_Mysql_Error::get()->argument(1, 'string')->argument(3, 'array', 'bool');
		
		$query = $this->insert($table);
		
		foreach($settings as $index => $setting) {
			foreach($setting as $key => $value) {
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
	 * Updates rows that match a filter given the update settings
	 *
	 * @param string table
	 * @param array setting
	 * @param array filter
	 * @return var
	 */
	public function updateRows($table, array $setting, $filters = NULL, $bind = true) {
		//Argument 1 must be a string
		Eden_Mysql_Error::get()->argument(1, 'string')->argument(4, 'array', 'bool');
		
		$query = $this->update($table);
		
		foreach($setting as $key => $value) {
			if((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
				$value = $this->bind($value);
			}
			
			$query->set($key, $value);
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
		
		//run the query
		$this->query($query, $this->getBinds());	
		
		$this->trigger($table, $setting, $filters);
		
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
		Eden_Mysql_Error::get()
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
			return $this->updateRows($table, $setting, array(array($name, 'eq', $value)));
		}
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
		Eden_Mysql_Error::get()->argument(1, 'string');
		
		$query = $this->delete($table);
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				$filter = $this->bind($filter);
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
	 * Peturns the primary key name given the table
	 *
	 * @param string table
	 * @return string
	 */
	public function getPrimaryKey($table) {
		//Argument 1 must be a string
		Eden_Mysql_Error::get()->argument(1, 'string');
		
		$query = $this->utility();
		$results = $this->getColumns($table, "`Key` = 'PRI'");
		return isset($results[0]['Field']) ? $results[0]['Field'] : NULL;
	}
	
	/**
	 * Returns the columns and attributes given the table name
	 *
	 * @param the name of the table
	 * @return attay|false
	 */
	public function getColumns($table, $filters = NULL) {
		//Argument 1 must be a string
		Eden_Mysql_Error::get()->argument(1, 'string');
		
		$query = $this->utility();
		
		if(is_array($filters)) {
			foreach($filters as $i => $filter) {
				//array('post_id=%s AND post_title IN %s', 123, array('asd'));
				$format = array_shift($filter);
				$filter = $this->bind($filter);
				$filters[$i] = vsprintf($format, $filter);
			}
		}
		
		$query->showColumns($table, $filters);
		return $this->query($query, $this->getBinds());
	}
	
	/**
	 * Returns the whole enitre schema and rows
	 * of the current table
	 *
	 * @return string
	 */
	public function getTableSchema($table) {
		//Argument 1 must be a string
		Eden_Mysql_Error::get()->argument(1, 'string');
		
		$backup = array();
		//get the schema
		$schema = $this->getColumns($table);
		if(count($schema)) {
			//lets rebuild this schema
			$query = $this->create()->setName($table);
			foreach($schema as $field) {
				//first try to parse what we can from each field
				$fieldTypeArray = explode(' ', $field['Type']);
				$typeArray = explode('(', $fieldTypeArray[0]);
				
				$type = $typeArray[0];
				$length = str_replace(')', '', $typeArray[1]);
				$attribute = isset($fieldTypeArray[1]) ? $fieldTypeArray[1] : NULL;
				
				$null = strtolower($field['Null']) == 'no' ? false : true;
				
				$increment = strtolower($field['Extra']) == 'auto_increment' ? true : false;
				
				//lets now add a field to our schema class
				$q->addField($field['Field'], array(
					'type' 				=> $type, 
					'length' 			=> $length,
					'attribute' 		=> $attribute, 
					'null' 				=> $null,
					'default'			=> $field['Default'],
					'auto_increment' 	=> $increment));
				
				//set keys where found
				switch($field['Key'])
				{
					case 'PRI':
						$query->addPrimaryKey($field['Field']);
						break;
					case 'UNI':
						$query->addUniqueKey($field['Field'], array($field['Field']));
						break;
					case 'MUL':
						$query->addKey($field['Field'], array($field['Field']));
						break;
				}
			}
			
			//store the query but dont run it
			$backup[] = $query;
		}
		
		//get the rows
		$rows = $this->query($this->select->from($table)->getQuery());	
		if(count($rows)) {
			//lets build an insert query
			$query = $this->insert($table);
			foreach($rows as $index => $row) {
				foreach($row as $key => $value) {
					$query->set($key, $this->getBinds($value), $index);
				}
			}
			
			//store the query but dont run it
			$backup[] = $query->getQuery(true);
		}
		
		return implode("\n\n", $backup);
	}
	
	/**
	 * Returns a listing of tables in the DB
	 *
	 * @param the like pattern
	 * @return attay|false
	 */
	public function getTables($like = NULL) {
		//Argument 1 must be a string or null
		Eden_Mysql_Error::get()->argument(1, 'string', 'null');
		
		$query = $this->utility();
		$like = $like ? $this->bind($like) : NULL;
		$results = $this->query($query->showTables($like), $q->getBinds());
		$newResults = array();
		foreach($results as $result) {
			foreach($result as $key => $value) {
				$newResults[] = $value;
				break;
			}
		}
		
		return $newResults;
	}
	
	/**
	 * Returns the whole enitre schema and rows
	 * of the current databse
	 *
	 * @return string
	 */
	public function getSchema() {
		$backup = array();
		$tables = $this->getTables();
		foreach($tables as $table) {
			$backup[] = $this->getBackup();
		}
		
		return implode("\n\n", $backup);
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
		Eden_Mysql_Error::get()->argument(1, 'string', 'Eden_Sql_Query');
		
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
			
			Eden_Mysql_Error::get()
				->setMessage(Eden_Mysql_Error::QUERY_ERROR)
				->addVariable($query)
				->addVariable($error[2])
				->trigger();
		}
		
		$results = $stmt->fetchAll( PDO::FETCH_ASSOC );
		
		$this->queries[] = array(
			'query' => $query,
			'binds' => $binds,
			'results' => $results);
		
		$this->_binds = array();
		
		$this->trigger($query, $binds, $results);
		
		return $results;
	}
	
	/**
	 * Binds a value and returns the bound key
	 *
	 * @param string
	 * @return string
	 */
	public function bind($value) {
		//Argument 1 must be an array, string or number
		Eden_Mysql_Error::get()->argument(1, 'array', 'string', 'numeric', 'null');
		
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
	 * Returns all the bound values of this query
	 *
	 * @param void
	 * @return array
	 * @notes returns all the binds stored in registry
	 */
	public function getBinds() {
		return $this->_binds;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

