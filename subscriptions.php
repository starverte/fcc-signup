<?php
header('Content-Type: application/json');

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-subscription.php');
include_once('functions.php');

$fccdb = new fccdb;

if ( !empty( $_REQUEST['method']  ) ) {
  $method = _method( $_REQUEST['method']);
}
else {
  $method = 'get';
}
if ( !empty( $_REQUEST['id']  ) ) {
  $sub_id = (int) $_REQUEST['id'];
}
else { 
  $method = 'set';
}

switch ($method) {
  case 'get' :
    $sub = subscription::get_instance( $sub_id );
    echo json_encode($sub, JSON_PRETTY_PRINT);
    break;
  case 'set' :
    $goto = subscription::new_instance( $_REQUEST['plan'],$_REQUEST['user'],$_REQUEST['balance'],$_REQUEST['status'],$_REQUEST['pmt_schedule'] );
    echo json_encode(subscription::get_instance( $goto ), JSON_PRETTY_PRINT);
    header('Location: ./sub/'.$goto);
    exit;
    break;
  case 'del' :
    echo "trying to delete\n";
    $fccdb->delete('subscriptions',"sub_id = $sub_id");
    echo "Sub #$sub_id deleted.";
    break;
  default:
    break;
}