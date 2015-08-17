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
    if (!$_REQUEST['raw'] && $plan->plan_id) {
      global $the_title;
      $the_title = 'Plans';
      include_once('header.php');
      ?>
            <div id="primary" class="content-area container">

              <div class="row">

                
                <div id="content" role="main" class="site-content col-xs-12">

                  
                  
            <div class="row">
              <div class="col-xs-12 col-sm-12 hidden-md hidden-lg"></div>    <article id="post-1230" class="col-xs-12 post-1230 page type-page status-publish hentry">
                <header class="entry-header">
                          
                  <h1 class="entry-title">We strive to develop excellent software that transforms data into relationships</h1>
                  
                  <div class="entry-meta">
                            </div><!-- .entry-meta -->

                  
                </header><!-- .entry-header -->

                      <div class="entry-content">
                  <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6">
          <h3>Cloud Storage</h3>
          <p>Includes <?php echo $plan->plan_storage; ?>GB of cloud storage</p>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
          <h3><?php if (1<$plan->plan_installs) {echo 'Multiple Installs';} else {echo 'Install WordPress';}?></h3>
          <p><?php if (1<$plan->plan_installs) {echo "Install WordPress up to $plan->plan_installs times";} else {echo "$plan->plan_installs install of WordPress";}?>.</p>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
          <h3>Great Pricing</h3>
          <p>This plan is offered at <?php 
          if (!empty($plan->plan_price_monthly)) {echo "$$plan->plan_price_monthly a month";}
          if (!empty($plan->plan_price_monthly) && !empty($plan->plan_price_yearly)) {echo ", or $$plan->plan_price_yearly a year, ($".(($plan->plan_price_monthly*12)-$plan->plan_price_yearly).' cheaper)';}
          else if (!empty($plan->plan_price_yearly)) {echo "$$plan->plan_price_yearly a year";}
          if (empty($plan->plan_price_monthly) && empty($plan->plan_price_yearly)) {echo "an unknown amount of money (see <a href='./$plan_id?raw=1'>here</a> for more info)";}
         ?>.</p>
          </div>
          <div class="col-sm-6"></div>
          </div>
                        </div><!-- .entry-content -->
                
                <footer class="entry-meta clearfix">
                      </footer><!-- .entry-meta -->

              </article><!-- #post-1230 -->
                </div><!-- .row -->

                  
                    <nav role="navigation" id="nav-below" class="navigation-paging">
              <h1 class="screen-reader-text">Post navigation</h1>

            
            </nav>
            <!-- #nav-below -->

                </div><!-- #content .site-content -->

                
              </div><!-- .row -->

            </div><!-- #primary .content-area -->

      <?php
      include_once('footer.php');
    }
    else if ($_REQUEST['raw']) {
      echo json_encode($plan, JSON_PRETTY_PRINT);
    }
    else {
      echo "There is no plan with ID $plan_id";
    }
    break;
  default:
    break;
}
