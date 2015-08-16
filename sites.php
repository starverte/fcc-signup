<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-site.php');
include_once('functions.php');

$fccdb = new fccdb;

if ( !empty( $_REQUEST['method']  ) ) {
  $method = _method( $_REQUEST['method']);
}
else {
  $method = 'get';
}
if ( !empty( $_REQUEST['id']  ) ) {
  $site_id = (int) $_REQUEST['id'];
}
else {
  $site_id = rand(1,25);
}

$site_id = min($site_id,25);
$site_id = max($site_id,0);

switch ($method) {
  case 'get' :
    $site = site::get_instance( $site_id );
    echo json_encode($site, JSON_PRETTY_PRINT);
    break;
  default:
    break;
}
