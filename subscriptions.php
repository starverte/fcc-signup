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
  if (!empty($_REQUEST['plan']) || !empty($_REQUEST['user']) || !empty($_REQUEST['balance']) || !empty($_REQUEST['status']) || !empty($_REQUEST['pmt_schedule'])) {
    $method = 'set';
  }
}
if ( !empty( $_REQUEST['id']  ) ) {
  $sub_id = (int) $_REQUEST['id'];
}
else { 
  $method = 'new';
}

switch ($method) {
  case 'get' :
    $sub = subscription::get_instance( $sub_id );
    if (empty($sub->sub_id)) {
      header('HTTP/1.0 404 Not Found');
      echo 'There is no subscription with that ID';
      exit;
    }
    echo json_encode($sub, JSON_PRETTY_PRINT);
    break;
  case 'set' :
    subscription::set_instance($sub_id, $_REQUEST['plan'], $_REQUEST['user'], $_REQUEST['balance'], $_REQUEST['status'], $_REQUEST['pmt_schedule']);
    echo json_encode(subscription::get_instance( $sub_id ), JSON_PRETTY_PRINT);
    break;
  case 'new' :
    $goto = subscription::new_instance( $_REQUEST['plan'],$_REQUEST['user'],$_REQUEST['balance'],$_REQUEST['status'],$_REQUEST['pmt_schedule'] );
    echo json_encode(subscription::get_instance( $goto ), JSON_PRETTY_PRINT);
    header('HTTP/1.1 201 Content Created');
    header('Location: ./sub/'.$goto);
    exit;
    break;
  case 'del' :
    echo "Trying to delete\n";
    $fccdb->delete('subscriptions',"sub_id = $sub_id");
    header('HTTP/1.1 204 Content Deleted');
    echo "Sub #$sub_id deleted.";
    break;
  default:
    break;
}