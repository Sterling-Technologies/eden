<?php //-->
$loader->load('Eden_Session');
$unit->setPackage('Eden_Session Tests');

$session = Eden_Session::i();

//-------------------------//
// Test 1
try {
	$session->setData('test', 456);
} catch(Exception $e1) {}

$unit->assertInstanceOf('Eden_Session_Error', $e1, 'Error while doing something before session was started.');


//-------------------------//
// Test 1
$session->stop()->start()->setData('test', 456);
$unit->assertSame(456, $session->getData('test'), 'Basic setting and getting.');

$session['test2'] = 123;
$unit->assertSame(123, $session['test2'], 'Setting and getting using arrays.');

//-------------------------//
// Test 2
$session->remove('test');
$unit->assertNull($session->getData('test'), 'Removing a session.');

$session->clear();
$unit->assertNull($session->getData('test2'), 'Removing all sessions.');

//-------------------------//
// Test 3
$session->clear();
$session->setData(array('test20' => 3, 'test22' => 2, 'test23' => 1));
$unit->assertSame(2, $session->getData('test22'), 'Setting multiple sessions.');

$session->stop();