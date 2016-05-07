<?php
/*
  Auth with Facebook
*/
require_once 'global.inc.php'; 
require_once 'libs/autoload.php';
session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;



FacebookSession::setDefaultApplication(FLOGIN_APP_ID, FLOGIN_APP_SECRET);
    $theurl = BASE_URL."/auth-facebook";
    $helper = new FacebookRedirectLoginHelper($theurl);
    $scope = array('email');
try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookSDKException $e) {
  $session = null;
}

if ($session) {
  
    $request = new FacebookRequest($session, 'GET', '/me?fields=id,name,email,picture,link');
    $me = $request->execute()->getGraphObject()->asArray();

    ///check if the user exist
    $fbid = $me["id"];
    $email = $me["email"];
    $name = $me["name"];
    $picture = $me["picture"]->data->url;
    $link = $me["link"];

    $user = $db->select("users","(facebook_id = '$fbid' OR email = '$email')");
    $userid = $user[0]["id"];

    if (isset($user[0])) {
      //login the user
      $userTools->login($user[0]["email"], "NWLXCDxPHEM8AANvYxuC5DWS");
      $data = array( 
              "facebook_id" => "'$fbid'", 
              "facebook_link" => "'$link'", 
              "facebook_picture" => "'$picture'"
      );
      $db->update($data, "users", "id = $userid");        
      header("Location: index");  
    }else{
      //register the new user
         //register
        $passmd5 = md5("NWLXCDxPHEM8AANvYxuC5DWS");
        $data = array( 
              "name" => "'$name'", 
              "level" => 2, 
              "password" => "'$passmd5'", 
              "email" => "'$email'", 
              "join_date" => "'".date("Y-m-d H:i:s",time())."'",
              "facebook_id" => "'$fbid'", 
              "facebook_link" => "'$link'", 
              "facebook_picture" => "'$picture'"
            );
        $db->insert($data, "users"); 
        $userTools->login($email, "NWLXCDxPHEM8AANvYxuC5DWS");
        header("Location: index");  
    }    
} else {
  
  $url = $helper->getLoginUrl($scope);
  header("Location: $url");

}
?>