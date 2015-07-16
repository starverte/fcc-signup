<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-extra.php');
include_once('functions.php');

$fccdb = new fccdb;

if ( !empty( $_REQUEST['method']  ) ) {
  $method = _method( $_REQUEST['method']);
}
else {
  $method = 'get';
}
if ( !empty( $_REQUEST['id']  ) ) {
  $extra_id = (int) $_REQUEST['id'];
}
else {
  $extra_id = rand(1,25);
}
$extra_id = min($extra_id,25);
$extra_id = max($extra_id,0);

switch ($method) {
  case 'get' :
    $extra = Extra::get_instance( $extra_id );
    echo json_encode($extra, JSON_PRETTY_PRINT);
    break;
  default:
    break;
}

