<?php
/*
	Auth with Google
*/
require_once 'global.inc.php'; 
require_once 'libs/Google/autoload.php';
session_start();

$client_id = GLOGIN_CLIENT_ID;
$client_secret = GLOGIN_CLIENT_SECRET;
$redirect_uri = BASE_URL.'/auth-google.php';


$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);



  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


if (isset($authUrl)){ 
	
	header("Location: $authUrl");
	
} else {

	$google_user = $service->userinfo->get();
	///check if the user exist
	$user = $db->select("users","(email = '$google_user->email' OR google_id = $google_user->id)");
	$userid = $user[0]["id"];


	if (isset($user[0])) {
		//login the user
			$data = array( 
				"google_id" => "'$google_user->id'", 
				"google_link" => "'$google_user->link'", 
				"google_picture" => "'$google_user->picture'"
		    );
        	$db->update($data, "users", "id = $userid"); 			        			
			$userTools->login($user[0]["email"], "NWLXCDxPHEM8AANvYxuC5DWS");
			header("Location: index");

	}else{
		//register the new user
			$passmd5 = md5("NWLXCDxPHEM8AANvYxuC5DWS");
			$data = array( 
		        "name" => "'$google_user->name'", 
		        "level" => 2, 
		        "password" => "'$passmd5'", 
		        "email" => "'$google_user->email'", 
		        "join_date" => "'".date("Y-m-d H:i:s",time())."'",
		        "google_id" => "'$google_user->id'", 
		        "google_link" => "'$google_user->link'", 
		        "google_picture" => "'$google_user->picture'"
	      	);
	      	$db->insert($data, "users"); 
	      	//login to dashboard
	      	$userTools->login($google_user->email, "NWLXCDxPHEM8AANvYxuC5DWS");
			header("Location: index");  
	}

}



?>

