<a class="prev" href="/">&laquo; What is Eden?</a>
<a class="next" href="/documentation/library/features">1. Features &raquo;</a>

<h3>I. Quick Start</h3>

<p>To get started on this amazing adventure start by heading over to the <a href="/download">downloads</a> page and getting the core files. You'll notice when downloading, it's only one file. We made it easier to try out <strong>Eden</strong> by compressing and bundling the whole library in one file.</p>

<p>From here just upload that file to your server <em>(under the assumption you have access to a server with at least PHP5.2.6)</em>, create a new file called <sub>test.php</sub> in the same directory you uploaded <sub>eden.php</sub> and paste the code snippet below.</p>

<sub>Paste this Code Snippet!</sub>
<div class="example"><pre class="brush: php;">
include('eden.php');
eden('tool')->output('Hello World'); //--> Hello World
</pre></div>

<p>If you look at <sub>test.php</sub> in your browser you'll see something along the lines of <strong>&quot;Hello World&quot;</strong>. This means you are ready to build a website! As easy as it is to install, head over to the section called <a href="/documentation/library/features">1. Features</a> to find out what you can do with <strong>Eden</strong>!</p>

<h4>Snippets</h4>
<p>You can learn <strong>Eden</strong> quickly! The following quickly shows you how to get around.</p>

<sub>Setting up <strong>Eden</strong> default aliases</sub>
<div class="example"><pre class="brush: php;">
eden()->routeClasses(true)->routeMethods(true);
</pre></div>

<sub>All posible ways to instantiate <strong>Eden</strong> classes</sub>
<div class="example"><pre class="brush: php;">
//Generic
new Eden_Session;
new Eden_Session();
Eden_Session::i();	

//Used outside of a class
eden('session');			
eden()->Session();		// alias
eden()->Eden_Session();

//Used in a class extended with Eden
$this->Session();		// alias
$this->Eden_Session();	
$this('session');		//PHP 5.3

/* Passing construct arguments */

//Generic
new Eden_Validation('something');
Eden_Validation::i('something');		//instantiate in a class

//Used outside of a class
eden('validation', 'something');		
eden()->Validation('something');		// alias
eden()->Eden_Validation('something');	

//Used in a class extended with Eden
$this->Validation('something');			// alias
$this->Eden_Validation('something');	
$this('validation', 'something');		// PHP 5.3
</pre></div>

<sub>Sessions <em>(singleton)</em></sub>
<div class="example"><pre class="brush: php;">
$session = eden('session');			//instantiate

$session->start();					//starts session
$session->getId();					//get session id

$session->set('name', 'value');		//set 'name' to 'value' in session data
$session->get('name');				//get session data where key is 'name'
$session->remove('name');			//unset session data where key is name
$session->clear();					//remove all session data

$session['name'] = 'value';			//set 'name' to 'value' in session data
echo $session['name'];				//get session data where key is 'name'
unset($session['name']);			//unset session data where key is 'name'
isset($session['name']);			//returns true if a key called 'name' exists

foreach($session as $key => $value) {}	//loop through session data

echo $session; // outputs a json version of the session data
</pre></div>

<sub>Cookies <em>(singleton)</em></sub>
<div class="example"><pre class="brush: php;">
$cookie = eden('cookie');			//instantiate

$cookie->set('name', 'value');		//set 'name' to 'value' in cookie data
$cookie->get('name');				//get cookie data where key is 'name'
$cookie->remove('name');			//unset cookie data where key is name
$cookie->clear();					//remove all cookie data

$cookie['name'] = 'value';			//set 'name' to 'value' in session data
echo $cookie['name'];				//get session data where key is 'name'
unset($cookie['name']);				//unset session data where key is 'name'
isset($cookie['name']);				//returns true if a key called 'name' exists

foreach($cookie as $key => $value) {}	//loop through cookie data

echo $cookie; // outputs a json version of the cookie data
</pre></div>



<sub>Strings</sub>
<div class="example"><pre class="brush: php;">
$string = eden('type', 'Hello World');		//instantiate

$string->camelize('-');			//looks for dashes and transforms to camel casing
$string->uncamelize('-');		//replaces camel casing to lower case with dash between
$string->dasherize();			//transforms spaces to dashes or URL friendly name
$string->titlze('-');			//transforms a dashed string to a Title (Caps and spaces)

//Supported PHP String Methods
$string->addSlashes();
$string->bin2hex()
$string->chunkSplit();
$string->convertUudecode();	
$string->convertUuencode();
$string->crypt();	
$string->htmlEntityDecode();
$string->htmlentities();	
$string->htmlspecialcharsDecode();
$string->htmlspecialchars();	
$string->lcfirst();
$string->ltrim();	
$string->md5();
$string->nl2br();	
$string->quotedPrintableDecode();
$string->quotedPrintableEncode();	
$string->quotemeta();
$string->rtrim();	
$string->sha1();
$string->sprintf('val1', 'val2');	
$string->pad();
$string->repeat();	
$string->rot13();
$string->shuffle();	
$string->stripTags();
$string->stripcslashes();	
$string->stripslashes();
$string->strpbrk();	
$string->stristr();
$string->strrev();	
$string->strstr();
$string->strtok();	
$string->strtolower();
$string->strtoupper();	
$string->strtr();
$string->substrReplace();	
$string->substr(1, 2);
$string->trim();	
$string->ucfirst();
$string->ucwords();	
$string->vsprintf();
$string->wordwrap();	
$string->countChars();
$string->hex2bin();	
$string->strlen();
$string->strpos();	
$string->substrCompare();
$string->substrCount();	
$string->strIreplace();
$string->strReplace(' ', '-');
$string->pregReplace('/[A-Z]/', '-');
$string->explode(' ');					//returns Eden_Type_Array

echo $string; // outputs the modified string
</pre></div>

<sub>Arrays</sub>
<div class="example"><pre class="brush: php;">
$array = eden('type', 1, 2, 3);			//instantiate

$array->isEmpty();								//returns true if array is empty
$array->copy('Key1', 'Key2');					//copies the value of 'Key1' to 'Key2'
$array->cut(2);									//removes index of 2 and reindexes array
$array->paste('Key1', 'Key3', 'value');			//adds 'Key3' with the value of 'value' after 'Key1'

//Supported PHP Array Methods
$array->changeKeyCase();
$array->chunk();
$array->combine();
$array->countDatas();
$array->diffAssoc();
$array->diffKey();
$array->diffUassoc();
$array->diffUkey();
$array->diff();
$array->fillKeys();
$array->filter();
$array->flip();
$array->intersectAssoc();
$array->intersectKey();
$array->intersectUassoc();
$array->intersectUkey();
$array->intersect();
$array->keys();
$array->mergeRecursive();
$array->merge();
$array->pad();
$array->reverse();
$array->shift();
$array->slice();
$array->splice();
$array->sum();
$array->udiffAssoc();
$array->udiffUassoc();
$array->udiff();
$array->uintersectAssoc();
$array->uintersectAassoc();
$array->uintersect();
$array->unique();
$array->datas();
$array->count();
$array->current();
$array->each();
$array->end();
$array->extract();
$array->key();
$array->next();
$array->prev();
$array->sizeof();
$array->fill();
$array->map();
$array->search();
$array->compact();
$array->implode(' '); //returns Eden_Type_String
$array->in_array();
$array->unshift();
$array->walkRecursive();
$array->walk();
$array->arsort();
$array->asort();
$array->krsort();
$array->ksort();
$array->natcasesort();
$array->natsort();
$array->reset();
$array->rsort();
$array->shuffle();
$array->sort();
$array->uasort();
$array->uksort();
$array->usort();
$array->push();

foreach($array as $key => $value) {}	//loop through array

echo $array; // outputs a json version of the array
</pre></div>

<sub>Registry (Extends Array [above])</sub>
<div class="example"><pre class="brush: php;">
$registry = eden('registry');			//instantiate

$registry->set('path', 'to', 'value');	//set path 'path','to' to 'value'
$registry->get('path', 'to');			//get data where path is 'path','to'
$registry->remove('path', 'tp');		//unset data where path is 'path','to'
$registry->isKey();						//returns true if path 'path','to' exists

$registry['name'] = 'value';			//set 'name' to 'value'
echo $registry['path']['to'];			//get data where path is 'path','to'

foreach($registry as $key => $value) {}	//loop through registry

echo $registry; // outputs a json version of the registry
</pre></div>

<sub>Template</sub>
<div class="example"><pre class="brush: php;">
$template = eden('template');			//instantiate

$template->set('name', 'value');			//set template variable 'name' to 'value'
$template->parseString('he is name');		//replaces all instances of each template variable with their respective value
$template->parsePHP('/to/template.php');	//makes all template variables as php variables given the PHP template file
$template->parseEngine(/to/template.tpl);	//looks smarty type variables and replaces with template variables (can loop)
</pre></div>

<sub>Validation</sub>
<div class="example"><pre class="brush: php;">
$validation = eden('validation', 'something');		//instantiate

$validation->isEmail();						// Returns true if email
$validation->isUrl();						// Returns true if URL
$validation->isHtml();						// Returns true if HTML
$validation->isShortName();					// Returns true if short name
$validation->startsWithLetter();			// Returns true if starts with letter

$validation->greaterThan(4);				// Returns true if number length &gt; 4
$validation->greaterThanEqualTo(4);			// Returns true if number length &gt;= 4
$validation->lessThan(4);					// Returns true if number length &lt; 4
$validation->lessThanEqualTo(4);			// Returns true if number length &lt;= 4 

$validation->lengthGreaterThan(4);			// Returns true if string length &gt; 4
$validation->lengthGreaterThanEqualTo(4);	// Returns true if string length &gt;= 4
$validation->lengthLessThan(4);				// Returns true if string length &lt; 4 
$validation->lengthLessThanEqualTo(4);		// Returns true if string length &lt;= 4
$validation->wordCountEquals(4);			// Returns true if word count &gt; 4  
$validation->wordCountGreaterThan(4);		// Returns true if word count &gt;= 4 
$validation->wordCountGreaterThanEqualTo(4);	// Returns true if 
$validation->wordCountLessThan(4);			// Returns true if word count &lt; 4
$validation->wordCountLessThanEqualTo(4);	// Returns true if word count &lt;= 4

$validate = array(
	array('method' => 'wordCountEquals', 'not equal'),
	array('method' => 'startsWithLetter', 'no letter'),
	array('method' => 'isEmail', 'not email'));
	
$validation->getErrors($validate);			//returns error messages if any return false
</pre></div>

<sub>Path (Extends Strings [above])</sub>
<div class="example"><pre class="brush: php;">
$path = eden('path', '/some/path/anywhere');		//instantiate

$path->absolute();			// returns the absolute path (or error)
$path->append('there');		// adds 'there' to the end (/some/path/anywhere/there)
$path->prepend('to');		// adds 'to' to the beginning (/to/some/path/anywhere)
$path->replace('here');		// replaces 'anywhere' (the last path) with 'here' (/some/path/here)
$path->pop();				// removes the last path returns the value
$path->getArray();			// returns the path as an array

$path[] = 'more';			// adds more to the end (/some/path/anywhere/more)
$path['prepend'] = 'to';	// adds 'to' to the beginning (/to/some/path/anywhere)
$path['replace'] = 'here';	// replaces 'anywhere' (the last path) with 'here' (/some/path/here)

echo $path[1];				// returns the path with index of 1 (path)
echo $path['last'];			// returns the last path ('anywhere')
</pre></div>

<sub>File (Extends Path [above])</sub>
<div class="example"><pre class="brush: php;">
$file = eden('file', '/some/path/to/file.php');		//instantiate

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

<sub>Folder (Extends Path [above])</sub>
<div class="example"><pre class="brush: php;">
$folder = eden('folder', '/some/path/to/folder');		//instantiate

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

<a class="prev" href="/">&laquo; What is Eden?</a>
<a class="next" href="/documentation/library/features">1. Features &raquo;</a>