<?php
//Application Configurations
$app_id		= trim($results->fb_id);
$app_secret	= trim($results->fb_secret);
$site_url	= get_permalink($data->postID);

try{
	include_once "src/facebookWI.php";
}catch(Exception $e){
	error_log($e);
}
// Create our application instance
$facebook = new Facebook_WI(array(
	'appId'		=> $app_id,
	'secret'	=> $app_secret,
));

// Get User ID
$user = $facebook->getUser();
// Delete FB Connect
// $facebook->deleteSharedSessionCookie();

// We may or may not have this data based 
// on whether the user is logged in.
// If we have a $user id here, it means we know 
// the user is logged into
// Facebook, but we don�t know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if($user){
//==================== Single query method ======================================
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		// Already Logged
	}catch(FacebookApiExceptionWI $e){
		error_log($e);
		$user = NULL;
	}
//==================== Single query method ends =================================
}

if($user){
	// Get logout URL
	$logoutUrl = $facebook->getLogoutUrl();
}else{
	// Get login URL
	$loginUrl = $facebook->getLoginUrl(array(
		'scope'			=> 'email',//'user_birthday',
		'redirect_uri'	=> $site_url
	));

}

if($user){
	// Proceed knowing you have a logged in user who has a valid session.
	
//========= Batch requests over the Facebook Graph API using the PHP-SDK ========
	// Save your method calls into an array
	$queries = array(
		array('method' => 'GET', 'relative_url' => '/'.$user),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/home?limit=50'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/friends'),
		array('method' => 'GET', 'relative_url' => '/'.$user.'/photos?limit=6'),
		);

	// POST your queries to the batch endpoint on the graph.
	try{
		$batchResponse = $facebook->api('?batch='.json_encode($queries), 'POST');
	}catch(Exception $o){
		error_log($o);
	}

	//Return values are indexed in order of the original array, content is in ['body'] as a JSON
	//string. Decode for use as a PHP array.
	$user_info	= json_decode($batchResponse[0]['body'], TRUE);

}
?>