<?php
session_start();
 
require_once 'vendor/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
 
$api_key = '2099205980363929';
$api_secret = 'f8027b5cee91e363086b4e73c228d729';
$redirect_login_url = 'https://ashdemoapp.herokuapp.com/login.php';
/ initialize your app using your key and secret
FacebookSession::setDefaultApplication($api_key, $api_secret);
 
// create a helper opject which is needed to create a login URL
// the $redirect_login_url is the page a visitor will come to after login
$helper = new FacebookRedirectLoginHelper( $redirect_login_url);
 
// First check if this is an existing PHP session
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
 // create new session from the existing PHP sesson
 $session = new FacebookSession( $_SESSION['fb_token'] );
 try {
 // validate the access_token to make sure it's still valid
 if ( !$session->validate() ) $session = null;
 } catch ( Exception $e ) {
 // catch any exceptions and set the sesson null
 $session = null;
 echo 'No session: '.$e->getMessage();
 }
}  elseif ( empty( $session ) ) {
 // the session is empty, we create a new one
 try {
 // the visitor is redirected from the login, let's pickup the session
 $session = $helper->getSessionFromRedirect();
 } catch( FacebookRequestException $e ) {
 // Facebook has returned an error
 echo 'Facebook (session) request error: '.$e->getMessage();
 } catch( Exception $e ) {
 // Any other error
 echo 'Other (session) request error: '.$e->getMessage();
 }
}
if ( isset( $session ) ) {
 // store the session token into a PHP session
 $_SESSION['fb_token'] = $session->getToken();
 // and create a new Facebook session using the cururent token 
 // or from the new token we got after login
 $session = new FacebookSession( $session->getToken() );
 try {
 // with this session I will post a message to my own timeline
 $request = new FacebookRequest(
 $session, 
 'POST', 
 '/me/feed', 
 array(
 'link' => 'www.finalwebsites.com/facebook-api-php-tutorial/',
 'message' => 'A step by step tutorial on how to use Facebook PHP SDK v4.0'
 )
 );
 $response = $request->execute();
 $graphObject = $response->getGraphObject();
 // the POST response object 
 echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
 $msgid = $graphObject->getProperty('id');
 } catch ( FacebookRequestException $e ) {
 // show any error for this facebook request
 echo 'Facebook (post) request error: '.$e->getMessage();
 }
