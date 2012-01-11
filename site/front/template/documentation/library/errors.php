<a class="prev" href="/documentation/library/autoloading">&laquo; 3. Autoloading</a>
<a class="next" href="/documentation/library/types">5. Data Types &raquo;</a>

<h3>4. Error Handling</h3>

<p>Eden offers a robust error handling solution which is event driven, offers dynamic messaging and can easily be integrated in your application. To prevent conflicts with other libraries, error handling in <strong>Eden</strong> by default is turned off. To turn on error handling for both errors and exceptions we follow the example below.</p>

<sub>Figure 1. Turn on Custom Error Handling</sub>
<div class="example"><pre class="brush: php;">
eden()->Eden_Error_Event()
	->setReporting(E_ALL)
	->setErrorHandler()
	->setExceptionHandler()
	->listen('error', 'error')
	->listen('exception', 'error');
</pre></div>	

<p>In <sub>Figure 1</sub>, with <sub>setReporting()</sub>, we first set error reporting to <sub>E_ALL</sub> because some servers have this PHP setting turned off by default. We next register our event handler using <sub>setErrorHandler()</sub> and <sub>setExceptionHandler()</sub> to be called when an error or exception happens. Lastly, we start listening for errors and exceptions with <sub>listen</sub> and when one is triggered to call <sub>error()</sub>. Before we can test if this works we need to create an error handler callback called <sub>error()</sub>. <sub>Figure 2</sub> will demonstrate building a quick and easy one.</p>

<sub>Figure 2. Make an Error Handler</sub>
<div class="example"><pre class="brush: php;">	
function error($event, $type, $level, $class, $file, $line, $message) {
	$template = '%s %s from %s in %s on line %s. Eden Says: %s';
	
	echo sprintf($template, $type, $level, $class, $file, $line, $message);
}
</pre></div>

<p>Now let's purposely invoke a PHP warning as in <sub>Figure 3</sub>.</p>

<sub>Figure 3. Cause an Warning</sub>
<div class="example"><pre class="brush: php;">
function warning_in_me() {
	REDS;
}

warning_in_me();
</pre></div>

<blockquote class="error clearfix">
	<span class="icon"></span>
	PHP WARNING from warning_in_me() in /eden/web/test.php on line 18. Eden Says: Use of undefined constant REDS - assumed 'REDS'
</blockquote>

<h4>Back Trace</h4>

<p>In our last example we made the error output in a user understandable format. Some other things we can do with errors are send emails. create logs, i18n etc., but we will leave that for another tutorial. Sometimes when working with multiple files we'd like to know where the problem started and a history of events leading up to the error. This is where adding a <em>backtrace</em> can help. In <sub>Figure 4</sub> we add on history to our error function.</p>

<sub>Figure 4. Adding Trace</sub>
<div class="example"><pre class="brush: php;">	
function error($event, $type, $level, $class, $file, $line, $message, $trace, $offset) {
	$history = array();
	for(; isset($trace[$offset]); $offset++) {
		$row = $trace[$offset];
		
		//lets formulate the method
		$method = $row['function'].'()';
		if(isset($row['class'])) {
			$method = $row['class'].'->'.$method;
		}
		
		$rowLine = isset($row['line']) ? $row['line'] : 'N/A';
		$rowFile = isset($row['file']) ? $row['file'] : 'Virtual Call';
		
		//add to history
		$history[] = array($method, $rowFile, $rowLine);
	}
	
	echo Eden_Template::i()
		->setData('history', $history)
		->setData('type', $type)
		->setData('level', $level)
		->setData('class', $class)
		->setData('file', $file)
		->setData('line', $line)
		->setData('message', $message)
		->parsePhp(dirname(__FILE__).'/template.php');
}
</pre></div>

<p><strong>Eden's</strong> error handler actually gives us 10 arguments when an error is triggered. We left <sub>$trace</sub> and <sub>$offset</sub> out of <sub>Figure 2</sub> because it wasn't important at the time. What we added in our new <sub>error()</sub> function is a loop that formats each row in our <em>back trace</em> and outputing using <sub>Eden_Template</sub> instead.</p>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	We cover more about <strong>Eden_Template</strong> in <a href="/libraries/templating">9. Templating</a>
</blockquote>

<p>What we need to know about <sub>Eden_Template</sub> now is that we are setting PHP variables up using <sub>setData()</sub> for use in our PHP template file called <sub>template.php</sub>. Before we can see this in our browser, we first need to create a file called <sub>template.php</sub> in the same location we are testing error handling <em>(test.php)</em>.</p>

<sub>Figure 5. Writing the template file <em>(template.php)</em></sub>
<div class="example"><pre class="brush: php;">
&lt;p&gt;
	&lt;strong&gt;&lt;?php echo $type; ?&gt; &lt;?php echo $level; ?&gt;&lt;/strong&gt; from 
	&lt;strong&gt;&lt;?php echo $class; ?&gt;&lt;/strong&gt; in 
	&lt;strong&gt;&lt;?php echo $file; ?&gt;&lt;/strong&gt; on line 
	&lt;strong&gt;&lt;?php echo $line; ?&gt;&lt;/strong&gt;
&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Eden Says:&lt;/strong&gt; &lt;?php echo $message; ?&gt;&lt;/p&gt;
&lt;table width="100%" border="1" cellspacing="0" cellpadding="5"&gt;
&lt;?php foreach($history as $row): ?&gt;
&lt;tr&gt;
	&lt;td&gt;&lt;?php echo $row[0]; ?&gt;&lt;/td&gt;
	&lt;td&gt;&lt;?php echo $row[1]; ?&gt;(&lt;?php echo $row[2]; ?&gt;)&lt;/td&gt;
&lt;/tr&gt;
&lt;?php endforeach; ?&gt;
&lt;/table&gt;
</pre></div>

<p>Now when we load up <strong>test.php</strong> up on our browser we get something similar to the following.</p>

<blockquote class="error clearfix">
	<span class="icon"></span>
	<div>
		<p>
			<strong>PHP WARNING</strong> from 
			<strong>warning_in_me()</strong> in 
			<strong>/eden/web/test.php</strong> on line 
			<strong>41</strong>
		</p>
		<p><strong>Eden Says:</strong> Use of undefined constant REDS - assumed 'REDS'</p>
		<table width="95%" border="1" cellspacing="0" cellpadding="5">
		<tr><td>warning_in_me()</td><td>/eden/web/test.php(44)</td></tr>
		</table>
	</div>
</blockquote>

<h4>Exceptions</h4>

<p>Exception handing in <strong>Eden</strong> is about the same process as setting up errors shown in <sub>Figure 1</sub>. We leave the responsibility of explaining custom errors to <em>you</em>. A basic example of triggering errors in an <strong>Eden</strong> class is shown in <sub>Figure 6</sub>.</p>

<sub>Figure 6. Exceptions</sub>
<div class="example"><pre class="brush: php;">
class Exception_In_Me extends Eden_Class {
	
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function doSomething() {
		Eden_Error::i('You triggered an Exception.')->trigger();
	}
}

eden()->Exception_In_Me()->doSomething();
</pre></div>

<blockquote class="warning clearfix">
	<span class="icon"></span>
	<div>
	You shouldn't use <em>throw</em> as in <em>throw new Eden_Error()</em> or <em>throw Eden_Error::i()</em> because the back trace will give you more details than you need and looks like a false positive.
	</div>
</blockquote>

<p>If you load this in your browser you should see something like below.</p>

<blockquote class="error clearfix">
	<span class="icon"></span>
	<div>
		<p>
			<strong>LOGIC ERROR</strong> from 
			<strong>Eden_Error</strong> in 
			<strong>/eden/web/test.php</strong> on line 
			<strong>47</strong>
		</p>
		<p><strong>Eden Says:</strong> You triggered an Exception.</p>
		<table width="95%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td>Exception_In_Me->doSomething()</td>
			<td>/eden/web/test.php(51)</td>
		</tr>
		</table>
	</div>
</blockquote>

<p>In <strong>Eden</strong>, we introduce more settings to error handling to help categorize errors and the ability to handle different scenarios. The example below shows different settings depending on the kind of error we want to trigger.</p>

<sub>Figure 7. Custom Errors</sub>
<div class="example"><pre class="brush: php;">
class Exception_In_Me extends Eden_Class {
	
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function doSomething() {
		$this->doSomethingElse();
	}
	
	public function doSomethingElse() {
		$this->Eden_Error()
			->setMessage('%s, you triggered an Exception!')
			->addVariable('Chris')
			->setType('TESTING')
			->setLevel('EXTREME')
			->trigger();
	}
}

eden()->Exception_In_Me()->doSomething();
</pre></div>

<blockquote class="error clearfix">
	<span class="icon"></span>
	<div>
		<p>
			<strong>TESTING EXTREME</strong> from 
			<strong>Eden_Error</strong> in 
			<strong>/eden/web/test.php</strong> on line 
			<strong>56</strong>
		</p>
		<p><strong>Eden Says:</strong> Chris, you triggered an Exception!</p>
		<table width="95%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td>Exception_In_Me->doSomethingElse()</td>
			<td>/eden/web/test.php(47)</td>
		</tr>
		<tr>
			<td>Exception_In_Me->doSomething()</td>
			<td>/eden/web/test.php(60)</td>
		</tr>
		</table>
	</div>
</blockquote>

<p>In the example above we set the message into a string template, added a variable called <sub>Chris</sub> set the type to <sub>TESTING</sub> and the error level to <sub>EXTREME</sub>.</p>

<blockquote class="tip clearfix">
	<span class="icon"></span>
	<div>
	You can set the error level and error type to anything you want.
	</div>
</blockquote>

<h4>Arguments</h4>

<p>One final use of <sub>Eden_Error</sub> is its ability to test method arguments across different data types. This area seems to be lacking in PHP in general, but it's good practice to first validate arguments passed into a method before using them. <sub>Figure 8</sub> shows all the data types you can test for.</p>

<sub>Figure 8. Arguments Testing</sub>
<div class="example"><pre class="brush: php;">
class Exception_In_Me extends Eden_Class {
	
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function doSomething($string, $int, $float, $number, $bool, $null, $stringOrNull, $array, $object, $session) {
		$this->Eden_Error()
			->argument(1, 'string')
			->argument(2, 'int')
			->argument(3, 'float')
			->argument(4, 'number', 'numeric')
			->argument(5, 'bool')
			->argument(6, 'null')
			->argument(7, 'string', 'null')
			->argument(8, 'array')
			->argument(9, 'object')
			->argument(10, 'Eden_Session');
			
		echo 'Passed the argument test!';
	}
}

eden()->Exception_In_Me()->doSomething('Chris', 29, 186.5, '6', false, NULL, 'CEO', array(), new stdClass(), Eden_Session::i());
</pre></div>

<p>If you invalidate any of the passing arguments you will see something like the following.</p>
<div class="example"><pre class="brush: php;">
eden()->Exception_In_Me()->doSomething('Chris', 29, 186.5, '6', false, NULL, 85.5, array(), new stdClass(), Eden_Session::i());
</pre></div>
<blockquote class="error clearfix">
	<span class="icon"></span>
	<div>	
		<p>
			<strong>CRITICAL ERROR</strong> from 
			<strong>Eden_Error</strong> in 
			<strong>/eden/web/test.php</strong> on line 
			<strong>54</strong>
		</p>
		<p><strong>Eden Says:</strong> Argument 7 in Exception_In_Me->doSomething() was expecting string or null, however 85.5 was given.</p>
		<table width="95%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td>Eden_Error->argument()</td>
			<td>/eden/web/test.php(54)</td>
		</tr>
		<tr>
			<td>Exception_In_Me->doSomething()</td>
			<td>/eden/web/test.php(63)</td>
		</tr>
		</table>
	</div>
</blockquote>

<h4>Summary</h4>
<p>By now you should understand all the advantages with an error handler like <strong>Eden's</strong>. With <strong>Eden</strong> as a whole, not only are we making simplier code but, we can also control how strict our applications can be <em>(in other words &quot;idiot proofing&quot;)</em>. Our next section <a href="/documentation/library/types">5. Data Types</a> will show you some tricks to manipulating strings and arrays.</p>

<a class="prev" href="/documentation/library/autoloading">&laquo; 3. Autoloading</a>
<a class="next" href="/documentation/library/types">5. Data Types &raquo;</a>