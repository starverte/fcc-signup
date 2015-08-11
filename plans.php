<?php

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

switch ($method) {
  case 'get' :
    $plan = Plan::get_instance( $plan_id );
    if (!$_REQUEST['raw']) {
      ?><!DOCTYPE html>
      <html>
      <head>
        <title><?php echo "The $plan->plan_name Plan - Star Verte";?></title>
        <style type="text/css">
          div {
            position: relative;
            width: 100%;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-left: 0px;
            margin-right: 0px;
            padding-left: 70px;
            padding-right: 70px;
            font-family: 'Open Sans', sans-serif;
          }
          #header {
            background-color: rgb(248, 248, 248);
            padding-top: 20px;
            padding-bottom: 20px;
          }
          #title {
            background-color: rgb(60, 180, 0);
            font-size: 36px;
            color: #fff;
          }
        </style>
      </head>
      <body>
        <div id="header"><img src="http://starverte.com/wp-content/uploads/2014/08/Star-Verte-small1.png" width="291" height="55"></div>
        <div id="title">This is the <?php echo $plan->plan_name ?> Plan from Star Verte</div>
        <div id="info">This plan includes <?php echo $plan->plan_storage ?>GB of storage, <?php echo $plan->plan_installs ?> separate Wordpress installs, for <?php 
          if (!empty($plan->plan_price_monthly)) {echo "$$plan->plan_price_monthly a month";}
          if (!empty($plan->plan_price_monthly) && !empty($plan->plan_price_yearly)) {echo ", or ";}
          if (!empty($plan->plan_price_yearly)) {echo "$$plan->plan_price_yearly a year";}
          if (empty($plan->plan_price_monthly) && empty($plan->plan_price_yearly)) {echo "an unknown amount of money (see <a href='../plan/$plan_id?raw=1'>here</a> for more info)";}
         ?></div>
      </body>
      </html>
      <?php
    }
    else {
      echo json_encode($plan, JSON_PRETTY_PRINT);
    }
    break;
  default:
    break;
}