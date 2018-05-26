<?php

use Facebook\FacebookRequest;
use Facebook\GraphUser;

$fb = new Facebook\Facebook([
  'app_id'                => '2099205980363929',
  'app_secret'            => 'f8027b5cee91e363086b4e73c228d729',
  'default_graph_version' => 'v2.10',
]);
try {
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());
  echo $me->getName();
} catch (\Exception $e) {
  // Some other error occurred
}
  
  ?>
