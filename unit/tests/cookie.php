<?php //-->
$loader->load('Eden_Cookie');
$unit->setPackage('Eden_Cookie Tests');

$cookie = Eden_Cookie::i();

//-------------------------//
// Test 1
$cookie->set('test', 456);
$unit->assertSame(456, $cookie->getData('test'), 'Basic setting and getting.');

$cookie['test2'] = 123;
$unit->assertSame(123, $cookie['test2'], 'Setting and getting using arrays.');

//-------------------------//
// Test 2
$cookie->remove('test');
$unit->assertNull($cookie->getData('test'), 'Removing a cookie.');

$cookie->clear();
$unit->assertNull($cookie->getData('test2'), 'Removing all cookies.');

//-------------------------//
// Test 3
$cookie->setSecure('test3', 789);
$unit->assertSame(789, $cookie->getData('test3'), 'Setting and getting secure.');

//-------------------------//
// Test 4
$cookie->clear();
$cookie->setData(array('test20' => 3, 'test22' => 2, 'test23' => 1));
$unit->assertSame(2, $cookie->getData('test22'), 'Setting multiple cookies.');

$cookie->clear();