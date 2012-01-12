<a class="prev" href="/documentation/start">&laquo; I. Quick Start</a>
<a class="next" href="/documentation/library/classes">2. Classes &raquo;</a>

<h3>1. Features</h3>
<p>Some of the greatest features, as well as supporting web services out of the box, lies in <strong>Eden's</strong> core. The core's purpose is to give the <em>end developer</em> an easier experience in OOP and design patterns while tackling some of the most complicated problems that exist in web development today.</p>

<h4>Simple Interface</h4>
<p><strong>Eden</strong> simplifies the way you code in PHP through a concept called <sub>Simple Interface</sub>.</p>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	<strong>Simple Interface</strong> is a design made to simplify the steps it takes to get a result set or to perform an action which benefits <em>end developers</em>.
</blockquote>

<p><sub>Figure 1</sub> below further explains Simple Interface by instantiating a class and calling method in one line.</p>

<sub>Figure 1. Our Hello World Example</sub>
<div class="example"><pre class="brush: php;">
eden('tool')->output('Hello World'); //--> Hello World

/* vs */

$tool = new Eden_Tool();
$tool->output('Hello World'); //--> Hello World
</pre></div>

<p>In the example above, we called a class named <sub>Eden_Tool</sub> and printed out a string in one line. Using PHP normally, you would need to perform this in two lines <em>(following common coding standards)</em> and declare a variable. If this were a static method we could get it down to one line, but static methods does not solve for classes needing initial arguments.</p>

<h4>Chainability</h4>
<p>The next example demonstrates passing initial arguments in a class and printing the results after various method calls.</p> 

<sub>Figure 2. The Chain</sub>
<div class="example"><pre class="brush: php;">
echo eden('type', 'Hello World')->str_replace(' ','-')->strtolower()->substr(0, 8); //--> hello-wo

/* vs */

echo substr(strtolower(str_replace(' ', '-', 'Hello World')), 0, 8); //--> hello-wo
</pre></div>

<p><sub>Figure 2</sub> above shows that we passed <sub>Hello World</sub> into <sub>Eden_Type_String</sub> then replace spaces with a dash, lower casing and show only the first eight characters, again in one line. We can do the same with regular PHP however when another developer has to read that, they have to read it inner to outer versus left to right.</p>

<p>For both sets of code in <sub>Figure 2</sub> it's bad practice to put so much code on the same line. Our next example shows the same code as <sub>Figure 2</sub> except in a more vertical fashion.</p>

<sub>Figure 3. Vertical</sub>
<div class="example"><pre class="brush: php;">
echo eden('type', 'Hello World')
	->str_replace(' ','-')
	->strtolower()
	->substr(0, 8); //--> hello-wo

/* vs */

$string = 'Hello World';
$string = str_replace(' ', '-', $string);
$string = strtolower($string);
$string = substr($string, 0, 8);
echo $string; //--> hello-wo
</pre></div>

<p>You probably noticed when using <strong>Eden</strong>, we didn't have to create a variable. This is the same case when dealing with multiple classes. You can instantiate classes all in the same chain.</p>

<sub>Figure 4. Jumping from class to class</sub>
<div class="example"><pre class="brush: php;">
echo eden('session')				//instantiate Eden_Session class
	->start()						//start the session
	->set('name', 'developer')		//set session data
	->Eden_Type(2, 3, 4) 			//instantiate Eden_Type_Array class
	->unshift(1)
	->implode(' ');					//--> 1 2 3 4
</pre></div>

<h4>Objects as Arrays</h4>

<p>While living in an object oriented world, sometimes it's conceptually easier to think of datasets as arrays. In <strong>Eden</strong>, classes like <sub>Eden_Session</sub>, <sub>Eden_Cookie</sub>, <sub>Eden_Array</sub>, <sub>Eden_File</sub>, <sub>Eden_Folder</sub> and database models can be accesed as arrays.</p>

<sub>Figure 5. ArrayAccess</sub>
<div class="example"><pre class="brush: php;">
$session = eden('session')->start();
$session['name'] = 'Chris';
echo $_SESSION['name']; //--> Chris

$cookie = eden('cookie')->set('age', 29);
echo $cookie['age']; //--> 29

$array = eden('type', 1, 2, 4);
foreach($array as $value) {
	echo $value.' '; //-->1 2 4
}

$file = eden('file', '/some/path/to/file.txt');
echo $file[1]; //--> some

$folder = eden('folder', '/some/path/to');
$folder[] = 'folder'; 
echo $folder; //--> /some/path/to/folder

$user = eden('model')->setUserName('Chris');
echo $user['user_name']; //--> Chris
</pre></div>

<h4>Event Driven</h4>
<p>Another cool feature of <strong>Eden</strong> is the ability to call methods when an action is triggered. Applicable design for webites, server processes and the latter. All database calls and errors in <strong>Eden</strong>, for example, can invoke any custom action when triggered.</p>

<sub>Figure 6. Email Me!</sub>
<div class="example"><pre class="brush: php;">
function mailme($event, $email) {
	echo "mailing $email now";
}

$event = eden('event')->listen('error', 'mailme');
 
//... somewhere later ...
 
$event->trigger('error', 'your@email.com');
</pre></div>

<h4>Routing</h4>
<p>Routing in <strong>Eden</strong> is similar to <em>page routing</em> in typical MVC frameworks, however in this subject technically called <em>Polymorphic Routing</em>. <strong>Eden</strong> has adopted class naming conventions made popular from Zend Framework which is in relation to a <em>cascading file system</em>. One annoyance in this system is that class names can get really long. Long class names are harder to remember and ultimately increases the learning curve. Making virtual classes <em>(or aliases to class names)</em> not only makes it easier to remember, but allows developers to customize <strong>Eden</strong> in their own way.</p>

<sub>Figure 7. Virtual Classes</sub>
<div class="example"><pre class="brush: php;">
//Make an alias for Eden_Session called Session
eden('route')->getClass()->route('My', 'My_Long_Class_Name');

//... some where later in your code ...

eden()->My(); // My_Long_Class_Name
</pre></div>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	Aliasing an alias will result in both aliases pointing to the same class. 
</blockquote>

<p>In the example above, we first made an alias to <sub>My_Long_Class_Name</sub> called <sub>My</sub>. After that line, anytime that alias is called <strong>Eden</strong> will know to instantiate <sub>My_Long_Class_Name</sub> instead. This inherently also solves for a major flaw in CMS and framework design which we will get into in <a href="/documentation/library/classes">2. Classes</a> later. For now let's work with <strong>Virtual Methods</strong>.</p>

<sub>Figure 8. Virtual Methods</sub>
<div class="example"><pre class="brush: php;">
//Make an alias for Eden_Tool->output called Eden->out
eden('route')->getMethod()->route('Eden', 'out', 'Eden_Tool', 'output');

//... some where later in your code ...

eden()->out('This method doesn\'t really exist'); //--> This method doesn't really exist
</pre></div>

<p>In <sub>Figure 8</sub> above, we show how to make an alias for <sub>Eden_Tool->output()</sub> called <sub>Eden->out()</sub> and then calling that virtual method.</p>

<blockquote class="warning clearfix">
	<span class="icon"></span>
	If there was a previously defined method called <em>Eden->out()</em> this method would be called instead.
</blockquote>

<blockquote class="warning clearfix">
	<span class="icon"></span>
	Aliasing methods only work for classes that do not require inital arguments. <em>Eden_Tool</em> for example does not require inital arguments.
</blockquote>

<p>If we combine <sub>Figure 7</sub> and <sub>Figure 8</sub>, it is possible to make virtual methods for virtual classes.</p>

<sub>Figure 9. Virtual Class + Virtual Methods</sub>
<div class="example"><pre class="brush: php;">
//Make an alias for Eden_Session called Session
//Make an alias for Eden_Tool->output called Session->out
eden()
	->Eden_Route_Class()
	->route('Session', 'Eden_Session')
	->Eden_Route_Method()
	->route('Session', 'out', 'Eden_Tool', 'output');

//... some where later in your code ...

eden()->Session()->out('This class and method doesn\'t really exist'); 
	//--> This class and method doesn't really exist
</pre></div>

<blockquote class="note">
	<h5>Author Note</h5>
	<span><strong>Eden</strong> uses the class naming convention we talked about earlier to determine if a method call is actually a class call. This inherently enforces proper naming conventions to classes and methods. Please see: <a href="/documentation/standards">Annex: 1. Coding Standards</a> for more information.</span>
</blockquote>

<h4>Summary</h4>
<p>We just covered some of the major features of <strong>Eden's</strong> core. Given the above knowledge, we open doors to more possibilities while changing the way we write code. It's important to know that all of <strong>Eden's</strong> classes can still be instantiated the traditional way. We wanted <strong>Eden</strong> to cover the interests of both novice and experienced developer, so depending on your understanding of PHP, either way is applicable. Head over to <a href="/documentation/library/classes">2. Classes</a> when you are ready to write your first class in <strong>Eden</strong>!</p>

<a class="prev" href="/documentation/library">&laquo; I. The Library </a>
<a class="next" href="/documentation/library/classes">2. Classes &raquo;</a>