<?php

include_once('config.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-user.php');
include_once('inc/class-address.php');
include_once('inc/class-subscription.php');
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
    if (!$_REQUEST['raw'] && $user->user_id) {?>
      <!DOCTYPE html>
        <!--[if lt IE 9]><html lang="en-US" class="ie"><![endif]-->
        <!--[if gte IE 9]><!--><html lang="en-US"><!--<![endif]-->
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <link rel="profile" href="http://gmpg.org/xfn/11" />
          <link rel="pingback" href="http://starverte.com/xmlrpc.php" />
          <title><?php echo "$user->user_name_first $user->user_name_last";?> | Star Verte LLC</title>
        <link rel="alternate" type="application/rss+xml" title="Star Verte LLC &raquo; Feed" href="http://starverte.com/feed/" />
        <link rel="alternate" type="application/rss+xml" title="Star Verte LLC &raquo; Comments Feed" href="http://starverte.com/comments/feed/" />
            <script type="text/javascript">
              window._wpemojiSettings = {"baseUrl":"http:\/\/s.w.org\/images\/core\/emoji\/72x72\/","ext":".png","source":{"concatemoji":"http:\/\/starverte.com\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.2.4"}};
              !function(a,b,c){function d(a){var c=b.createElement("canvas"),d=c.getContext&&c.getContext("2d");return d&&d.fillText?(d.textBaseline="top",d.font="600 32px Arial","flag"===a?(d.fillText(String.fromCharCode(55356,56812,55356,56807),0,0),c.toDataURL().length>3e3):(d.fillText(String.fromCharCode(55357,56835),0,0),0!==d.getImageData(16,16,1,1).data[0])):!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g;c.supports={simple:d("simple"),flag:d("flag")},c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.simple&&c.supports.flag||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
            </script>
            <style type="text/css">
        img.wp-smiley,
        img.emoji {
          display: inline !important;
          border: none !important;
          box-shadow: none !important;
          height: 1em !important;
          width: 1em !important;
          margin: 0 .07em !important;
          vertical-align: -0.1em !important;
          background: none !important;
          padding: 0 !important;
        }
        </style>
        <link rel='stylesheet' id='bootstrap-css-css'  href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css?ver=3.3.5' type='text/css' media='all' />
        <link rel='stylesheet' id='slides-mod-style-css'  href='http://starverte.com/wp-content/plugins/steel/css/slides.css?ver=1.2.1' type='text/css' media='all' />
        <link rel='stylesheet' id='open-sans-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.2.4' type='text/css' media='all' />
        <link rel='stylesheet' id='flint-style-css'  href='http://starverte.com/wp-content/themes/canvas/style.css?ver=0.0.0' type='text/css' media='all' />
        <script type='text/javascript' src='http://starverte.com/wp-includes/js/jquery/jquery.js?ver=1.11.2'></script>
        <script type='text/javascript' src='http://starverte.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
        <script type='text/javascript' src='http://assets.pinterest.com/js/pinit.js?ver=4.2.4'></script>
        <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://starverte.com/xmlrpc.php?rsd" />
        <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://starverte.com/wp-includes/wlwmanifest.xml" /> 
        <meta name="generator" content="WordPress 4.2.4" />
        <link rel='canonical' href='http://starverte.com/' />
        <link rel='shortlink' href='http://wp.me/P26ZsM-jQ' />

        <link rel='dns-prefetch' href='//i0.wp.com'>
        <link rel='dns-prefetch' href='//i1.wp.com'>
        <link rel='dns-prefetch' href='//i2.wp.com'>
        <style type="text/css" id="custom-background-css">
        body.custom-background { background-color: #ffffff; }
        </style>

        <!-- Jetpack Open Graph Tags -->
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Star Verte LLC" />
        <meta property="og:description" content="Transforming data into relationships" />
        <meta property="og:url" content="http://starverte.com/" />
        <meta property="og:site_name" content="Star Verte LLC" />
        <meta property="og:image" content="https://s0.wp.com/i/blank.jpg" />
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:card" content="summary" />
          <style type="text/css">body {background-color: #ffffff; font-family: "Open Sans",         sans-serif; font-weight: 300; }h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .navbar-brand { font-family: "Open Sans",         sans-serif; font-weight: 400;}a {color:#3cb400;}a:hover, a:focus {color:#226800;}blockquote {border-left-color: #55ff01;}.fill { background-color: #3cb400; border-color: #1a4e00; color: #ffffff; }.navbar-inverse .navbar-nav > li > a, .fill a, .fill-light a { color: #d9d9d9; }.fill a:hover, .fill-light a:hover { color: #ffffff; }.site-branding a, .site-branding a:hover { color: #ffffff; }.navbar-inverse .navbar-nav > .dropdown > a .caret { border-top-color: #d9d9d9; border-bottom-color: #d9d9d9; }.navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: #ffffff; background-color: #1a4e00;
        }.navbar-brand { color: #ffffff!important; }.fill-light { background: #55ff01; color: #ffffff; }</style></head>
        <body class="home page page-id-1230 page-template page-template-templates page-template-wide page-template-templateswide-php custom-background">
            <div id="page" class="hfeed site">
            
          <nav class="navbar navbar-canvas navbar-top" role="navigation">
            <h1 class="screen-reader-text">Menu</h1>
            <div class="screen-reader-text skip-link"><a href="#content" title="Skip to content">Skip to content</a></div>
            <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://starverte.com"><img src="http://starverte.com/wp-content/uploads/2014/08/Star-Verte-small1.png" width="5505" height="1042" alt="" /></a>
              </div><!-- .navbar-header -->

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse navbar-ex1-collapse">
                
                
                
                <ul id="menu-top" class="nav navbar-nav navbar-right"><li id="menu-item-1686" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1686"><a href="http://starverte.com/">Home</a></li>
        <li id="menu-item-1687" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1687"><a href="http://starverte.com/about/">About</a></li>
        <li id="menu-item-1688" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1688"><a href="http://starverte.com/blog/">Blog</a></li>
        <li id="menu-item-1689" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1689"><a href="http://starverte.com/contact/">Contact</a></li>
        </ul>
              </div><!-- .navbar-collapse -->
            </div><!-- .container -->
          </nav><!-- .navbar -->
        <div id="masthead" class="fill site-header" role="banner">
          <div class="container">
            <div class="site-branding">
              
                
                
                
                  <h2 class="tagline hidden-xs" style="font-size: 36px;"><?php echo "$user->user_name_first $user->user_name_last".(!!$user->user_company?" - $user->user_company":'') ?></h2>

                  <h2 class="tagline visible-xs-block" style="font-size: 24px;"><?php echo "$user->user_name_first $user->user_name_last".(!!$user->user_company?" - $user->user_company":'') ?></h2>

                  <div class="clearfix"><p></p></div>

            </div><!-- .site-branding -->
          </div><!-- .container -->
        </div><!-- #masthead -->


          <div class="stripe">
            <div class="container">

              
              
              
              
            </div><!-- .container -->
          </div><!-- .stripe -->
          <div id="primary" class="content-area container">

            <div class="row">

              
              <div id="content" role="main" class="site-content col-xs-12">

                
                
          <div class="row">
            <div class="col-xs-12 col-sm-12 hidden-md hidden-lg"></div>    <article id="post-1230" class="col-xs-12 post-1230 page type-page status-publish hentry">
              <header class="entry-header">
                        
                <h1 class="entry-title"><?php echo "$user->user_name_first $user->user_name_last".(!!$user->user_company?" - $user->user_company":'') ?></h1>
                
                <div class="entry-meta">
                          </div><!-- .entry-meta -->

                
              </header><!-- .entry-header -->

                    <div class="entry-content">
                      <?php if (!$_REQUEST['subs']) { ?>
                      <div class="col-lg-4 col-md-4 col-sm-6">
                        <h3>About: </h3>
                        <p>Email: <a href=<?php echo "'mailto:$user->user_email'>$user->user_email" ?></a></p>
                        <p><?php echo $user->user_company ? "Works at: $user->user_company" : "$user->user_name_first $user->user_name_last hasn't entered his/her company yet" ?></p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6">
                        <h3>Address: </h3>
                        <p><?php echo $user->user_address ? address::get_instance_pretty($user->user_address) : "$user->user_name_first $user->user_name_last hasn't entered his/her address yet" ?></p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6">
                        <h3>Subscriptions: </h3>
                        <?php
                          function date_sort($a, $b) {
                            if ($a->sub_date_created === $b->sub_date_created) return 0;
                            return ($a->sub_date_created < $b->sub_date_created) || ($a->sub_status === 'deleted') ? -1 : 1;
                          }
                          $subs = subscription::get_by_user($user_id);
                          usort($subs, "date_sort");
                          if ($subs) {
                            $len = count($subs);
                            foreach (array_splice($subs, 0, 3) as $_sub) {
                                echo '<p>Plan: '.plan::get_instance($_sub->sub_plan)->plan_name.'</p>' .
                                     "<p>Status: $_sub->sub_status</p><br />";
                            }
                            if (3<$len) {
                              echo '<p><a href="../user/'.$user_id.'/subs">' . ($len-3) . ' more ...</a></p>';
                            }
                            else {
                              echo '<p><a href="../user/'.$user_id.'/subs">More details</a></p>';
                            }
                          }
                          else {
                            echo "<p>$user->user_name_first $user->user_name_last has no subscriptions.</p>";
                          }}
                          else {
                            function date_sort($a, $b) {
                              if ($a->sub_date_created === $b->sub_date_created) return 0;
                              return ($a->sub_date_created < $b->sub_date_created) || ($a->sub_status === 'deleted') ? -1 : 1;
                            }
                            $subs = subscription::get_by_user($user_id);
                            usort($subs, "date_sort");
                            if ($subs) {
                              foreach ($subs as $_sub) {
                                  echo '<div class="col-lg-4 col-md-4 col-sm-6">' .
                                       '<p>Plan: '.plan::get_instance($_sub->sub_plan)->plan_name.'</p>' .
                                       "<p>Status: $_sub->sub_status</p>" .
                                       "<p>Payment Schedule: $_sub->sub_pmt_schedule</p>" .
                                       "<p>Balance: $$_sub->sub_balance</p>" .
                                       "<p>Date Created: $_sub->sub_date_created</p>" .
                                       '<br /><br /></div>';
                              }
                            }
                          }
                        ?>
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

        </div><!-- #page -->


        </div><!-- #page -->

        <footer id="colophon" class="site-footer" role="contentinfo">
          <div class="site-info container">
            <div id="footer-left" class="col-lg-10 col-md-9 col-sm-8">
                  </div>
            <div id ="credits" class="col-lg-2 col-md-3 col-sm-4">
              <div class="row">
                <div class="col-xs-4">
                  <a href="http://starverte.com"><img class="icon-star" src="http://starverte.com/wp-content/themes/canvas/img/star.png"></a>
                </div>
                <div class="col-xs-4">
                  <a href="http://fortcollinscreative.com"><img class="icon-cs" src="http://starverte.com/wp-content/themes/canvas/img/Cs.png"></a>
                </div>
                <div class="col-xs-4">
                  <a href="http://sparks.starverte.com"><img class="icon-spark" src="http://starverte.com/wp-content/themes/canvas/img/spark.png"></a>
                </div>
              </div>
              <p>

                      Developed by <a href="http://starverte.com">Star Verte</a><br class="hidden-xs">
              
              
              
                <span class="visible-xs-inline"> | </span>Powered by <a href="http://wordpress.org">WordPress</a>
              </p>
            </div>

          </div><!-- .site-info -->
        </footer><!-- #colophon -->


              <script type="text/javascript">
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-31634182-1']);
                _gaq.push(['_trackPageview']);
                (function() {
                  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
              </script> <div style="display:none">
          </div>
        <script type='text/javascript' src='http://starverte.com/wp-content/plugins/jetpack/modules/photon/photon.js?ver=20130122'></script>
        <script type='text/javascript' src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js?ver=3.3.5'></script>
        <script type='text/javascript' src='http://starverte.com/wp-content/plugins/steel/js/run.js?ver=1.2.1'></script>
        <script type='text/javascript' src='http://s0.wp.com/wp-content/js/devicepx-jetpack.js?ver=201533'></script>
        <script type='text/javascript' src='http://s.gravatar.com/js/gprofiles.js?ver=2015Augaa'></script>
        <script type='text/javascript'>
        /* <![CDATA[ */
        var WPGroHo = {"my_hash":""};
        /* ]]> */
        </script>
        <script type='text/javascript' src='http://starverte.com/wp-content/plugins/jetpack/modules/wpgroho.js?ver=4.2.4'></script>
        <script type='text/javascript' src='http://starverte.com/wp-content/themes/flint/js/skip-link-focus-fix.js?ver=9f3e2cd'></script>
        <script type='text/javascript' src='http://stats.wp.com/e-201533.js' async defer></script>
        <script type='text/javascript'>
          _stq = window._stq || [];
          _stq.push([ 'view', {v:'ext',j:'1:3.6.1',blog:'31218908',post:'1230',tz:'-6',srv:'starverte.com'} ]);
          _stq.push([ 'clickTrackerInit', '31218908', '1230' ]);
        </script>

        </body>
        </html>
    <?php }
    else if ($_REQUEST['raw']) {
      echo json_encode($user, JSON_PRETTY_PRINT);
    }
    else {
      echo "There is no user with ID $user_id";
    }
    break;
  default:
    break;
}
