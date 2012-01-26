<a class="prev" href="/documentation/library/sessions">&laquo; 8. Sessions and Cookies</a>
<a class="next" href="/documentation/library/templating">10. Templating  &raquo;</a>

<h3>9. The Registry</h3>
<p>One annoyance when dealing with configuration classes is that there can be many which holds a small part of all the 
actual data you need to build a web page. Gathering that data can be a real pain and if not stored in a public variable,
impossible to access. <strong>Eden's</strong> registry out weighs the benefits of a normal configuration class because 
of its ability to organize data and access data by their unique key or access datasets by their common key. When we think 
about <strong>Eden's</strong> registry we can imagine a file system, where if you choose a folder you will get a list of 
files and when you choose a file given its folder path and name you will get the exact value.</p>

<sub>Registry</sub>
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

<a class="prev" href="/documentation/library/sessions">&laquo; 8. Sessions and Cookies</a>
<a class="next" href="/documentation/library/templating">10. Templating  &raquo;</a>