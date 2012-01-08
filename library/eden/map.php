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
class Eden_Map extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_scope 		= NULL;
	protected $_increment 	= 1;
	protected $_lines		= 0;
	protected $_list 		= array();
	protected $_map			= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($scope, array &$list, $lines = 0) {
		return self::_getMultiple(__CLASS__, $scope, $list, $lines);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($scope, array &$list, $lines = 0) {
		$this->_scope 	= $scope;
		$this->_list 	= &$list;
		$this->_lines 	= $lines;
	}
	
	public function __call($name, $args) {
		if($this->_lines > 0 && $this->_increment == $this->_lines) {
			$this->_map[] = array($name, $args);
			return $this->endMap();
		}
		
		$this->_increment++;
		$this->_map[] = array($name, $args);
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the original class
	 * Eden_Sesison()->map($products)->setData('name', 'chris');
	 * @param bool
	 * @return this|Eden_Noop
	 */
	public function endMap() {
		foreach($this->_list as $key => $object) {	
			foreach($this->_map as $action) {
				$this->_list[$key] = Eden_Route::get()->callMethod($object, $action[0], NULL, $action[1]);
			}
		}
		
		return $this->_scope;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}