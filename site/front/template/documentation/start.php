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
echo $path					// returns the string path (/some/path/anywhere)
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

echo $file						// returns the string file (/some/path/to/file)
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

echo $folder						// returns the string folder (/some/path/to/folder)
</pre></div>

<sub>Image (requires GD2 library)</sub>
<div class="example"><pre class="brush: php;">
$image = eden('image', '/some/path/to/image.jpg', 'jpg');	//instantiate
$image = eden('image', $image, 'jpg', false);				// pass in image data

$image->crop(300, 300);					// Crops an image
$image->scale(300, 300);				// Scales an image
$image->resize(300, 300);				// Scales an image while keeping aspect ration
$image->rotate(90);						// Rotates image
$image->invert();						// Invert horizontal
$image->invert(true);					// Invert vertical
$image->greyscale();					
$image->negative();						// inverses all the colors
$image->brightness(4);					
$image->contrast(4);					
$image->colorize(0, 0, 255);			// colorize to blue (R, G, B)
$image->edgedetect();					// highlight edges
$image->emboss();						
$image->gaussianBlur();
$image->blur();
$image->meanRemoval();					// achieve a "sketchy" effect.
$image->smooth(10);
$image->setTransparency();				// set the transparent color
$image->getDimensions();				// get the width and height
$image->getResource();					// get the GD resource for advanced editing
$image->save('/path/to/file.jpg', 'jpg');	// save image to file

header('Content-type: image/jpeg');
echo $image;							//prints the image data
</pre></div>

<sub>cURL</sub>
<div class="example"><pre class="brush: php;">
$curl = eden('curl');	//instantiate

$curl->verifyHost();	//verify host
$curl->verifyPeer();	//verify peer
$curl->setUrlParameter('email', 'someone@email.com');	//sets parameter for GET or POST sending
$curl->setHeaders('Authorization', 'basic');			//sets request headers						

$curl->send();						// sends request off
$curl->getResponse();				// sends request off and returns the response
$curl->getJsonResponse();			// sends request off and returns the response JSON parsed 
$curl->getQueryResponse();			// sends request off and returns the response query parsed (test=1&amp;test2=2)
$curl->getDomDocumentResponse();	// sends request off and returns the response DomDocument parsed 
$curl->getSimpleXmlResponse();		// sends request off and returns the response SimpleXml parsed 

// boolean options
$curl->setAutoReferer() 		// see: CURLOPT_AUTOREFERER,
$curl->setBinaryTransfer() 		// see: CURLOPT_BINARYTRANSFER,
$curl->setCookieSession() 		// see: CURLOPT_COOKIESESSION,
$curl->setCrlF() 				// see: CURLOPT_CRLF,
$curl->setDnsUseGlobalCache() 	// see: CURLOPT_DNS_USE_GLOBAL_CACHE,
$curl->setFailOnError() 		// see: CURLOPT_FAILONERROR,
$curl->setFileTime() 			// see: CURLOPT_FILETIME,
$curl->setFollowLocation() 		// see: CURLOPT_FOLLOWLOCATION,
$curl->setForbidReuse() 		// see: CURLOPT_FORBID_REUSE,
$curl->setFreshConnect() 		// see: CURLOPT_FRESH_CONNECT,
$curl->setFtpUseEprt() 			// see: CURLOPT_FTP_USE_EPRT,
$curl->setFtpUseEpsv() 			// see: CURLOPT_FTP_USE_EPSV,
$curl->setFtpAppend() 			// see: CURLOPT_FTPAPPEND,
$curl->setFtpListOnly() 		// see: CURLOPT_FTPLISTONLY,
$curl->setHeader() 				// see: CURLOPT_HEADER,
$curl->setHeaderOut() 			// see: CURLINFO_HEADER_OUT,
$curl->setHttpGet() 			// see: CURLOPT_HTTPGET,
$curl->setHttpProxyTunnel() 	// see: CURLOPT_HTTPPROXYTUNNEL,
$curl->setNetrc() 				// see: CURLOPT_NETRC,
$curl->setNobody() 				// see: CURLOPT_NOBODY,
$curl->setNoProgress() 			// see: CURLOPT_NOPROGRESS,
$curl->setNoSignal() 			// see: CURLOPT_NOSIGNAL,
$curl->setPost() 				// see: CURLOPT_POST,
$curl->setPut() 				// see: CURLOPT_PUT,
$curl->setReturnTransfer() 		// see: CURLOPT_RETURNTRANSFER,
$curl->setSslVerifyPeer() 		// see: CURLOPT_SSL_VERIFYPEER,
$curl->setTransferText() 		// see: CURLOPT_TRANSFERTEXT,
$curl->setUnrestrictedAuth() 	// see: CURLOPT_UNRESTRICTED_AUTH,
$curl->setUpload() 				// see: CURLOPT_UPLOAD,
$curl->setVerbose() 			// see: CURLOPT_VERBOSE);

// integer options	
$curl->setBufferSize() 			// see: CURLOPT_BUFFERSIZE,
$curl->setClosePolicy() 		// see: CURLOPT_CLOSEPOLICY,
$curl->setConnectTimeout() 		// see: CURLOPT_CONNECTTIMEOUT,
$curl->setConnectTimeoutMs() 	// see: CURLOPT_CONNECTTIMEOUT_MS,
$curl->setDnsCacheTimeout() 	// see: CURLOPT_DNS_CACHE_TIMEOUT,
$curl->setFtpSslAuth() 			// see: CURLOPT_FTPSSLAUTH,
$curl->setHttpVersion() 		// see: CURLOPT_HTTP_VERSION,
$curl->setHttpAuth() 			// see: CURLOPT_HTTPAUTH,
$curl->setInFileSize() 			// see: CURLOPT_INFILESIZE,
$curl->setLowSpeedLimit() 		// see: CURLOPT_LOW_SPEED_LIMIT,
$curl->setLowSpeedTime() 		// see: CURLOPT_LOW_SPEED_TIME,
$curl->setMaxConnects() 		// see: CURLOPT_MAXCONNECTS,
$curl->setMaxRedirs() 			// see: CURLOPT_MAXREDIRS,
$curl->setPort() 				// see: CURLOPT_PORT,
$curl->setProxyAuth() 			// see: CURLOPT_PROXYAUTH,
$curl->setProxyPort() 			// see: CURLOPT_PROXYPORT,
$curl->setProxyType() 			// see: CURLOPT_PROXYTYPE,
$curl->setResumeFrom() 			// see: CURLOPT_RESUME_FROM,
$curl->setSslVerifyHost() 		// see: CURLOPT_SSL_VERIFYHOST,
$curl->setSslVersion() 			// see: CURLOPT_SSLVERSION,
$curl->setTimeCondition() 		// see: CURLOPT_TIMECONDITION,
$curl->setTimeout() 			// see: CURLOPT_TIMEOUT,
$curl->setTimeoutMs() 			// see: CURLOPT_TIMEOUT_MS,
$curl->setTimeValue() 			// see: CURLOPT_TIMEVALUE);

// string options	
$curl->setCaInfo() 				// see: CURLOPT_CAINFO,
$curl->setCaPath() 				// see: CURLOPT_CAPATH,
$curl->setCookie() 				// see: CURLOPT_COOKIE,
$curl->setCookieFile() 			// see: CURLOPT_COOKIEFILE,
$curl->setCookieJar() 			// see: CURLOPT_COOKIEJAR,
$curl->setCustomRequest() 		// see: CURLOPT_CUSTOMREQUEST,
$curl->setEgdSocket() 			// see: CURLOPT_EGDSOCKET,
$curl->setEncoding() 			// see: CURLOPT_ENCODING,
$curl->setFtpPort() 			// see: CURLOPT_FTPPORT,
$curl->setInterface() 			// see: CURLOPT_INTERFACE,
$curl->setKrb4Level() 			// see: CURLOPT_KRB4LEVEL,
$curl->setPostFields() 			// see: CURLOPT_POSTFIELDS,
$curl->setProxy() 				// see: CURLOPT_PROXY,
$curl->setProxyUserPwd() 		// see: CURLOPT_PROXYUSERPWD,
$curl->setRandomFile() 			// see: CURLOPT_RANDOM_FILE,
$curl->setRange() 				// see: CURLOPT_RANGE,
$curl->setReferer() 			// see: CURLOPT_REFERER,
$curl->setSslCipherList() 		// see: CURLOPT_SSL_CIPHER_LIST,
$curl->setSslCert() 			// see: CURLOPT_SSLCERT,
$curl->setSslCertPassword() 	// see: CURLOPT_SSLCERTPASSWD,
$curl->setSslCertType() 		// see: CURLOPT_SSLCERTTYPE,
$curl->setSslEngine() 			// see: CURLOPT_SSLENGINE,
$curl->setSslEngineDefault() 	// see: CURLOPT_SSLENGINE_DEFAULT,
$curl->setSslkey() 				// see: CURLOPT_SSLKEY,
$curl->setSslKeyPasswd() 		// see: CURLOPT_SSLKEYPASSWD,
$curl->setSslKeyType() 			// see: CURLOPT_SSLKEYTYPE,
$curl->setUrl() 				// see: CURLOPT_URL,
$curl->setUserAgent() 			// see: CURLOPT_USERAGENT,
$curl->setUserPwd() 			// see: CURLOPT_USERPWD);
	
// array options
$curl->setHttp200Aliases() 	// see: CURLOPT_HTTP200ALIASES,
$curl->setHttpHeader() 		// see: CURLOPT_HTTPHEADER,
$curl->setPostQuote() 		// see: CURLOPT_POSTQUOTE,
$curl->setQuote() 			// see: CURLOPT_QUOTE);

// file options		
$curl->setFile() 			// see: CURLOPT_FILE,
$curl->setInfile() 			// see: CURLOPT_INFILE,
$curl->setStdErr() 			// see: CURLOPT_STDERR,
$curl->setWriteHeader() 		// see: CURLOPT_WRITEHEADER);
		
// callback options
$curl->setHeaderFunction() 	// see: CURLOPT_HEADERFUNCTION,
$curl->setReadFunction() 	// see: CURLOPT_READFUNCTION,
$curl->setWriteFunction() 	// see: CURLOPT_WRITEFUNCTION);
</pre></div>

<sub>Events</sub>
<div class="example"><pre class="brush: php;">
$event = eden('event');	//instantiate

$event->listen('error', 'My_Class', 'sendEmail');
$event->listen('error', $object, 'sendEmail');
$event->listen('error', $object, 'sendEmail', true);

$event->unlisten('error', 'My_Class', 'sendEmail');	//stops listening to My_Class::sendEmail() on error
$event->unlisten('error', $object, 'sendEmail');	//stops listening to $object->sendEmail() on error
$event->unlisten('error', 'My_Class');				//stops listening to My_Class (all methods) on error
$event->unlisten('error');							//stops listening to error (all classes and methods)

$event->trigger('error');					//calls every method listening to the error event
$event->trigger('error', 'Something', 123);	//calls every method listening to the error event passing 'Something' and 123 as arguments
</pre></div>

<sub>MySQL</sub>
<div class="example"><pre class="brush: php;">
$database = eden('mysql', '[HOST]' ,'[DBNAME]', '[USER]', '[PASS]');	//instantiate
</pre></div>

<sub>PostGre</sub>
<div class="example"><pre class="brush: php;">
$database = eden('postgre', '[HOST]' ,'[DBNAME]', '[USER]', '[PASS]');	//instantiate
</pre></div>

<sub>All Databases General Methods</sub>
<div class="example"><pre class="brush: php;">
$database->getRow('user', 'user_id', 1);	// returns the row from 'user' table where 'user_id' equals 1
$database->getRows('user');				// returns all the rows from the 'user' table
$database->getModel('user', 'user_id', 1);	// returns a model from 'user' table where 'user_id' equals 1
$database->getCollection('user');			// returns a collection based off all rows in the user table

$settings = array(
	'user_name'		=> 'Chris'
	'user_email'	=> 'myemail@mail.com');
	
$filter[] = array('user_id=%s', 1);		

$database->insertRow('user', $settings);			// inserts row into 'user' table
$database->updateRows('user', $settings, $filter); // updates rows in 'user' table where user_id is 1
$database->deleteRows('user', $settings);			// delete rows in 'user' table where user_id is 1
$database->getColumns('user');						// returns the 'user' table columns
$database->getPrimaryKey('user');					// returns 'user_id', the primary key of 'user' table

$database->collection();		// returns a blank collection
$database->model();			// returns a blank model

$select = $database->select();		// returns a select CRUD
$insert = $database->insert();		// returns a insert CRUD
$update = $database->update();		// returns a update CRUD
$delete = $database->delete();		// returns a delete CRUD
$create = $database->create();		// returns a create CRUD
$alter = $database->alter();		// returns an alter CRUD

$database->bind(123);				// returns bind keyword 
$binds = $database->getBinds();	// returns all bound values

$database->query($select, $binds);	// returns the results of the generated $select crud with bound values

$database->query('SELECT * FROM USER');	// returns results of raw queries
</pre></div>

<sub>All Databases SELECT Query</sub>
<div class="example"><pre class="brush: php;">
$select->select('*');			
$select->from('user');			

$select->innerJoin('post', 'post_user=user_id', false);	// INNER JOIN post ON(post_user=user_id)
$select->leftJoin('post', 'user_id');					// LEFT JOIN post USING (user_id)
$select->rightJoin('post', 'post_user=user_id', false);	// RIGHT JOIN post ON(post_user=user_id)
$select->outerJoin('post', 'user_id');					// OUTER JOIN post USING (user_id)

$select->where('user_id=1');		
$select->sortBy('user_id', 'ASC');	
$select->groupBy('user_name');		
$select->limit(0, 1);				

echo $select;	// returns the string version of select query
</pre></div>

<sub>All Databases DELETE Query</sub>
<div class="example"><pre class="brush: php;">
$delete->setTable('user');			
$delete->where('user_id=1');		

echo $delete;	// returns the string version of delete query
</pre></div>

<sub>All Databases INSERT Query</sub>
<div class="example"><pre class="brush: php;">	
$insert->setTable('user');			
$insert->set('user_name', 'Chris');		

echo $insert;	// returns the string version of insert query
</pre></div>

<sub>All Databases UPDATE Query</sub>
<div class="example"><pre class="brush: php;">
$update->setTable('user');			
$update->set('user_name', 'Chris');		
$update->where('user_id=1');
echo $update;	// returns the string version of update query
</pre></div>

<sub>All Databases Models (Extends Array)</sub>
<div class="example"><pre class="brush: php;">
$model->setUserName('Chris');			//set user name
$model->getUserEmail();					// returns user email

//$model->setAnyThing()				// set or get any abstract key

echo $model['user_name'];				//access as array
$model['user_email'] = 'my@email.com';	//set as array

$model->save('user', $database);	//save to 'user' table in database
									//only relavent columns will be saved
</pre></div>

<sub>All Databases Collections</sub>
<div class="example"><pre class="brush: php;">
$collection->setUserName('Chris');			//set user name for all rows

//$collection->setAnyThing()				// set or get any abstract key for all rows

echo $collection[0]['user_name'];				//access as array
$collection[0]['user_email'] = 'my@email.com';	//set as array

$collection->save('user', $database);	//save to 'user' table in database
										//only relavent columns will be saved
										//for all rows
</pre></div>

<a class="prev" href="/">&laquo; What is Eden?</a>
<a class="next" href="/documentation/library/features">1. Features &raquo;</a>