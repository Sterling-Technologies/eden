<a class="prev" href="/documentation/library/types">&laquo; 6. Data Types </a>
<a class="next" href="/documentation/library/sessions">8. Sessions and Cookies &raquo;</a>

<h3>7. Files and Folders</h3>
<p>At this point, you should understand <strong>Eden's</strong> chainability options for all setter methods, some core
concepts and basic understanding in <strong>Eden's</strong> syntax. In these future sections we can just go though each 
method; describing what it does, notes and how to use it.</p>

<p>File and folder management in <strong>Eden</strong> is easy as calling methods. Both classes can be accessed as arrays 
as shown in the example below.</p>

<sub>Figure 1. Access Files and Folders as arrays</sub>
<div class="example"><pre class="brush: php;">
$folder = eden('folder', '/some/path/anywhere');		//instantiate

$folder[] = 'more';			// adds more to the end (/some/path/anywhere/more)
$folder['prepend'] = 'to';	// adds 'to' to the beginning (/to/some/path/anywhere)
$folder['replace'] = 'here';	// replaces 'anywhere' (the last path) with 'here' (/some/path/here)

echo $folder[1];				// returns the path with index of 1 (path)
echo $folder['last'];			// returns the last path ('anywhere')
echo $folder;					// returns the string path (/some/path/anywhere)
</pre></div>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	Files and folder classes extend <strong>Eden's</strong> string object. This means you can also call common string methods.
</blockquote>

<sub>Figure 2. File Methods</sub>
<div class="example"><pre class="brush: php;">
$file = eden('file', '/some/path/to/file.php');		//instantiate

$file->absolute();			// returns the absolute path (or error)
$file->append('there');		// adds 'there' to the end (/some/path/anywhere/there)
$file->prepend('to');		// adds 'to' to the beginning (/to/some/path/anywhere)
$file->replace('here');		// replaces 'anywhere' (the last path) with 'here' (/some/path/here)
$file->pop();				// removes the last path returns the value
$file->getArray();			// returns the path as an array

$file->getName();				// returns just the file name
$file->getFolder();				// returns the folder name
$file->getBase();				// returns the file name without extension
$file->getExtension();			// returns the file extension
$file->getMime();				// returns the mime type
$file->getData();				// if this is a php file this will load it
$file->getContent();			// returns the contents of the file
$file->getTime();				// returns the time file was updated
$file->getSize();				// returns the size of the file
$file->isFile();				// returns true if this is a real file
$file->setContent('something');	// sets the content to 'something'
$file->setData(array(1, 2, 3));	// writes php data into the file
$file->touch();					// updates the file time to now
$file->remove();				// removes the file
</pre></div>

<sub>Figure 3. Folder Methods</sub>
<div class="example"><pre class="brush: php;">
$folder = eden('folder', '/some/path/to/folder');		//instantiate

$folder->absolute();		// returns the absolute path (or error)
$folder->append('there');	// adds 'there' to the end (/some/path/anywhere/there)
$folder->prepend('to');		// adds 'to' to the beginning (/to/some/path/anywhere)
$folder->replace('here');	// replaces 'anywhere' (the last path) with 'here' (/some/path/here)
$folder->pop();				// removes the last path returns the value
$folder->getArray();		// returns the path as an array

$folder->create(777);		// creates a folder with the permissions 777
$folder->remove();			// removes the folder
$folder->truncate();		// removes all files and folders in this folder

$folder->getName();						// returns just the folder name
$folder->getFolders();					// returns all folders found inside
$folder->getFolders('/\.svn/', true);	// returns all folders found inside with names matching '.svn', recursive
$folder->getFiles('/\.php$/', true);	// returns all files found inside that end with '.php' recursive
$folder->removeFiles('/test/');			// removes all files with names matching 'test'
$folder->removeFolders('/\.hidden/', true); // removes all folders with names matching '.hidden', recursive
$folder->isFolder();					// returns true if this is really a folder
</pre></div>

<a class="prev" href="/documentation/library/types">&laquo; 6. Data Types </a>
<a class="next" href="/documentation/library/sessions">8. Sessions and Cookies &raquo;</a>