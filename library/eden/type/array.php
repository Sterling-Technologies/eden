<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Array object 
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Type_Array extends Eden_Type_Abstract implements ArrayAccess, Iterator, Serializable, Countable {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_data 		= array();
	protected $_original 	= array();
	
	protected static $_methods = array(
		'array_change_key_case' 	=> self::PRE,	'array_chunk' 					=> self::PRE,
		'array_combine' 			=> self::PRE,	'array_count_datas' 			=> self::PRE,
		'array_diff_assoc'			=> self::PRE,	'array_diff_key'				=> self::PRE,
		'array_diff_uassoc'			=> self::PRE,	'array_diff_ukey'				=> self::PRE,
		'array_diff'				=> self::PRE,	'array_fill_keys'				=> self::PRE,
		'array_filter'				=> self::PRE,	'array_flip'					=> self::PRE,
		'array_intersect_assoc'		=> self::PRE,	'array_intersect_key'			=> self::PRE,
		'array_intersect_uassoc'	=> self::PRE,	'array_intersect_ukey'			=> self::PRE,
		'array_intersect'			=> self::PRE,	'array_keys'					=> self::PRE,
		'array_merge_recursive'		=> self::PRE,	'array_merge'					=> self::PRE,
		'array_pad'					=> self::PRE,	
		'array_reverse'				=> self::PRE,	'array_shift'					=> self::PRE,
		'array_slice'				=> self::PRE,	'array_splice'					=> self::PRE,
		'array_sum'					=> self::PRE,	'array_udiff_assoc'				=> self::PRE,
		'array_udiff_uassoc'		=> self::PRE,	'array_udiff'					=> self::PRE,
		'array_uintersect_assoc'	=> self::PRE,	'array_uintersect_uassoc'		=> self::PRE,
		'array_uintersect'			=> self::PRE,	'array_unique'					=> self::PRE,
		'array_datas'				=> self::PRE,	'count'							=> self::PRE,
		'current'					=> self::PRE,	'each'							=> self::PRE,
		'end'						=> self::PRE,	'extract'						=> self::PRE,
		'key'						=> self::PRE,	'next'							=> self::PRE,	
		'prev'						=> self::PRE,	'sizeof'						=> self::PRE,
		
		'array_fill'	=> self::POST,	'array_map'	=> self::POST,
		'array_search'	=> self::POST,	'compact'	=> self::POST,
		'implode'		=> self::POST,	'in_array'	=> self::POST,
		
		'array_unshift' 	=> self::REFERENCE,	'array_walk_recursive'	=> self::REFERENCE, 
		'array_walk' 		=> self::REFERENCE,	'arsort'				=> self::REFERENCE,
		'asort'				=> self::REFERENCE,	'krsort'				=> self::REFERENCE,
		'ksort' 			=> self::REFERENCE,	'natcasesort'			=> self::REFERENCE,
		'natsort'			=> self::REFERENCE,	'reset'					=> self::REFERENCE,
		'rsort' 			=> self::REFERENCE,	'shuffle'				=> self::REFERENCE,
		'sort'				=> self::REFERENCE,	'uasort'				=> self::REFERENCE,
		'uksort'			=> self::REFERENCE,	'usort'					=> self::REFERENCE,
		'array_push'		=> self::REFERENCE);
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __call($name, $args) {
		//if the method starts with get
		if(strpos($name, 'get') === 0) {
			//getUserName('-')
			$separator = '_';
			if(isset($args[0]) && is_scalar($args[0])) {
				$separator = (string) $args[0];
			}
			
			$key = preg_replace("/([A-Z0-9])/", $separator."$1", $name);
			//get rid of get
			$key = strtolower(substr($key, 3+strlen($separator)));
			
			if(isset($this->_data[$key])) {
				return $this->_data[$key];
			}
			
			return NULL;
			
		} else if (strpos($name, 'set') === 0) {
			//setUserName('Chris', '-')
			$separator = '_';
			if(isset($args[1]) && is_scalar($args[1])) {
				$separator = (string) $args[1];
			}
			
			$key = preg_replace("/([A-Z0-9])/", $separator."$1", $name);

			//get rid of set
			$key = strtolower(substr($key, 3+strlen($separator)));
			
			$this->__set($key, isset($args[0]) ? $args[0] : NULL);
			
			return $this;
		}
		
		try {
			return parent::__call($name, $args);
		} catch(Eden_Error $e) {
			Eden_Type_Error::i($e->getMessage())->trigger();
		}
	}
	
	public function __construct($data = array()) {
		//if there is more arguments or data is not an array
		if(func_num_args() > 1 || !is_array($data)) {
			//just get the args
			$data = func_get_args();
		}
		
		parent::__construct($data);
	}
	
	public function __set($name, $value) {
		$this->_data[$name] = $value;
	}
	
	public function __toString() {
		return json_encode($this->get());
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Copies the value of source key into destination key
	 *
	 * @param string
	 * @param string
	 */
	public function copy($source, $destination) {
		$this->_data[$destination] = $this->_data[$source];
		return $this;
	}
	
	/**
	 * returns size using the Countable interface
	 *
	 * @return string
	 */
	public function count() {
		return count($this->_data);
	}
	
	/**
	 * Removes a row in an array and adjusts all the indexes
	 *
	 * @param *string the key to leave out
	 * @return this
	 */
	public function cut($key) {
		//argument 1 must be scalar
		Eden_Type_Error::i()->argument(1, 'scalar');
		
		//if nothing to cut
		if(!isset($this->_data[$key])) {
			//do nothing
			return $this;
		}
		
		//unset the value
		unset($this->_data[$key]);
		//reindex the list
		$this->_data = array_values($this->_data);
		return $this;
	}
	
	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
        return current($this->_data);
    }
	
	/** 
	 * Loops through returned result sets
	 *
	 * @param *callable
	 * @return this
	 */
	public function each($callback) {
		Eden_Error::i()->argument(1, 'callable');
		
		foreach($this->_data as $key => $value) {
			call_user_func($callback, $key, $value);
		}
		
		return $this;
	}
	
	/**
	 * Returns if the data is empty
	 *
	 * @return bool
	 */
	public function isEmpty() {
		return empty($this->_data);
	}
	
	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
        return key($this->_data);
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
        next($this->_data);
    }

	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($this->_data[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($this->_data[$offset]) ? $this->_data[$offset] : NULL;
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
        unset($this->_data[$offset]);
    }
    
	/**
	 * Inserts a row in an array after the given index and adjusts all the indexes
	 *
	 * @param *scalar the key we are looking for to past after
	 * @param *mixed the value to paste
	 * @param scalar the key to paste along with the value
	 * @return this
	 */
	public function paste($after, $value, $key = NULL) {
		//Argument test
		Eden_Type_Error::i()
			->argument(1, 'scalar')				//Argument 1 must be a scalar
			->argument(3, 'scalar', 'null');	//Argument 3 must be a scalar or null
		
		$list = array();
		//for each row
		foreach($this->_data as $i => $val) {
			//add this row back to the list
			$list[$i] = $val;
			
			//if this is not the key we are
			//suppose to paste after 
			if($after != $i) {
				//do nothing more
				continue;
			}
			
			//if there was a key involved
			if(!is_null($key)) {
				//lets add the new value
				$list[$key] = $value;
				continue;
			}
			
			//lets add the new value
			$list[] = $arrayValue;
		}
		
		//if there was no key involved
		if(is_null($key)) {
			//reindex the array
			$list = array_values($list);
		}
		
		//give it back
		$this->_data = $list; 
		
		return $this;
	}
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
        reset($this->_data);
    }
	
	/**
	 * returns serialized data using the Serializable interface
	 *
	 * @return string
	 */
	public function serialize() {
        return json_encode($this->_data);
    }
	
	/**
	 * Sets data
	 *
	 * @return this
	 */
	public function set($value) {
		Eden_Type_Error::i()->argument(1, 'array');
		$this->_data = $value;
		return $this;
	}
	
	/**
	 * sets data using the Serializable interface
	 *
	 * @param string
	 * @return void
	 */
    public function unserialize($data) {
        $this->_data = json_decode($data, true);
		return $this;
    }
	
	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
        return isset($this->_data[$this->key()]);
    }
	
	/* Protected Methods
	-------------------------------*/
	protected function _getMethodType(&$name) {
		
		if(isset(self::$_methods[$name])) {
			return self::$_methods[$name];
		}
		
		if(isset(self::$_methods['array_'.$name])) {
			$name = 'array_'.$name;
			return self::$_methods[$name];
		}
		
		$uncamel = strtolower(preg_replace("/([A-Z])/", "_$1", $name));
		
		if(isset(self::$_methods[$uncamel])) {
			$name = $uncamel;
			return self::$_methods[$name];
		}
		
		if(isset(self::$_methods['array_'.$uncamel])) {
			$name = 'array_'.$uncamel;
			return self::$_methods[$name];
		}
		
		return false;
	}
	
	/* Private Methods
	-------------------------------*/
}