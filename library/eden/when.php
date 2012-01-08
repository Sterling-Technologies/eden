<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 *  Trigger when something is false
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_When extends Eden_Class implements ArrayAccess, Iterator {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_scope 		= NULL;
	protected $_increment 	= 1;
	protected $_lines 		= 0;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($scope, $lines = 0) {
		return self::_getMultiple(__CLASS__, $scope, $lines);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($scope, $lines = 0) {
		$this->_scope = $scope;
		$this->_lines = $lines;
	}
	
	public function __call($name, $args) {
		if($this->_lines > 0 && $this->_increment == $this->_lines) {
			return $this->endWhen();
		}
		
		$this->_increment++;
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the original class
	 *
	 * @param bool
	 * @return this|Eden_Noop
	 */
	public function endWhen() {
		return $this->_scope;
	}
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
        $this->_scope->rewind();
    }

	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
        return $this->_scope->current();
    }

	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
        return $this->_scope->key();
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
        $this->_scope->next();
    }

	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
        return $this->_scope->valid();
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {}
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return $this->_scope->offsetExists($offset);
    }
    
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {}
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return $this->_scope->offsetGet($offset);
    }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}