<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/sql/database.php';
require_once dirname(__FILE__).'/postgre/error.php';
require_once dirname(__FILE__).'/postgre/delete.php';
require_once dirname(__FILE__).'/postgre/select.php';
require_once dirname(__FILE__).'/postgre/update.php';
require_once dirname(__FILE__).'/postgre/insert.php';
require_once dirname(__FILE__).'/postgre/alter.php';
require_once dirname(__FILE__).'/postgre/create.php';
require_once dirname(__FILE__).'/postgre/utility.php';

/**
 * Abstractly defines a layout of available methods to
 * connect to and query a PostGres database. This class also 
 * lays out query building methods that auto renders a 
 * valid query the specific database will understand without 
 * actually needing to know the query language. Extending
 * all SQL classes, comes coupled with loosely defined
 * searching, collections and models.
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Postgre extends Eden_Sql_Database {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_host = 'localhost';
	protected $_port = NULL;
	protected $_name = NULL;
	protected $_user = NULL;
	protected $_pass = NULL;
	
	protected $_model 		= self::MODEL;
	protected $_collection 	= self::COLLECTION;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($host, $name, $user, $pass = NULL, $port = NULL) {
		//argument test
		Eden_Postgre_Error::i()
			->argument(1, 'string', 'null')		//Argument 1 must be a string or null
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string', 'null')		//Argument 4 must be a number or null
			->argument(5, 'numeric', 'null'); 	//Argument 4 must be a number or null
		
		$this->_host = $host;
		$this->_name = $name;
		$this->_user = $user;
		$this->_pass = $pass; 
		$this->_port = $port;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Returns the alter query builder
	 *
	 * @return Eden_Sql_Alter
	 */ 
	public function alter($name = NULL) {
		//Argument 1 must be a string or null
		Eden_Postgre_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Postgre_Alter::i($name);
	}
	
	/**
	 * Connects to the database
	 * 
	 * @param array the connection options
	 * @return this
	 */
	public function connect(array $options = array()) {
		$host = $port = NULL;
		
		if(!is_null($this->_host)) { 
			$host = 'host='.$this->_host.';';
			if(!is_null($this->_port)) { 
				$port = 'port='.$this->_port.';';
			}
		}
		
		$connection = 'pgsql:'.$host.$port.'dbname='.$this->_name;
		
		$this->_connection = new PDO($connection, $this->_user, $this->_pass, $options);
		
		$this->trigger();
		
		return $this;
	}
		
	/**
	 * Returns the create query builder
	 *
	 * @return Eden_Sql_Create
	 */ 
	public function create($name = NULL) {
		//Argument 1 must be a string or null
		Eden_Postgre_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Postgre_Create::i($name);
	}
	
	/**
	 * Returns the delete query builder
	 *
	 * @return Eden_Sql_Delete
	 */ 
	public function delete($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Postgre_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Postgre_Delete::i($table);
	}
	
	/**
	 * Query for showing all columns of a table
	 *
	 * @param string the name of the table
	 * @return this
	 */
	public function getColumns($table, $schema = NULL) {
		//Argument 1 must be a string
		Eden_Postgre_Error::i()->argument(1, 'string')->argument(2, 'string', 'null');
		
		$select = array(
			'columns.table_schema', 
			'columns.column_name', 
			'columns.ordinal_position', 
			'columns.column_default', 
			'columns.is_nullable', 
			'columns.data_type', 
			'columns.character_maximum_length', 
			'columns.character_octet_length',
			'pg_class2.relname AS index_type');
		
		$where = array(
			"pg_attribute.attrelid = pg_class1.oid AND pg_class1.relname='".$table."'",
			'columns.column_name = pg_attribute.attname AND columns.table_name=pg_class1.relname',
			'pg_class1.oid = pg_index.indrelid AND pg_attribute.attnum = ANY(pg_index.indkey)',
			'pg_class2.oid = pg_index.indexrelid');
		
		if($schema) {
			$where[1] .= ' AND columns.table_schema="'.$schema.'"';
		}
		
		$query = Eden_Postgre_Select::i()
			->select($select)
			->from('pg_attribute')
			->innerJoin('pg_class AS pg_class1', $where[0], false)
			->innerJoin('information_schema.COLUMNS	AS columns', $where[1], false)
			->leftJoin('pg_index', $where[2], false)
			->leftJoin('pg_class AS pg_class2', $where[3], false)
			->getQuery();
		
		$results = $this->query($query);
		
		$columns = array();
		foreach($results as $column) {
			$key = NULL;
			if(strpos($column['index_type'], '_pkey') !== false) {
				$key = 'PRI';
			} else if(strpos($column['index_type'], '_key') !== false) {
				$key = 'UNI';
			}
			
			$columns[] = array(
				'Field' 	=> $column['column_name'],
				'Type' 		=> $column['data_type'],
				'Default' 	=> $column['column_default'], 
				'Null'		=> $column['is_nullable'],
				'Key'		=> $key);
		}
		
		return $columns;
	}
	
	/**
	 * Query for showing all columns of a table
	 *
	 * @param string the name of the table
	 * @return this
	 */
	public function getIndexes($table, $schema = NULL) {
		//Argument 1 must be a string
		Eden_Postgre_Error::i()->argument(1, 'string')->argument(2, 'string', 'null');
		
		$select = array('columns.column_name', 
			'pg_class2.relname AS index_type');
		
		$where = array(
			"pg_attribute.attrelid = pg_class1.oid AND pg_class1.relname='".$table."'",
			'columns.column_name = pg_attribute.attname AND columns.table_name=pg_class1.relname',
			'pg_class1.oid = pg_index.indrelid AND pg_attribute.attnum = ANY(pg_index.indkey)',
			'pg_class2.oid = pg_index.indexrelid');
		
		if($schema) {
			$where[1] .= ' AND columns.table_schema="'.$schema.'"';
		}
		
		$query = Eden_Postgre_Select::i()
			->select($select)
			->from('pg_attribute')
			->innerJoin('pg_class AS pg_class1', $where[0], false)
			->innerJoin('information_schema.COLUMNS	AS columns', $where[1], false)
			->innerJoin('pg_index', $where[2], false)
			->innerJoin('pg_class AS pg_class2', $where[3], false)
			->getQuery();
			
		return $this->query($query);
	}
	
	/**
	 * Query for showing all columns of a table
	 *
	 * @param string the name of the table
	 * @return this
	 */
	public function getPrimary($table, $schema = NULL) {
		//Argument 1 must be a string
		Eden_Postgre_Error::i()->argument(1, 'string')->argument(2, 'string', 'null');
		
		$select = array('columns.column_name');
		
		$where = array(
			"pg_attribute.attrelid = pg_class1.oid AND pg_class1.relname='".$table."'",
			'columns.column_name = pg_attribute.attname AND columns.table_name=pg_class1.relname',
			'pg_class1.oid = pg_index.indrelid AND pg_attribute.attnum = ANY(pg_index.indkey)',
			'pg_class2.oid = pg_index.indexrelid');
		
		if($schema) {
			$where[1] .= ' AND columns.table_schema="'.$schema.'"';
		}
		
		$query = Eden_Postgre_Select::i()
			->select($select)
			->from('pg_attribute')
			->innerJoin('pg_class AS pg_class1', $where[0], false)
			->innerJoin('information_schema.COLUMNS	AS columns', $where[1], false)
			->innerJoin('pg_index', $where[2], false)
			->innerJoin('pg_class AS pg_class2', $where[3], false)
			->where('pg_class2.relname LIKE \'%_pkey\'')
			->getQuery();
		
		return $this->query($query);
	}
	
	/**
	 * Returns a listing of tables in the DB
	 *
	 * @return attay|false
	 */
	public function getTables() {
		$query = Eden_Postgre_Select::i()
			->select('tablename')
			->from('pg_tables')
			->where("tablename NOT LIKE 'pg\\_%'")
			->where("tablename NOT LIKE 'sql\\_%'")
			->getQuery();
		
		return $this->query($query);
	}
	
	/**
	 * Returns the insert query builder
	 *
	 * @return Eden_Sql_Insert
	 */ 
	public function insert($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Postgre_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Postgre_Insert::i($table);
	}
	
	/**
	 * Returns the select query builder
	 *
	 * @return Eden_Sql_Select
	 */ 
	public function select($select = '*') {
		//Argument 1 must be a string or array
		Eden_Postgre_Error::i()->argument(1, 'string', 'array');
		
		return Eden_Postgre_Select::i($select);
	}
	
	/**
	 * Set schema search paths
	 *
	 * @string
	 */
	public function setSchema($schema) {
		$schema = array($schema);
		if(func_num_args() > 0) {
			$schema = func_get_args();
		}
		
		$error = Eden_Postgre_Error::i();
		foreach($schema as $i => $name) {
			$error->argument($i + 1, 'string');
		}
		
		$schema = implode(',', $schema);
		
		$query = $this->utility()->setSchema($schema);
		$this->query($query);
		
		return $this;
	}
	
	/**
	 * Returns the update query builder
	 *
	 * @return Eden_Sql_Update
	 */ 
	public function update($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Postgre_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Postgre_Update::i($table);
	}

	/**
	 * Returns the alter query builder
	 *
	 * @return Eden_Sql_Utility
	 */ 
	public function utility() {
		return Eden_Postgre_Utility::i();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

