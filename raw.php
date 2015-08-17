<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-extra.php');
include_once('inc/class-plan.php');
include_once('inc/class-site.php');
include_once('inc/class-subscription.php');
include_once('inc/class-user.php');
include_once('functions.php');

$fccdb = new fccdb;

$method = !empty($_REQUEST['method']) ? _method( $_REQUEST['method'] ) : 'get';
$obj_id = !empty((int) $_REQUEST['id']) ? (int) $_REQUEST['id'] : http_response_code(404) && die();
$class  = !empty($_REQUEST['class']) ? _class( $_REQUEST['class'] ) : http_response_code(404) && die();

switch ($method) {
  case 'get' :
    $object = $class::get_instance( $obj_id );
    echo json_encode($object, JSON_PRETTY_PRINT);
    break;
  default:
    break;
}
