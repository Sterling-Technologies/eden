<?php //-->
$loader->load('Eden_Folder');
$unit->setPackage('Eden_Folder Tests');

//-------------------------//
// Test 1
$folder = Eden_Folder::get('home//openovate\public/eden.openovate.com/web');
$folder[] = 'test';
$unit->assertEquals('/home/openovate/public/eden.openovate.com/web/test', (string) $folder, 'Format Folder Test.');
$unit->assertTrue($folder->create()->isFolder(), 'create() and isFolder()[true]');
$unit->assertEquals('test', $folder->getName(), 'getName() - Folder name');

$folder->create()->append('dan')->create();
$unit->assertEquals(array(), $folder->getFiles(), 'getFiles()[array]');
$unit->assertTrue($folder->removeFiles()->isFile(), 'removeFiles()[true]');

$unit->assertFalse($folder->remove()->pop()->isFolder('dan'), 'remove() and isFolder()[false]');

$folder->create()->append('dan')->create()->pop()->truncate();
$unit->assertCount(0, $folder->getFolders(), 'truncate()');
$folder->remove();

$folder = Eden_Folder::get('home//openovate\public/eden.openovate.com/web/');
$unit->assertCount(2, $folder->getFolders(), 'getFolders()');