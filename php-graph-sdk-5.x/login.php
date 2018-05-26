<?php
// Pass session data over. Only needed if not already passed by another script like WordPress.
session_start();
 
// Include the required dependencies.
require_once( 'vendor/autoload.php' );
 
// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '2099205980363929',
  'app_secret'            => 'f8027b5cee91e363086b4e73c228d729',
  'default_graph_version' => 'v2.10',
]);
 
$helper = $fb->getRedirectLoginHelper();
 
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);
 
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
