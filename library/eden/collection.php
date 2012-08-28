<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * A collection is a list of common models used for mass manipulations.
 *
 * @package    Eden
 * @category   model
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Collection extends Eden_Class implements ArrayAccess, Iterator, Serializable, Countable {
	/* Constants
	-------------------------------*/
	const FIRST = 'first';
	const LAST	= 'last';
	const MODEL = 'Eden_Model';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_list 	= array();
	protected $_model 	= self::MODEL;
	
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
			//getUserName('-') - get all rows column values
			$value = isset($args[0]) ? $args[0] : NULL;
			
			//make a new model
			$list = Eden_Model::i();
			//for each row
			foreach($this->_list as $i => $row) {
				//just add the column they want
				//let the model worry about the rest
				$list[] = $row->$name(isset($args[0]) ? $args[0] : NULL);
			}
			
			return $list;
			
		//if the method starts with set
		} else if (strpos($name, 'set') === 0) {
			//setUserName('Chris', '-') - set all user names to Chris
			$value 		= isset($args[0]) ? $args[0] : NULL;
			$separator 	= isset($args[1]) ? $args[1] : NULL;
			
			//for each row
			foreach($this->_list as $i => $row) {
				//just call the method
				//let the model worry about the rest
				$row->$name($value, $separator);
			}
			
			return $this;
		}
		
		$found = false;
		
		//for an array of models the method might exist
		//we should loop and check for a valid method
		
		foreach($this->_list as $i => $row) {
			//if no method exists
			if(!method_exists($row, $name)) {
				continue;
			}
			
			$found = true;
			
			//just call the method
			//let the model worry about the rest
			$row->callThis($name, $args);
		}
		
		//if found, it means something happened
		if($found) {
			//so it was successful
			return $this;
		}
		
		//nothing more, just see what the parent has to say
		try {
			return parent::__call($name, $args);
		} catch(Eden_Error $e) {
			Eden_Collection_Error::i($e->getMessage())->trigger();
		}
	}
	
	public function __construct(array $data = array()) {
		$this->set($data);
	}
		
	public function __set($name, $value) {
		//set all rows with this column and value
		foreach($this->_list as $i => $row) {
			$row[$name] = $value;
		}
		
		return $this;
	}
	
	public function __toString() {
		return json_encode($this->get());
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds a row to the collection
	 *
	 * @param array|Eden_Model
	 * @return this
	 */
	public function add($row = array()) {
		//Argument 1 must be an array or Eden_Model
		Eden_Collection_Error::i()->argument(1, 'array', $this->_model);
		
		//if it's an array
		if(is_array($row)) {
			//make it a model
			$model = $this->_model;
			$row = $this->$model($row);
		}
		
		//add it now
		$this->_list[] = $row;
		
		return $this;
	}
	
	/**
	 * returns size using the Countable interface
	 *
	 * @return string
	 */
	public function count() {
		return count($this->_list);
	}
	
	public function cut($index = self::LAST) {
		//Argument 1 must be a string or integer
		Eden_Collection_Error::i()->argument(1, 'string', 'int');
		
		//if index is first
		if($index == self::FIRST) {
			//we really mean 0
			$index = 0;
		//if index is last
		} else if($index == self::LAST) {
			//we realy mean the last index number
			$index = count($this->_list) -1;
		}
		
		//if this row is found
		if(isset($this->_list[$index])) {
			//unset it
			unset($this->_list[$index]);
		}
		
		//reindex the list
		$this->_list = array_values($this->_list);
		
		return $this;
	}
	
	/** 
	 * Loops through returned result sets
	 *
	 * @param *callable
	 * @return this
	 */
	public function each($callback) {
		Eden_Error::i()->argument(1, 'callable');
		
		foreach($this->_list as $key => $value) {
			call_user_func($callback, $key, $value);
		}
		
		return $this;
	}
	
	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
        return current($this->_list);
    }
	
	/**
	 * Returns the row array
	 *
	 * @param bool
	 * @return array
	 */
	public function get($modified = true) {
		//Argument 1 must be a boolean
		Eden_Collection_Error::i()->argument(1, 'bool');
		
		$array = array();
		//for each row
		foreach($this->_list as $i => $row) {
			//get the array of that (recursive)
			$array[$i] = $row->get($modified);
		}
		
		return $array;
	}
	
	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
        return key($this->_list);
    }
	
	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
        next($this->_list);
    }
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($this->_list[$offset]);
    }
	
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($this->_list[$offset]) ? $this->_list[$offset] : NULL;
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		//Argument 2 must be an array or Eden_Model
		Eden_Collection_Error::i()->argument(2, 'array', $this->_model);
		
		if(is_array($value)) {
			//make it a model
			$model = $this->_model;
			$value = $this->$model($value);
		}
        
		if (is_null($offset)) {
            $this->_list[] = $value;
        } else {
            $this->_list[$offset] = $value;
        }
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
		$this->_list = Eden_Model::i($this->_list)
			->cut($offset)
			->get();
    }
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
        reset($this->_list);
    }
	
	/**
	 * returns serialized data using the Serializable interface
	 *
	 * @return string
	 */
	public function serialize() {
        return $this->__toString();
    }
	
	/**
	 * Sets data
	 *
	 * @return this
	 */
	public function set(array $data = array()) {
		foreach($data as $row) {
			$this->add($row);
		}
		
		return $this;
	}
	
	/**
	 * Sets default model
	 *
	 * @param string
	 * @return this
	 */
	public function setModel($model) {
		$error = Eden_Collection_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($model, 'Eden_Model')) {
			$error->setMessage(Eden_Collection_Error::NOT_SUB_MODEL)
				->addVariable($model)
				->trigger();
		}
		
		$this->_model = $model;
		
		return $this;
	}
	
	/**
	 * sets data using the Serializable interface
	 *
	 * @param string
	 * @return void
	 */
    public function unserialize($data) {
        $this->_list = json_decode($data, true);
		return $this;
    }
	
	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
        return isset($this->_list[key($this->_list)]);
    }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Model Errors
 */
class Eden_Collection_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const NOT_COLLECTION 	= 'The data passed into __construct is not a collection.';
	const NOT_SUB_MODEL 	= 'Class %s is not a child of Eden_Model';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}