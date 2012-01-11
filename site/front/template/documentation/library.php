<a class="prev" href="/documentation/start">&laquo; I. Getting Started</a>
<a class="next" href="/documentation/library/features">1. Features &raquo;</a>
<h3>II. The Library</h3>

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
	<li><a href="/documentation/library/mongo">MongoDB</a></li>
	<li><a href="/documentation/library/memcache">Memcache</a></li>
	<li><a href="/documentation/library/apc">APC</a></li>
	<li><a href="/documentation/library/mailing/imap">imap</a></li>
	<li><a href="/documentation/library/mailing/smtp">smtp</a></li>
	<li><a href="/documentation/library/mailing/pop3">pop3</a></li>
	<li><a href="/documentation/library/google/calendar">Google Calendar</a></li>
	<li><a href="/documentation/library/google/docs">Google Docs</a></li>
	<li><a href="/documentation/library/google/gmail">Gmail</a></li>
	<li><a href="/documentation/library/google/contacts">Google Contacts</a></li>
	<li><a href="/documentation/library/google/maps">Google Maps</a></li>
	<li><a href="/documentation/library/google/plus">Google+</a></li>
	<li><a href="/documentation/library/google/shortner">Google Shortner</a></li>
	<li><a href="/documentation/library/facebook">Facebook</a></li>
	<li><a href="/documentation/library/twitter">Twitter</a></li>
	<li><a href="/documentation/library/tumbler">Tumbler</a></li>
	<li><a href="/documentation/library/getsatisfaction">Get Satisfaction</a></li>
	<li><a href="/documentation/library/eventbrite">Eventbrite</a></li>
	<li><a href="/documentation/library/webcharge">Web Charge</a></li>
	<li><a href="/documentation/library/paypal">Paypal</a></li>
	<li><a href="/documentation/library/authorizenet">Authorize.net</a></li>
	<li><a href="/documentation/library/lbc">LBC</a></li>
	<li><a href="/documentation/library/fedex">FedEx</a></li>
	<li><a href="/documentation/library/ups">UPS</a></li>
	<li><a href="/documentation/library/dhl">DHL</a></li>
	<li><a href="/documentation/library/amazon">Amazon EC2 &amp; S3</a></li>
	<li><a href="/documentation/library/jabber">Jabber</a></li>
</ul>

<p>Although <strong>Eden</strong> support the above services, it's not enough to say it works. We focus on <em>end developer</em> usage; getting results or performing actions with less code. <sub>Figure 1</sub>, for example, shows how easy it is to get your <strong>Facebook</strong> friends.</p>

<sub>Figure 1. Get a Pure Array of Facebook Friends</sub>
<div class="example"><pre class="brush: php;">
$friends = eden()->Eden_Facebook()->graph('[YOUR ACCESS TOKEN]')->getFriends();
</pre></div>

<p>On a core level, <strong>Eden</strong> is designed to be a game changer, from writing code to new concepts, more things are possible. To learn more about the features of <strong>Eden</strong> in detail, head over to <a href="/documentation/library/features">1. Features</a></p> 

<a class="prev" href="/documentation/start">&laquo; I. Getting Started</a>
<a class="next" href="/documentation/library/features">1. Features &raquo;</a>
