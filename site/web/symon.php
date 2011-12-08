<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require dirname(__FILE__).'/../front.php';

/* Get Application
-------------------------------*/
front()

/* Set Debug
-------------------------------*/
->setDebug(E_ALL, true)

/* Set Autoload
-------------------------------*/
->addRoot(dirname(__FILE__).'/..')
->addRoot(dirname(__FILE__).'/../model')

/* Set Class Routing
-------------------------------*/
->setClasses('../front/config/classes.php')

/* Set Method Routing
-------------------------------*/
->setMethods('../front/config/methods.php')

/* Set Paths
-------------------------------*/
->setPaths();

///////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

$tweets = front()->Eden_Twitter_Timelines('xm8mraLDw2mgA1b2SKAaA','dpUyjXhxSbO3inhlqX5DaSPlLsfV2gwMaEKaSQ0WKns');

echo 'GET <pre>'.print_r($_GET, true).'</pre>';
echo 'SESSION <pre>'.print_r($_SESSION, true).'</pre>';

//if user wants to logout
if(isset($_GET['logout'])) {
	//log them out
	unset($_SESSION['request_token'], $_SESSION['request_token_secret'], $_SESSION['access_token'], $_SESSION['access_token_secret']);
	header('Location: /symon.php');
}

//if the user is logged in
if(isset($_SESSION['access_token'], $_SESSION['access_token_secret'])) {
	//lets do shit
	//ACCOUNTS
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->updateColor();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->updateBackground();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->updateProfile('sy buenavista','openovate.com','carmona','small');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->logOut();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getCredentials();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getLimit();
	//LIST
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getStatus();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getList(297169759);
	//FAVORITES
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->removeFavorite(139245530340532224);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->addFavorite(139245530340532224);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getList('sy');
	//SUGGESTIONS
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getRecentStatus('philippines');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getCategory('taylorswift13');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getSuggestion();
	//USERS
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getContributors(17919972,'taylorswift13');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getDetail('taylorswift13');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->search('taylorswift13');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getProfileImage('iamsuperbianca');
	//SEARCH
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->search('test');
	//TIMELINES
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getByUser('sy');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getToUser('symon','sy');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getList('Qginalyn');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getOf(3);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getTo(3);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getBy(3);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getPublic();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getMention(5);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getTimeline(5);
	//
	//DIRECTMESSAGE
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getSent();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getSent();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->newMessage('sdaas','sybuena2')
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->remove(138532788428226560);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getList('kamoteche','cblanquera');
	//tweets
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getWhoRetweetedIds(139161266102079488);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getRetweets(139161266102079488);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->remove(138542385809469440);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->retweet(138558867679354880);
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->update('test api again');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getDetail(138507381846970369);
	//FRIENDS
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getNoRetweets();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->update('XianLimm');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getDetail('symon','sy');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getFollowers('sy');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->incomingFriends();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->outgoingFriends();
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->friendsExist('kamoteche','cblanquera');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getFriends('kamoteche');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->unfollowFriends('iamjohnprats');
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->followFriends('iamjohnprats');
	
	
	
	/*
	$timeline = array();
	
	//get tweets
	$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getPublic();
	print_r($response);
	//set default timezone to america/los angeles
	date_default_timezone_set('America/Los_Angeles');
	//for each tweet
	foreach($response as $tweet) {
		//get the unix time this item was created
		$time = strtotime($tweet['created_at']);
		//mark item as twitter
		$tweet['social_media'] = 'twitter';
		//put this item in our global timeline
		$timeline[$time] = $tweet;
	}
	
	//get tumblr list
	//for each tumblr
		//get the unix time this item was created
		//mark item as tumblr
		//put this item in our global timeline
	
	//get facebook list
	//for each facebook
		//get the unix time this item was created
		//mark item as facebook
		//put this item in our global timeline
	
	krsort($timeline);
	
	?>
	
	------------------!!!!!!!!!!!!!!!!!!!!!!!!!!!!----------------------</br>
	<?php foreach($timeline as $item): ?>
	<?php if($item['social_media'] == 'twitter'): ?>
	<span class="date"><?php echo date('F d, Y g:iA',strtotime($item['created_at'])); ?></span></br>
	
	<p><?php echo $item['text']; ?></p></br>
	<p><?php echo $item['name']; ?></p></br>
	<?php elseif($item['social_media'] == 'tumblr'): ?>
	<?php elseif($item['social_media'] == 'facebook'): ?>
	<?php endif; ?>
	
	<?php endforeach; ?>
	
	------------------!!!!!!!!!!!!!!!!!!!!!!!!!!!!----------------------
	*/
	
	//print_r($response);
	//print_r($tweets->getMeta());

//if the user just authorized us
} else if(isset($_GET['oauth_token'])) {
	//upgrade one time access token to another access token that will last for 1 hour
	$token = $tweets->getAccessToken($_GET['oauth_token'], $_SESSION['request_token_secret']);
	
	//store this upgraded access token in our user session
	$_SESSION['access_token'] 			= $token['oauth_token'];
	$_SESSION['access_token_secret'] 	= $token['oauth_token_secret'];
	
	//redirect
	header('Location: /symon.php');

//the user at this point is logged out
} else {
	//get the request token
	$token = $tweets->getRequestToken();
	$_SESSION['request_token'] 			= $token['oauth_token'];
	$_SESSION['request_token_secret'] 	= $token['oauth_token_secret'];
	
	//prompt user to login
	echo '<a href="'.$tweets->getLoginUrl($token['oauth_token'], 'http://eden.openovate.com/symon.php').'">Login</a>';
}


////////////////////////////////////////////////////////////////////

$tumblr = front()->Eden_Tumblr_User('49Sb8LrxMKh4lErDN69yp6VwgCmOffYgOrigEMgM2wwvELx6Ew',
									'akHvmf5Fsoo7U9ztx3triIx2mczWfze3SEgIgaiGBYTlkqD0kN');
$tumblrBlog = front()->Eden_Tumblr_Blog('49Sb8LrxMKh4lErDN69yp6VwgCmOffYgOrigEMgM2wwvELx6Ew',
									'akHvmf5Fsoo7U9ztx3triIx2mczWfze3SEgIgaiGBYTlkqD0kN');

echo 'GET <pre>'.print_r($_GET, true).'</pre>';
echo 'SESSION <pre>'.print_r($_SESSION, true).'</pre>';

//if user wants to logout
if(isset($_GET['logout'])) {
	//log them out
	unset($_SESSION['request_token'], $_SESSION['request_token_secret'], $_SESSION['access_token'], $_SESSION['access_token_secret']);
	header('Location: /symon.php');
}

//if the user is logged in
if(isset($_SESSION['access_token'], $_SESSION['access_token_secret'])) {
	//lets do shit

	//set timezone
	date_default_timezone_set('America/Los_Angeles');
	$timeline = array();
	
	//get Tweets//////////////////////////////////////////////////////////////////////////////////////////////
	$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getPublic();
	//print_r($response);
	//for each tweet
	foreach($response as $tweet) {
		//get the unix time this item was created
		$time = strtotime($tweet['created_at']);
		//mark item as twitter
		$tweet['social_media'] = 'twitter';
		//put this item in our global timeline
		$timeline[$time] = $tweet;
	}
	
	//get Tumblr list/////////////////////////////////////////////////////////////////////////////////////////
	$response = $tumblr->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getUser();
	//get Tumblr Avatar
	//$avatar = $tumblrBlog->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->getAvatar();
	//for each tumblr
	foreach($response['response']['posts'] as $tumbler) { 
		//get the unix time this item was created
		$time = strtotime($tumbler['date']);
		//mark item as tumbler
		$tumbler['social_media'] = 'tumblr';
		//put this item in our global timeline
		$timeline[$time] = $tumbler;
	}
	
	//sort the date by the latest post to the older
	krsort($timeline);
	?>
	
<center>
	
	<?php foreach($timeline as $item): ?>
		
		<?php if($item['social_media'] == 'tumblr'): ?>
			</br>_____________________________TUMBLR.COM_____________________________</br>
			<span class="date"><?php echo 'posted last: '.date('F d, Y g:iA',strtotime($item['date'])); ?></span>
			<p><?php echo $item['blog_name']; ?></p>
			
			<?php if(isset($item['caption'])): ?>
				<p><?php echo $item['caption']; ?></p>
			<?php endif; ?>
			
			<?php if(isset($item['body'])): ?>
				<p><?php echo $item['body']; ?></p>
			<?php endif; ?>
			
		<?php elseif($item['social_media'] == 'twitter'): ?>
			</br>______________________________TWITTER.COM_______________________</br>
			<span class="date"><?php echo 'posted last: '.date('F d, Y g:iA',strtotime($item['created_at'])); ?></span></br>
			<?php echo $item['text']; ?></p>
			<?php if(isset($item['user']['profile_image_url'])): ?>
				<p><?php echo '<img src ="'.$item['user']['profile_image_url'].'" >'; ?>
			<?php endif; ?>

			
			<?php endif; ?>
			
		<?php //elseif($item['social_media'] == 'facebook'): ?>
		
		
	<?php endforeach; ?>
		
</center>

	
	<?php
	
	
	//front()->output($response);
	//echo ""; print_r($response); echo "";
	//print_r($response);
	//print_r($tumblr->getMeta());

//if the user just authorized us
} else if(isset($_GET['oauth_token'])) {
	//upgrade one time access token to another access token that will last for 1 hour
	$token = $tumblr->getAccessToken($_GET['oauth_token'], $_SESSION['request_token_secret'],$_GET['oauth_verifier']);
	
	//store this upgraded access token in our user session
	$_SESSION['access_token'] 			= $token['oauth_token'];
	$_SESSION['access_token_secret'] 	= $token['oauth_token_secret'];
	
	//redirect
	header('Location: http://eden.openovate.com/symon.php');

//the user at this point is logged out
} else {
	//get the request token
	
	$token = $tumblr->getRequestToken();
	$_SESSION['request_token'] 			= $token['oauth_token'];
	$_SESSION['request_token_secret'] 	= $token['oauth_token_secret'];
	
	//prompt user to login
	echo '<a href="'.$tumblr->getLoginUrl($token['oauth_token'], 'http://eden.openovate.com/symon.php').'">Login</a>';
}

///////////////////////////////////////////////////
/*
$satisfaction = front()->Eden_GetSatisfaction_Topic('ml57owkz0dl8',
									'0uoub6rt8tx5tks7m76jln31sc4f98vh');

echo 'GET <pre>'.print_r($_GET, true).'</pre>';
echo 'SESSION <pre>'.print_r($_SESSION, true).'</pre>';

//if user wants to logout
if(isset($_GET['logout'])) {
	//log them out
	unset($_SESSION['request_token'], $_SESSION['request_token_secret'], $_SESSION['access_token'], $_SESSION['access_token_secret']);
	header('Location: /symon.php');
}

//if the user is logged in
if(isset($_SESSION['access_token'], $_SESSION['access_token_secret'])) {
	//lets do shit
	//ACCOUNTS
	//$response = $tweets->setAccessToken($_SESSION['access_token'], $_SESSION['access_token_secret'])->updateColor();
	
	print_r($response);
	print_r($satisfaction->getMeta());

//if the user just authorized us
} else if(isset($_GET['oauth_token'])) {
	//upgrade one time access token to another access token that will last for 1 hour
	$token = $satisfaction->getAccessToken($_GET['oauth_token'], $_SESSION['request_token_secret']);
	
	//store this upgraded access token in our user session
	$_SESSION['access_token'] 			= $token['oauth_token'];
	$_SESSION['access_token_secret'] 	= $token['oauth_token_secret'];
	
	//redirect
	header('Location: /symon.php');

//the user at this point is logged out
} else {
	//get the request token
	$token = $satisfaction->getRequestToken();
	$_SESSION['request_token'] 			= $token['oauth_token'];
	$_SESSION['request_token_secret'] 	= $token['oauth_token_secret'];
	
	//prompt user to login
	echo '<a href="'.$satisfaction->getLoginUrl($token['oauth_token'], 'http://eden.openovate.com/symon.php').'">Login</a>';
}
*/

///////////////////////////////////////////

?>