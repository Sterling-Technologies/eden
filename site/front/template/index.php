<style>
.banner { 
	margin-bottom: 10px;
	margin-top: -19px; 
	position: relative;
}
.banner form {
	position: absolute;
	bottom: 80px;
	left: 250px;
}
.boxes img { 
	float: right;
	margin: 10px; 
} 
.boxes h3 { 
	color: #DF0000;
	font-size: 20px; 
}
.boxes em { 
	color: #5F6D90;
	display: block;
	font-size: 14px;
	font-style: normal;
}

.boxes .column-2 .column-wrapper {
	border-left: 1px dashed #999999;
	border-right: 1px dashed #999999;
	padding-bottom: 0;
}

</style>
<div class="banner">
	<img width="100%" src="/assets/images/banner.jpg" />
	<form method="post" action="/download">
		<input name="download" type="image" src="/assets/images/download.png" class="submit download" value="Download" />
	</form>
</div>
<div class="three-column-layout column-layout boxes clearfix">
	<div class="column-1 column">
		<div class="column-wrapper">
		<h3>Web Services</h3>
		<em>Out of the box</em>
		<img src="/assets/images/box-1.png" />
		<p>The library is separated into different sections covering databases, i18n, file system, etc. 
		which is common in most frameworks, but Eden also covers web services, payment gateways, shipping 
		and cloud technologies out of the box.</p>
		</div>
	</div>
	<div class="column-2 column">
		<div class="column-wrapper">
		<h3>Simple Interface</h3>
		<em>Small Learning Curve</em>
		<img src="/assets/images/box-2.png" />
		<p>It's not enough to say Eden works. We focus on end developer usage; getting results or performing 
		actions with less code. We challenge PHP beginners to see if they can make sense of Eden within 3 hours!</p>
		</div>
	</div>
	<div class="column-3 column">
		<div class="column-wrapper">
		<h3>Rapid Prototyping</h3>
		<em>Getter done, faster.</em>
		<img src="/assets/images/box-3.png" />
		<p>Eden is designed for rapidly producing sites with minimal effort. There are no rules to building a site with Eden.
		Just do what you know and use Eden to help you get it done faster.</p>
		</div>
	</div>
</div>