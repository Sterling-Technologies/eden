<a class="prev" href="/documentation/library/sessions">&laquo; 8. Sessions and Cookies</a>
<a class="next" href="/documentation/library/templating">10. Templating  &raquo;</a>

<h3>9. The Registry</h3>
<p>One annoyance when dealing with configuration classes is that there can be many which holds a small part of all the 
actual data you need to build a web page. Gathering that data can be a real pain and if not stored in a public variable,
impossible to access. <strong>Eden's</strong> registry out weighs the benefits of a normal configuration class because 
of its ability to organize data and access data by their unique key or access datasets by their common key. When we think 
about <strong>Eden's</strong> registry we can imagine a file system, where if you choose a folder you will get a list of 
files and when you choose a file given its folder path and name you will get the exact value. <sub>Figure 1</sub> below 
shows how we set data in the registry.</p>

<sub>Figure 1. Setting Paths</sub>
<div class="example"><pre class="brush: php;">
$registry = eden('registry') //instantiate
	->set('path', 'to', 'value1', 123)	//set path 'path','to', 'value' to 123
	->set('path', 'to', 'value2', 456);	//set path 'path','to', 'value' to 456
</pre></div>

<p>Now that we have a populated registry, <sub>Figure 2</sub> shows us how we can access data and datasets.</p>

<sub>Figure 2. Get Data and Datasets</sub>
<div class="example"><pre class="brush: php;">
echo $registry->get('path', 'to', 'value1');	//--> 123
echo $registry->get('path', 'to', 'value2');	//--> 456
echo $registry->get('path', 'to');	//--> {value1:123,value2:456}
</pre></div>

<blockquote class="note">
	<h5>Author Note</h5>
	<span>At <a href="http://openovate.com/" target="_blank">Openovate Labs</a>, it's common practice to store 
	global PHP variables in the registry on page load. This ensures that we do not manipulate those variables
	and screw over other apps that may need the original data.</span>
	
	<div class="example"><pre class="brush: php;">
	$registry = eden('registry') //instantiate
		->set('server', $_SERVER)
		->set('env', $_ENV)
		->set('post', $_POST)
		->set('get', $_GET)
		->set('session', $_SESSION)
		->set('cookie', $_COOKIE);
		
	echo $registry->get('server', 'HTTP_HOST'); //--> eden.openovate.com
	</pre></div>
</blockquote>


<p>The complete list of methods for a registry can be found in <sub>Figure 3</sub>.</p>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	The Registry class extends <strong>Eden's</strong> array object. This means you can also call 
	<br />common array methods.
</blockquote>

<sub>Figure 3. Registry Methods</sub>
<div class="example"><pre class="brush: php;">
$registry->set('path', 'to', 'value');	//set path 'path','to' to 'value'
$registry->get('path', 'to');			//get data where path is 'path','to'
$registry->remove('path', 'tp');		//unset data where path is 'path','to'
$registry->isKey();						//returns true if path 'path','to' exists

$registry['name'] = 'value';			//set 'name' to 'value'
echo $registry['path']['to'];			//get data where path is 'path','to'

foreach($registry as $key => $value) {}	//loop through registry

echo $registry; // outputs a json version of the registry
</pre></div>

<a class="prev" href="/documentation/library/sessions">&laquo; 8. Sessions and Cookies</a>
<a class="next" href="/documentation/library/templating">10. Templating  &raquo;</a>