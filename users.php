<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-user.php');
include_once('functions.php');

$fccdb = new fccdb;

if ( !empty( $_REQUEST['method']  ) ) {
  $method = _method( $_REQUEST['method']);
}
else {
  $method = 'get';
}
if ( !empty( $_REQUEST['id']  ) ) {
  $user_id = (int) $_REQUEST['id'];
}
else {
  $user_id = rand(1,25);
}

$user_id = min($user_id,25);
$user_id = max($user_id,0);

switch ($method) {
  case 'get' :
    $user = user::get_instance( $user_id );
    echo json_encode($user, JSON_PRETTY_PRINT);
    break;
  default:
    break;
}