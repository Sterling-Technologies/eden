<?php //-->
class Class_1 extends Eden_Class{
	public $data = 123;
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function setData($value) {
		$this->data = $value;
		return $this;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function sayHello() {
		return 'hi';
	}
}

class Class_2 extends Eden_Class{
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function sayHello() {
		return 'hello';
	}
}

class Class_3 extends Class_1 {
	public static function get() {
		return self::_getMultiple(__CLASS__);
	}
}

$unit->setPackage('Eden_Class Tests');

//-------------------------//
// Test 1
$test = Class_1::get()
	->setData(789)
	->Class_1()
	->getData();

$unit->assertEquals(789, $test, 'Singleton Test.');

//-------------------------//
// Test 2
$test = Class_1::get()
	->Class_3()
	->setData(789)
	->Class_3()
	->getData();

$unit->assertEquals(123, $test, 'Multiple Test.');

//-------------------------//
// Test 3
$test = Class_1::get()
	->routeThis('Class_4')
	->Class_4()
	->sayHello();

$unit->assertEquals('hi', $test, "routeThisClass('Class_3')");

//-------------------------//
// Test 4
$test = Class_1::get()
	->routeMethod('sayHi', 'Class_2', 'sayHello')
	->sayHi();

$unit->assertEquals('hello', $test, "routeThisMethod('sayHi', 'Class_2', 'sayHello')");

//-------------------------//
// Test 5
$test = Class_1::get()
	->Class_2()
	->sayHello();
	
$unit->assertEquals('hello', $test, 'Loading from one class to another.');

//-------------------------//
// Test 6
$test = Class_1::get()
	->Class_3()
	->when(false)
	->setData(456)
	->endWhen()
	->getData();

$unit->assertEquals(123, $test, 'Conditional test to Noop and return to original class.');

//-------------------------//
// Test 7
$test = Class_1::get()
	->when(true)
	->setData(456)
	->endWhen()
	->getData();

$unit->assertEquals(456, $test, 'Conditional test that passes and acts like normal.');