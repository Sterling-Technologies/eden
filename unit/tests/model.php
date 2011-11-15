<?php //-->
$loader->load('Eden_Model');
$unit->setPackage('Eden_Model Tests');

$post = Eden_Model::get()
	->setMetaData('post_id')
	->setMetaData('post_title')
	->setMetaData('post_detail');

//-------------------------//
// Test 1
$post['post_title'] = 'Title1';
$unit->assertEquals('Title1', $post['post_title'], 'Setting values with array.');

$post->setPostTitle('Title2');
$unit->assertEquals('Title2', $post['post_title'], 'Setting values with method.');

$post->post_title = 'Title3';
$unit->assertEquals('Title3', $post['post_title'], 'Setting values with object.');

//-------------------------//
// Test 2
$e1 = $e2 = $e3 = NULL;

try {
	$post['author'] = 'Chris';
} catch(Exception $e1) {}

$unit->assertInstanceOf('Eden_Model_Error', $e1, 'Setting invalid values with array.');

try {
	$post->setAuthor('Chris');
} catch(Exception $e2) {}

$unit->assertInstanceOf('Eden_Model_Error', $e2, 'Setting invalid values with method.');

try {
	$post->author = 'Chris';
} catch(Exception $e3) {}

$unit->assertInstanceOf('Eden_Model_Error', $e3, 'Setting invalid values with object.');

//-------------------------//
// Test 3
$post['post_detail'] = 'Some Detail';
$unit->assertEquals('Some Detail', $post['post_detail'], 'Getting values with array.');
$unit->assertEquals('Some Detail', $post->getPostDetail(), 'Getting values with method.');
$unit->assertEquals('Some Detail', $post->post_detail, 'Getting values with object.');

//-------------------------//
// Test 4
$post['post_detail'] = 'Some Detail 2';
unset($post['post_detail']);
$unit->assertNull($post['post_detail'], 'Disabled unset on array.');

$post->post_detail = 'Some Detail 3';
unset($post->post_detail);
$unit->assertNull($post['post_detail'], 'Disabled unset on object.');

//-------------------------//
// Test 5
$post->setMetaData('post_author', array('validation' => array('char', 255)));
$test = $post->getMetaData('post_author', 'validation');
$unit->assertEquals(255, $test[1], "setMetaData('post_author', array('validation' => array('char', 255)))");

$post->setMetaData('post_author', 'format', 'BY: %s');
$test = $post->getMetaData('post_author', 'format');
$unit->assertEquals('BY: %s', $test, "setMetaData('post_author', 'format', 'BY: %s')");