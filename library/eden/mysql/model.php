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
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Mysql_Model extends Eden_Mysql_Model_Abstract {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = NULL;
	protected $_meta 	= array();
	protected $_data	= array();
	
	protected $_database 	= NULL;
	protected $_table 		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get(Eden_Mysql $database, $table) {
		return self::_getMultiple(__CLASS__, $database, $table);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($database, $table) {
		$this->_database 	= $database;
		$this->_table 		= $table;
		
		//set meta data
		$this->_setMetaData();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Loads data into the model
	 *
	 * @param array
	 * @return this
	 */
	public function load($data, $column = NULL) {
		Eden_Mysql_Error::get()
			->argument(1, 'numeric', 'array', 'string')
			->argument(2, 'string', 'null');
		
		if(is_scalar($data)) {
			if(!is_string($column)) {
				$column = $this->_primary;
			}
			
			$this->_data = $this->_database->getRow($this->_table, $column, $data);
			
			return $this;
		}
		
		//for each data
		foreach($data as $name => $value) {
			//if this is not set in the meta data
			if(!isset($this->_meta[$name])) {
				//throw an error
				Eden_Mysql_Error::get()
					->setMessage(Eden_Mysql_Error::SET_INVALID)
					->addVariable($name)
					->addVariable($this->_table)
					->trigger();
			}
			
			$this->_data[$name] = $value;
		}
		
		return $this;
	}
	
	public function save() {
		if(isset($this->_data[$this->_primary])) {
			$this->_database->updateRows($this->_table, 
			$this->_data, $this->_primary.'='.$this->_data[$this->_primary]);
		} else {
			$this->_database->insertRow($this->_table, $this->_data);
			$this->_data[$this->_primary] = $this->_database->getLastInsertedId();
		}
		
		return $this;
	}
	
	public function remove() {
		$this->_database->deleteRows($this->_table, $this->_primary.'='.$this->_data[$this->_primary]);
		$this->_data = array();
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setMetaData() {
		$columns = $this->_database->getColumns($this->_table);
		
		foreach($columns as $column) {
			$this->_meta[$column['Field']] = array(
				'type' 		=> $column['Type'],
				'key' 		=> $column['Key'],
				'default' 	=> $column['Default'],
				'empty' 	=> $column['Null'] == 'YES');
			
			if($column['Key'] == 'PRI') {
				$this->_primary = $column['Field'];
			}
		}
	}
	
	/* Private Methods
	-------------------------------*/
}

