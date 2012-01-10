<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Mysql Collection handler
 *
 * @package    Eden
 * @category   mysql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Mysql_Collection extends Eden_Collection {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_model 		= 'Eden_Mysql_Model';
	protected $_database	= NULL;
	protected $_table		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
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
		$this->_database = $database;
		
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, 'setDatabase')) {
				continue;
			}
			
			//let the row handle this
			$row->setDatabase($database);
		}
		
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
		
		$this->_table = $table;
		
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, 'setTable')) {
				continue;
			}
			
			//let the row handle this
			$row->setTable($table);
		}
		
		return $this;
	}
	
	/**
	 * Useful method for formating a time column.
	 * 
	 * @param string
	 * @param string
	 * @return this
	 */
	public function formatTime($column, $format = Eden_Mysql_Model::DATETIME) {
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, 'formatTime')) {
				continue;
			}
			
			//let the row handle this
			$row->formatTime($column, $format);
		}
		
		return $this;
	}
	
	/**
	 * Adds a row to the collection
	 *
	 * @param array|Eden_Model
	 * @return this
	 */
	public function add($row = array()) {
		//Argument 1 must be an array or Eden_Model
		Eden_Mysql_Error::i()->argument(1, 'array', $this->_model);
		
		//if it's an array
		if(is_array($row)) {
			//make it a model
			$model = $this->_model;
			$row = $this->$model($row);
		}
		
		if(!is_null($this->_database)) {
			$row->setDatabase($this->_database);
		}
		
		if(!is_null($this->_table)) {
			$row->setTable($this->_table);
		}
		
		//add it now
		$this->_list[] = $row;
		
		return $this;
	}
	
	/**
	 * Insert collection to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function insert($table = NULL, Eden_Mysql $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, 'insert')) {
				continue;
			}
			
			$row->insert($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Updates collection to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function update($table = NULL, Eden_Mysql $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, 'update')) {
				continue;
			}
			
			$row->update($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Inserts or updates collection to database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function save($table = NULL, Eden_Mysql $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, 'save')) {
				continue;
			}
			
			$row->save($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Removes collection from database
	 *
	 * @param string
	 * @param Eden_Mysql
	 * @return this
	 */
	public function remove($table = NULL, Eden_Mysql $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, 'remove')) {
				continue;
			}
			
			//let the row handle this
			$row->remove($table, $database);
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}