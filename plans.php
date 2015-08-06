<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-plan.php');
include_once('functions.php');

$fccdb = new fccdb;

if ( !empty( $_REQUEST['method']  ) ) {
  $method = _method( $_REQUEST['method']);
}
else {
  $method = 'get';
}
if ( !empty( $_REQUEST['id']  ) ) {
  $plan_id = (int) $_REQUEST['id'];
}
else {
  $plan_id = rand(1,25);
}

$plan_id = min($plan_id,25);
$plan_id = max($plan_id,0);

switch ($method) {
  case 'get' :
    $plan = Plan::get_instance( $plan_id );
    echo json_encode($plan, JSON_PRETTY_PRINT);
    break;
  default:
    break;
}