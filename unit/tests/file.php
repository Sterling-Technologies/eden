<?php //-->
$loader->load('Eden_File');
$unit->setPackage('Eden_File Tests');

//-------------------------//
// Test 1
$file = Eden_File::get('home//openovate\public/eden.openovate.com/web/workspace.php');
$unit->assertEquals('/projects/openovate/eden/v2/workspace.php', (string) $file, 'Format File Test.');
$unit->assertEquals('workspace.php', $file->getName(), 'getName()');
$unit->assertEquals('/projects/openovate/eden/v2', $file->getFolder(), 'getFolder()');
$unit->assertEquals('workspace', $file->getBase(), 'getBase()');
$unit->assertEquals('php', $file->getExtension(), 'getExtension()');

//-------------------------//
// Test 2
$unit->assertEquals('application/octet-stream', $file->touch()->getMime(), 'touch() and getMime()');
$unit->assertGreaterThanOrEquals(0, $file->getSize(), 'getSize()');
$unit->assertGreaterThan(time()-100, $file->getTime(), 'getTime()');
$unit->assertTrue($file->isFile(), 'isFile() [true]');
$unit->assertEquals('test123', $file->setContent('test123')->getContent(), 'setContent() and getContent()');
$unit->assertEquals('test123', $file->setData('test123')->getData(), 'setData() and getData()');
$unit->assertCount(2, $file->setData(array(3,4))->getData(), 'setData() and getData()');
$unit->assertGreaterThan(time()-100, $file->getTime(), 'getTime()');
$unit->assertFalse($file->remove()->isFile(), ' remove() and isFile() [false]');

//-------------------------//
// Test 3
$unit->assertEquals('openovate', $file[2], 'accessing file path with index');
$file['replace'] = 'work2.php';
$unit->assertEquals('/home/openovate/public/eden.openovate.com/web/work2.php', (string) $file, 'replacing with array');