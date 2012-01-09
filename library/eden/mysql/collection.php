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
	protected $_model 	= 'Eden_Mysql_Model';
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i(array $data = array()) {
		return self::_getMultiple(__CLASS__,$data);
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
		//for each row
		foreach($this->_list as $row) {
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
		
		//for each row
		foreach($this->_list as $row) {
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
			//let the row handle this
			$row->formatTime($column, $format);
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