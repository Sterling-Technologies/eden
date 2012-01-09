<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Mysql Model
 *
 * @package    Eden
 * @category   mysql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Mysql_Model extends Eden_Model {
	/* Constants
	-------------------------------*/
	const COLUMNS 	= 'columns';
	const PRIMARY 	= 'primary';
	const DATETIME 	= 'Y-m-d h:i:s';
	const DATE	 	= 'Y-m-d';
	const TIME	 	= 'h:i:s';
	const TIMESTAMP	= 'U';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_table 		= NULL;
	protected $_database 	= NULL;
	
	protected static $_meta = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		$data = self::_getStart(func_get_args());
		return self::_getMultiple(__CLASS__, $data);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets the default database
	 *
	 * @param Eden_Mysql
	 */
	public function setDatabase(Eden_Mysql $database) {
		$this->_database  = $database;
		return $this;
	}
	
	/**
	 * Sets the default database
	 *
	 * @param string
	 */
	public function setTable($table) {
		//Argument 1 must be a string
		Eden_Mysql_Error::i()->argument(1, 'string');
		
		$this->_table  = $table;
		return $this;
	}
	
	/**
	 * Useful method for formating a time column.
	 * 
	 * @param string
	 * @param string
	 * @return this
	 */
	public function formatTime($column, $format = self::DATETIME) {
		//Argument Test
		Eden_Mysql_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 1 must be a string
		
		//if the column isn't set
		if(!isset($this->_data[$column])) {
			//do nothing more
			return $this;
		}
		
		//if this is column is a string
		if(is_string($this->_data[$column])) {
			//make into time
			$this->_data[$column] = strtotime($this->_data[$column]);
		}
		
		//if this column is not an integer
		if(!is_int($this->_data[$column])) {
			//do nothing more
			return $this;
		}
		
		//set it
		$this->_data[$column] = date($format, $this->_data[$column]);
		
		return $this;
	}
	
	/**
	 * Inserts model to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function insert($table = NULL, Eden_Mysql $database = NULL) {
		//Argument 1 must be a string
		$error = Eden_Mysql_Error::i()->argument(1, 'string', 'null');
		
		//if no table
		if(is_null($table)) {
			//if no default table either
			if(!$this->_table) {
				//throw error
				$error->setMessage(Eden_Mysql_Error::TABLE_NOT_SET)->trigger();
			}
			
			$table = $this->_table;
		}
		
		//if no database
		if(is_null($database)) {
			//and no default database
			if(!$this->_database) {
				$error->setMessage(Eden_Mysql_Error::DATABASE_NOT_SET)->trigger();
			}
			
			$database = $this->_database;
		}
		
		//get the meta data, the valid column values and whether is primary is set
		$meta 			= $this->_getMeta($table, $database);
		$data 			= $this->_getValidColumns(array_keys($meta[self::COLUMNS]));	
		
		//update original data
		$this->_original = $this->_data;
		
		//we insert it
		$database->insertRow($table, $data);
		
		//only if we have 1 primary key
		if(count($meta[self::PRIMARY]) == 1) {
			//set the primary key
			$this->_data[$meta[self::PRIMARY][0]] = $database->getLastInsertedId();	
		}
		
		return $this;
	}
	
	/**
	 * Updates model to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function update($table = NULL, Eden_Mysql $database = NULL) {
		//Argument 1 must be a string
		$error = Eden_Mysql_Error::i()->argument(1, 'string', 'null');
		
		//if no table
		if(is_null($table)) {
			//if no default table either
			if(!$this->_table) {
				//throw error
				$error->setMessage(Eden_Mysql_Error::TABLE_NOT_SET)->trigger();
			}
			
			$table = $this->_table;
		}
		
		//if no database
		if(is_null($database)) {
			//and no default database
			if(!$this->_database) {
				$error->setMessage(Eden_Mysql_Error::DATABASE_NOT_SET)->trigger();
			}
			
			$database = $this->_database;
		}
		
		//get the meta data, the valid column values and whether is primary is set
		$meta 			= $this->_getMeta($table, $database);
		$data 			= $this->_getValidColumns(array_keys($meta[self::COLUMNS]));	
		
		//update original data
		$this->_original = $this->_data;
		
		//from here it means that this table has primary 
		//columns and all primary values are set
		
		$filter = array();
		//for each primary key
		foreach($meta[self::PRIMARY] as $column) {
			//add the condition to the filter
			$filter[] = array($column.'=%s', $data[$column]);
		}
		
		//we update it
		$database->updateRows($table, $data, $filter);
		
		return $this;
	}
	
	/**
	 * Inserts or updates model to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function save($table = NULL, Eden_Mysql $database = NULL) {
		//Argument 1 must be a string
		$error = Eden_Mysql_Error::i()->argument(1, 'string', 'null');
		
		//if no table
		if(is_null($table)) {
			//if no default table either
			if(!$this->_table) {
				//throw error
				$error->setMessage(Eden_Mysql_Error::TABLE_NOT_SET)->trigger();
			}
			
			$table = $this->_table;
		}
		
		//if no database
		if(is_null($database)) {
			//and no default database
			if(!$this->_database) {
				$error->setMessage(Eden_Mysql_Error::DATABASE_NOT_SET)->trigger();
			}
			
			$database = $this->_database;
		}
		
		//get the meta data, the valid column values and whether is primary is set
		$meta 			= $this->_getMeta($table, $database);
		$primarySet 	= $this->_isPrimarySet($meta[self::PRIMARY]);	
		
		//update original data
		$this->_original = $this->_data;
		
		//if no primary meta or primary values are not set
		if(empty($meta[self::PRIMARY]) || !$primarySet) {
			return $this->insert($table, $database);
		}
		
		return $this->update($table, $database);
	}
	
	/**
	 * Removes model from database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function remove($table = NULL, Eden_Mysql $database = NULL) {
		//Argument 1 must be a string
		$error = Eden_Mysql_Error::i()->argument(1, 'string', 'null');
		
		//if no table
		if(is_null($table)) {
			//if no default table either
			if(!$this->_table) {
				//throw error
				$error->setMessage(Eden_Mysql_Error::TABLE_NOT_SET)->trigger();
			}
			
			$table = $this->_table;
		}
		
		//if no database
		if(is_null($database)) {
			//and no default database
			if(!$this->_database) {
				$error->setMessage(Eden_Mysql_Error::DATABASE_NOT_SET)->trigger();
			}
			
			$database = $this->_database;
		}
		
		//get the meta data and valid columns
		$meta = $this->_getMeta($table, $database);
		$data = $this->_getValidColumns(array_keys($meta[self::COLUMNS]));
		
		$filter = array();
		//for each primary key
		foreach($meta[self::PRIMARY] as $column) {
			//if the primary is not set
			if(!isset($data[$column])) {
				//we can't do a remove
				//do nothing more
				return $this;
			}
			
			//add the condition to the filter
			$filter[] = array($column.'=%s', $data[$column]);
		}
		
		//we delete it
		$database->deleteRows($table, $filter);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _isPrimarySet(array $primary) {
		foreach($primary as $column) {
			if(is_null($this[$column])) {
				return false;
			}
		}
		
		return true;
	}
	
	protected function _getValidColumns($columns) {
		$valid = array();
		foreach($columns as $column) {
			if(!isset($this->_data[$column])) {
				continue;
			}
			
			$valid[$column] = $this->_data[$column];
		} 
		
		return $valid;
	}
	
	protected function _getMeta($table, $database) {
		$uid = spl_object_hash($database);
		if(isset(self::$_meta[$uid][$table])) {
			return self::$_meta[$uid][$table];
		}
		
		$columns = $database->getColumns($table);
		
		$meta = array();
		foreach($columns as $i => $column) {
			$meta[self::COLUMNS][$column['Field']] = array(
				'type' 		=> $column['Type'],
				'key' 		=> $column['Key'],
				'default' 	=> $column['Default'],
				'empty' 	=> $column['Null'] == 'YES');
			
			if($column['Key'] == 'PRI') {
				$meta[self::PRIMARY][] = $column['Field'];
			}
		}
		
		self::$_meta[$uid][$table] = $meta;
		
		return $meta;
	}
	
	protected function _isLoaded($table = NULL, $database = NULL) {
		//if no table
		if(is_null($table)) {
			//if no default table either
			if(!$this->_table) {
				return false;
			}
			
			$table = $this->_table;
		}
		
		//if no database
		if(is_null($database)) {
			//and no default database
			if(!$this->_database) {
				return false;
			}
			
			$database = $this->_database;
		}
		
		$meta = $this->_getMeta($table, $database);
		
		return $this->_isPrimarySet($meta[self::PRIMARY]);
	}
	
	/* Private Methods
	-------------------------------*/
}

