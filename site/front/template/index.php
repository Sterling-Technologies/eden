<div class="two-column-layout column-layout clearfix">
	<div class="column-1 column"><?php include(dirname(__FILE__).'/_menu.php'); ?></div>
	<div class="column-2 column">
		<a class="next" href="/documentation/start">1. Quick Start &raquo;</a>
		<h3>What is Eden?</h3>
		
		<p><strong>Eden</strong> is a PHP Library maintained by <a href="http://openovate.com/" target="_blank">Openovate Labs</a>. We use <strong>Eden</strong> as a foundation for all of our internal product development, which in turn keeps her code base updated, evolving and constantly expanding. <strong>Eden</strong> is classified as a library <em>(versus a CMS or Framework)</em> because her only ambition is to make functionality available rather than make rules for how a website is created. This makes learning <strong>Eden</strong> easier because you only need to learn the classes you plan to use.</p>
		
		<blockquote class="warning clearfix">
			<span class="icon"></span>
			Eden is not specifically designed for building websites by design. Technically, you can use Eden as a compliment anywhere you were planning to use PHP in your project.
		</blockquote>
		
		<p>The library is separated into different sections covering databases, caching, file system, persistent data, etc. which is common in most frameworks, but <strong>Eden</strong> also covers web services, payment gateways, shipping and cloud technologies out of the box.</p>
		
		<h5>What's Out of the Box:</h5>
		<ul class="three-column">
			<li><a href="/documentation/library/mysql">MySQL</a></li>
			<li><a href="/documentation/library/sqlite">SQLite</a></li>
			<li><a href="/documentation/library/posgres">PosgreSQL</a></li>
			<li><a href="/documentation/library/mongo">MongoDB</a> (IN DEV)</li>
			<li><a href="/documentation/library/memcache">Memcache</a></li>
			<li><a href="/documentation/library/apc">APC</a></li>
			<li><a href="/documentation/library/mailing/imap">IMAP</a></li>
			<li><a href="/documentation/library/mailing/smtp">SMTP</a></li>
			<li><a href="/documentation/library/mailing/pop3">POP3</a></li>
			<li><a href="/documentation/library/google/calendar">Google Calendar</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/docs">Google Docs</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/gmail">Gmail</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/contacts">Google Contacts</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/maps">Google Maps</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/plus">Google+</a> (IN DEV)</li>
			<li><a href="/documentation/library/google/shortner">Google Shortner</a></li>
			<li><a href="/documentation/library/facebook">Facebook</a></li>
			<li><a href="/documentation/library/twitter">Twitter</a> (IN DEV)</li>
			<li><a href="/documentation/library/tumbler">Tumbler</a> (IN DEV)</li>
			<li><a href="/documentation/library/getsatisfaction">Get Satisfaction</a></li>
			<li><a href="/documentation/library/eventbrite">Eventbrite</a></li>
			<li><a href="/documentation/library/webcharge">Web Charge</a> (IN DEV)</li>
			<li><a href="/documentation/library/paypal">Paypal</a></li>
			<li><a href="/documentation/library/authorizenet">Authorize.net</a> (IN DEV)</li>
			<li><a href="/documentation/library/lbc">LBC</a> (IN DEV)</li>
			<li><a href="/documentation/library/fedex">FedEx</a> (IN DEV)</li>
			<li><a href="/documentation/library/ups">UPS</a> (IN DEV)</li>
			<li><a href="/documentation/library/dhl">DHL</a> (IN DEV)</li>
			<li><a href="/documentation/library/xend">Xend</a></li>
			<li><a href="/documentation/library/amazon">Amazon EC2 &amp; S3</a> (ADDING EC2)</li>
			<li><a href="/documentation/library/jabber">Jabber</a></li>
		</ul>
		
		<p>Although <strong>Eden</strong> support the above services, it's not enough to say it works. We focus on <em>end developer</em> usage; getting results or performing actions with less code. <sub>Figure 1</sub>, for example, shows how easy it is to get your <strong>Facebook</strong> friends.</p>
		
		<sub>Figure 1. Get a Pure Array of Facebook Friends</sub>
		<div class="example"><pre class="brush: php;">
		$friends = eden('facebook')->graph('[YOUR ACCESS TOKEN]')->getFriends();
		</pre></div>
		
		<p>On a core level, <strong>Eden</strong> is designed to be a game changer, from writing code to new concepts, more things are possible. To learn more about the features of <strong>Eden</strong> in detail, head over to <a href="/documentation/library/features">1. Features</a></p> 
		
		<a class="next" href="/documentation/start">1. Quick Start &raquo;</a>

	</div>
</div>