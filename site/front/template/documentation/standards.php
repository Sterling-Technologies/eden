<h3>Annex 1. Coding Standards</h3>
<p>We would like to keep a strict coding standard based on our experiences with other frameworks and CMS' to ensure 
when other developers read our source, we present code to be readable, logical and well explained.</p>

<h4>A. Arrays</h4>
<p>Arrays should be properly tabbed when appropiate. the closing parenthesis should be in line with the last value. The following
shows valid examples.</p>
<sub>Figure 1. Arrays</sub>
<div class="example"><pre class="brush: php;">
$array1 = array('i', 'am', 'inline');

$array2 = array(
	'user_id' 		=> 123,
	'user_name'		=> 'Chris',
	'user_created'	=> '2012-01-30');
	
$array3 = array(
	'i', 		'am', 	'a', 	
	'really', 	'long',	'lorem', 
	'ipsum', 	'dolor');

</pre></div>
<blockquote class="tip clearfix">
	<span class="icon"></span>
	<strong>Figure 1</strong> also shows that we prefer single quotes over double or <strong>&quot;</strong>
</blockquote>
<h4>B. Curly Braces</h4>
<p>Opening curly braces or <sub>{</sub> should not be in it's own line. All closing curly braces or <sub>}</sub> must have a line break after. The exceptions are the closing curly before an <sub>else if</sub> or a <sub>try...catch</sub>. Curly braces should be used in all if statements and loops, even if it is a one line conditional. The following shows some valid examples.</p>

<sub>Figure 2. Curly Braces</sub>
<div class="example"><pre class="brush: php;">
public function getZebra($number) {
	if($number % 3 == 1) {
		return 1;
	} else if($number % 3 == 2) {
		return 2;
	}
	
	for($i = 0; $i < $number; $i++) {
		if($i % $number === 0) {
			break;
		}
	}
	
	return $i;
}
</pre></div>

<sub>Figure 3. Bad Curly Braces</sub>
<div class="example"><pre class="brush: php;">
public function getZebra($number) 
{
	if($number % 3 == 1) return 1;
	elseif($number % 3 == 2) return 2;
	
	for($i = 0; $i < $number; $i++)
		if($i % $number === 0) 
		{
			break;
		}
	return $i;
}
</pre></div>

<blockquote class="error clearfix">
	<span class="icon"></span>
	<strong>Figure 3</strong> shows a bad example of an <strong>else if</strong>
	as well. The syntax <strong>elseif</strong> is valid when using PHP templating as in 
	<strong>&lt;?php elseif($isValid): ?&gt;</strong>.
</blockquote>

<h4>C. Class Structure</h4>
<p>When creating a class, we doc categorize different class elements as a guide to know where to put things like constants, properties and methods as well as help other developers find things within the class faster.</p>

<sub>Figure 4. Class Structure</sub>
<div class="example"><pre class="brush: php;">
class My_Class extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
</pre></div>

<h4>D. Java Doc</h4>
<p>Every class, public method and function should have a respective Java Doc defined before the definition.</p>

<sub>Figure 5. Java Doc</sub>
<div class="example"><pre class="brush: php;">
/**
 * Returns the squared version of the given number
 *
 * @param number
 * @return number
 */
public function squared($number) {
	return $number * $number;
}
</pre></div>

<p>The example above shows us how to declare a simple Java Doc. We practice only using the <sub>@param</sub> and the 
<sub>@return</sub> attributes. Both attributes should follow with a data type, exact value or a representation of an object</p>

<h5>Valid Data Types</h5>
<ul>
	<li>null</li>
	<li>int</li>
	<li>float</li>
	<li>number</li>
	<li>string</li>
	<li>array</li>
	<li>bool</li>
	<li>[CLASS NAME]</li>
	<li>this</li>
</ul>

<p>Although most of the data types defined above are self-explanitory, the last two may need some explanation. 
<sub>[CLASS_NAME]</sub> refers to a name of a class. In <sub>Figure 1</sub>, we declared a class called 
<sub>My_Class</sub>. We can use this class name as a data type in <sub>@param</sub> or <sub>@return</sub>
as in <sub>@param My_Class</sub>. <sub>this</sub> refers to the class the following method is defined in.</p>

<p>It is possible to have multiple parameters in a method. For this you just need to declare more than one <sub>@param</sub>
attribute. If your <sub>@param</sub> or <sub>@return</sub> needs more explaination, you can write a small description after 
the data type. It is also possible that a parameter can accept more than one data type. For these cases we simply add a 
&quot;pipe&quot; symbol or <sub>|</sub> in between each type. It is also possible that the last argument could be virtually 
infinite. For these cases we want to wrap optional arguments with a box and infinite possibilities with a <sub>..</sub> as in 
<sub>string[,string..]</sub>. The example below shows some examples of these cases.</p>

<sub>Figure 6. Param Examples</sub>
<div class="example"><pre class="brush: php;">
/**
 * Something explaining the method
 *
 * @param number the user id
 * @param string[,string..] a list of strings to concatenate
 * @param array|string|null the query parameters
 * @param false[,int[,array..]] a list of arrays
 * @return number
 */
</pre></div>

<h4>E. Naming Conventions</h4>
<p>Deciding a name of a property or method should briefly explain what that is.</p>
<h5>Constants</h5>
<p>Constants should be all uppercase with underscores or <sub>_</sub> to separate each word. When writing classes, we 
should use constants for any string or value that does not change in the class. This makes it easier to modify values
when they actually do need to change.</p>
<div class="example"><pre class="brush: php;">
const GOOGLE_GDATA_HEADER = 'Gdata: 2';
</pre></div>

<h5>Class Names</h5>
<p>Similar to constants however the first letter of each word should be capitalized.</p>
<div class="example"><pre class="brush: php;">
class My_Epic_User {}
</pre></div>

<h5>Method Names</h5>
<p>Method names should be camel cased; starts with a lowercase character and capitalize the first letter of each following word.
Method names should always start with a verb. You should always consider your verbs to be either <strong>get</strong> or 
<strong>set</strong> as most methods can fall in either of the two. Of course methods like creating an event or updating
a user could start with <strong>create</strong>, <strong>add</strong>, <strong>update</strong>, <strong>remove</strong>.</p>
<div class="example"><pre class="brush: php;">
public function setName('Chris') {}

public function getUserCreated() {}

public function updateRow($row) {}

public function removePost($postId) {}
</pre></div>

<p>Having a method just called <strong>set</strong>, <strong>get</strong> or any verb can be valid if your class is based off a model.</p>
<div class="example"><pre class="brush: php;">
class User {
	public function set('name', 'Chris') {} //would mean set user name to chris
}
</pre></div>

<h5>Property Names</h5>
<p>Property names, like methods should be camel cased. Property names should always start with a noun. The exception is if a 
property is a boolean.</p>
<div class="example"><pre class="brush: php;">
$userCreated 	= date();
$postTitle 		= 'Lorem Ipsum';
$isValid 		= true;
</pre></div>

<h3>F. Simplification</h3>
<p>We should always think about the developers reading our code. Simplifying code will save time in the end also whenever you need to 
go back and troubleshoot an error.</p>

<sub>Example 1</sub>
<div class="example"><pre class="brush: php;">
if($valid) {
	return 1;
} else {
	return 0;
}
</pre></div>

<p>could be simplified to</p>

<div class="example"><pre class="brush: php;">
if($valid) {
	return 1;
}

return 0;
</pre></div>

<sub>Example 2</sub>
<div class="example"><pre class="brush: php;">
if($valid) {
	return 1;
} else {
	if(is_null($valid)) {
		return NULL;
	}
}

return 0;
</pre></div>

<p>could be simplified to</p>

<div class="example"><pre class="brush: php;">
if($valid) {
	return 1;
} else if(is_null($valid)) {
	return NULL;
}

return 0;
</pre></div>

<p>Simplifying doesn't explicitly mean shortening code; it could also mean de-leveling code.</p>
<sub>Example 3</sub>
<div class="example"><pre class="brush: php;">
foreach($posts as $post) {
	if($post['id'] != 0) {
		$post['created'] = strtotime($post['created']);
		$valid[] = $post;
	}
}
</pre></div>

<p><sub>Example 3</sub> shows how action code is wrapped in 3 levels of tabs. It could be simplified to</p>

<div class="example"><pre class="brush: php;">
foreach($posts as $post) {
	if($post['id'] == 0) {
		continue;
	}
	
	$post['created'] = strtotime($post['created']);
	$valid[] = $post;
}
</pre></div>