<a class="prev" href="/documentation/library/features">&laquo; 1. Features</a>
<a class="next" href="/documentation/library/autoloading">3. Autoloading &raquo;</a>

<h3>2. Writing Classes</h3>

<p>We turn writing classes in <strong>Eden</strong> into an exciting experience. There are basically two requirements to integrate your class and to begin harnessing the power of <strong>Eden</strong>.</p>

<ol>
	<li>Extend your class with Eden_Class</li>
	<li>Create a public static function called <strong>i</strong></li>
</ol>

<blockquote class="note">
	<h5>Author Note</h5>
	<span>In PHP 5.2.6, we couldn't find a way around not needing the <em>i</em> method. Every class in <strong>Eden</strong> has the <em>i</em> method to determine if we should load the class as a singleton or not, so as an <em>end developer</em>, you wouldn't need to care.</span>
</blockquote>

<sub>Figure 1. Defining a Class</sub>
<div class="example"><pre class="brush: php;">
class My_Session extends Eden_Class {
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}	
}
</pre></div>

<p>The above example shows how the requirements would look like in our new class. You'll notice we used a static method called <sub>self::_getSingleton</sub>. This tells <strong>Eden</strong> to instantiate this class for the first time and next time, return that same instance. For multiple instances you could use <sub>self::_getMultiple</sub>. Either one you use will &quot;automagically&quot; call <sub>__construct</sub>. We can then instantiate our new class shown in <sub>Figure 2</sub>.</p>

<sub>Figure 2. Instantiating our class</sub>
<div class="example"><pre class="brush: php;">
echo eden()->My_Session(); //--> My_Session
</pre></div>

<p>When we instantiate our class we now have the option of using <sub>eden()</sub> like our other examples. You can also use <sub>new My_Session</sub> or <sub>My_Session::i()</sub> to instantiate this class. Passing arguments to a constructor can be achieved like in <sub>Figure 3</sub>.</p>

<sub>Figure 3. Passing arguments to the constructor</sub>
<div class="example"><pre class="brush: php;">
class My_Session extends Eden_Class {
	public static function i($name, $age) {
		return self::_getSingleton(__CLASS__, $name, $age);
	}	
	
	public function __construct($name, $age) {}
}

echo eden()->My_Session('Chris', 29); //--> My_Session
</pre></div>

<p>Now that we have a class, let's build a method called <sub>start()</sub> which demonstrates calling other methods in <strong>Eden</strong>.</p>

<sub>Figure 4. The power of <em>$this</em></sub>
<div class="example"><pre class="brush: php;">
class My_Session extends Eden_Class {
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function start() {
		echo 'Starting Session ...';
		
		//get the session id
		$session = $this->Eden_Session()->start()->getId();
		
		//store session id in cookie
		$this->Eden_Cookie()->set('session_id', $session);
		
		return $this;
	}
}

eden()->My_Session()->start(); //--> Starting Session ...
</pre></div>

<p>So we made our <sub>start()</sub> echo a string, start a PHP session and store the session ID in a cookie. You'll notice in our start method that we can use <sub>$this</sub> instead of <sub>eden()</sub> to call any other class extended with <sub>Eden_Class</sub>.</p>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	It's good practice, when defining our methods to return <em>$this</em> instead of nothing. This allows our class to call other methods or classes without leaving the chain <em>(chainability)</em>.
</blockquote>

<h4>Extending Classes</h4>

<p>All classes in <strong>Eden</strong> can be extended naturally with PHP. In our <sub>My_Session</sub> example, it would probably be better to extend it with <sub>Eden_Session</sub> to inherit the rest of <sub>Eden_Session's</sub> methods. <sub>Figure 5</sub> shows us us how we can do that.</p>

<sub>Figure 5. Extending a class</sub>
<div class="example"><pre class="brush: php;">
class My_Session extends Eden_Session {
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function start() {
		echo 'Starting Session ...<br />';
		
		//get the session id
		$session = parent::start()->getId();
		
		//store session id in cookie
		$this->Eden_Cookie()->set('session_id', $session);
		
		return $this;
	}
}

echo eden()
	->My_Session()
	->start() //--> Starting Session ...
	->getId(); //--> [SOME SESSION ID]
</pre></div>

<p>So great, now <sub>My_Session</sub> becomes more of a useful class with the help of <sub>$this</sub>, chainability and extending. A common problem is that, previously defined code calling <sub>Eden_Session</sub> will still be calling <sub>Eden_Session</sub>. There maybe a case we may want all code to use <em>My_Session</em> instead.</p>

<blockquote class="error">
	<h5>Scenario 1</h5>
	<span>We would like to make a plugin for other developers using <strong>Eden</strong> that sends an email everytime a new session is started. In other developers code, they may already be using <em>Eden_Session</em>. We would either need to rewrite <em>Eden_Session</em> for everyone that uses your plugin <em>(which is a no no..)</em> <br />or tell them to change their code to use <em>My_Session</em> instead.</span>
	<h5>Scenario 2</h5>
	<span>You would like to modify a plugin that uses <em>Eden_Session</em> to use <em>My_Session</em> instead.</span>
</blockquote>

<p>In both scenarios it's bad practice to directly modify someone else's code, especially if it's regularly updated because there's a likely chance your changes will conflict with theirs. This is a more common problem with all PHP frameworks, CMS', plugins etc., but with <strong>Eden</strong> as the core of our application, the problem becomes trivial. The following example shows how we can solve both scenarios.</p>

<sub>Figure 6. Solution: Back to the Router</sub>
<div class="example"><pre class="brush: php;">
//Everytime Eden_Session is called, call My_Session instead
eden()->Eden_Route()->routeClass('Eden_Session', 'My_Session');

//Example of calling Eden_Session
eden()->Eden_Session()->start(); //--> Starting Session ...

Eden_Session::i()->start(); //--> Starting Session ...
</pre></div>

<blockquote class="note">
	<h5>Authors Note</h5>
	<span>This scenario is one of the reasons we shy away from saying <em>new Eden_Session</em> in our library.</span>
</blockquote>

<h4>Summary</h4>
<p>It's not too difficult to start programming in <strong>Eden</strong>. If you start following our style of programming you'll notice your code to be more readable overall because we can eliminate the need of <sub>::</sub>, <sub>new</sub> and reduce the amount of variables you consume by chaining. In our next sections we will be talking about more intermediate subjects and complete features in detail. Although experimenting with writing classes in <strong>Eden</strong> will entertain you for sometime, head over to <a href="/documentation/library/autoloading">3. Autoloading</a> whenever your ready!</p>

<a class="prev" href="/documentation/library/features">&laquo; 1. Features</a>
<a class="next" href="/documentation/library/autoloading">3. Autoloading &raquo;</a>