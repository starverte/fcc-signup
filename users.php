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
  $user_id = 1;
}

switch ($method) {
  case 'get' :
    $user = user::get_instance( $user_id );
    if (!$_REQUEST['raw'] && $user->user_id) {?>
      <!DOCTYPE html>
      <!--[if lt IE 9]><html lang="en-US" class="ie"><![endif]-->
      <!--[if gte IE 9]><!-->

      <html lang="en-US">
      <!--<![endif]-->

      <head>
        <meta charset="UTF-8">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <link href="http://gmpg.org/xfn/11" rel="profile">
        <link href="http://starverte.com/xmlrpc.php" rel="pingback">

        <title><?php echo "$user->user_name_first $user->user_name_last";?> | Star Verte LLC</title>
        <link href="http://starverte.com/feed/" rel="alternate" title="Star Verte LLC &raquo; Feed" type="application/rss+xml">
        <link href="http://starverte.com/comments/feed/" rel="alternate" title="Star Verte LLC &raquo; Comments Feed" type="application/rss+xml">
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

        div.shell {
          padding: 5px;
        }

        div.card {
          padding: 3px;
          border: outset #3cb400 5px;
          margin: 0px;
          background-color: #f7fCf5;
        }

        p.title {
          margin-top: 0px;
          text-align: center;
          font-size: 30px;
        }

        .center {
          text-align: center;
        }
        </style>
        <link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css?ver=3.3.5' id='bootstrap-css-css' media='all' rel='stylesheet' type='text/css'>
        <link href='http://starverte.com/wp-content/plugins/steel/css/slides.css?ver=1.2.1' id='slides-mod-style-css' media='all' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.2.4' id='open-sans-css' media='all' rel='stylesheet' type='text/css'>
        <link href='http://starverte.com/wp-content/themes/canvas/style.css?ver=0.0.0' id='flint-style-css' media='all' rel='stylesheet' type='text/css'>
        <script src='http://starverte.com/wp-includes/js/jquery/jquery.js?ver=1.11.2' type='text/javascript'></script>
        <script src='http://starverte.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1' type='text/javascript'></script>
        <script src='http://assets.pinterest.com/js/pinit.js?ver=4.2.4' type='text/javascript'></script>
        <link href="http://starverte.com/xmlrpc.php?rsd" rel="EditURI" title="RSD" type="application/rsd+xml">
        <link href="http://starverte.com/wp-includes/wlwmanifest.xml" rel="wlwmanifest" type="application/wlwmanifest+xml">
        <meta content="WordPress 4.2.4" name="generator">
        <link href='http://starverte.com/' rel='canonical'>
        <link href='http://wp.me/P26ZsM-jQ' rel='shortlink'>
        <link href='//i0.wp.com' rel='dns-prefetch'>
        <link href='//i1.wp.com' rel='dns-prefetch'>
        <link href='//i2.wp.com' rel='dns-prefetch'>
        <style id="custom-background-css" type="text/css">
      body.custom-background { background-color: #ffffff; }
        </style><!-- Jetpack Open Graph Tags -->
        <meta content="website">
        <meta content="Star Verte LLC">
        <meta content="Transforming data into relationships">
        <meta content="http://starverte.com/">
        <meta content="Star Verte LLC">
        <meta content="https://s0.wp.com/i/blank.jpg">
        <meta content="en_US">
        <meta content="summary" name="twitter:card">
        <style type="text/css">
      body {background-color: #ffffff; font-family: "Open Sans",         sans-serif; font-weight: 300; }h1, h2, h3, p, h5, h6, .h1, .h2, .h3, .p, .h5, .h6, .navbar-brand { font-family: "Open Sans",         sans-serif; font-weight: 400;}a {color:#3cb400;}a:hover, a:focus {color:#226800;}blockquote {border-left-color: #55ff01;}.fill { background-color: #3cb400; border-color: #1a4e00; color: #ffffff; }.navbar-inverse .navbar-nav > li > a, .fill a, .fill-light a { color: #d9d9d9; }.fill a:hover, .fill-light a:hover { color: #ffffff; }.site-branding a, .site-branding a:hover { color: #ffffff; }.navbar-inverse .navbar-nav > .dropdown > a .caret { border-top-color: #d9d9d9; border-bottom-color: #d9d9d9; }.navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: #ffffff; background-color: #1a4e00;
        }.navbar-brand { color: #ffffff!important; }.fill-light { background: #55ff01; color: #ffffff; }
        </style>
      </head>

      <body class="home page page-id-1230 page-template page-template-templates page-template-wide page-template-templateswide-php custom-background">
        <div class="hfeed site" id="page">
          <nav class="navbar navbar-canvas navbar-top">
            <h1 class="screen-reader-text">Menu</h1>

            <div class="screen-reader-text skip-link">
              <a href="#content" title="Skip to content">Skip to content</a>
            </div>

            <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->

              <div class="navbar-header">
                <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button> <a class="navbar-brand" href="http://starverte.com"><img alt="" height="1042" src="http://starverte.com/wp-content/uploads/2014/08/Star-Verte-small1.png" width="5505"></a>
              </div><!-- .navbar-header -->
              <!-- Collect the nav links, forms, and other content for toggling -->

              <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right" id="menu-top">
                  <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1686" id="menu-item-1686">
                    <a href="http://starverte.com/">Home</a>
                  </li>

                  <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1687" id="menu-item-1687">
                    <a href="http://starverte.com/about/">About</a>
                  </li>

                  <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1688" id="menu-item-1688">
                    <a href="http://starverte.com/blog/">Blog</a>
                  </li>

                  <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1689" id="menu-item-1689">
                    <a href="http://starverte.com/contact/">Contact</a>
                  </li>
                </ul>
              </div><!-- .navbar-collapse -->
            </div><!-- .container -->
          </nav><!-- .navbar -->

          <div class="fill site-header" id="masthead">
            <div class="container">
              <div class="site-branding">
                <h2 class="tagline hidden-xs" style="font-size: 36px;"><?php echo "$user->user_name_first $user->user_name_last" . ($_REQUEST['subs'] ? '\'s Subscriptions' : ($user->user_company ? " - $user->user_company" : '')) ?></h2>

                <h2 class="tagline visible-xs-block" style="font-size: 24px;"><?php echo "$user->user_name_first $user->user_name_last" . ($_REQUEST['subs'] ? '\'s Subscriptions' : ($user->user_company ? " - $user->user_company" : '')) ?></h2>

                <div class="clearfix">
                  <p></p>
                </div>
              </div><!-- .site-branding -->
            </div><!-- .container -->
          </div><!-- #masthead -->

          <div class="stripe">
            <div class="container"></div><!-- .container -->
          </div><!-- .stripe -->

          <div class="content-area container" id="primary">
            <div class="row">
              <div class="site-content col-xs-12" id="content">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 hidden-md hidden-lg"></div>

                  <article class="col-xs-12 post-1230 page type-page status-publish hentry" id="post-1230">
                    <header class="entry-header">
                      <h1 class="entry-title"><?php echo "$user->user_name_first $user->user_name_last".(!!$user->user_company?" - $user->user_company":'') ?></h1>

                      <div class="entry-meta"></div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                      <?php if (!$_REQUEST['subs']) { ?>

                      <div class="shell col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                          <p class="title">About</p>

                          <p>Email: <?php echo "<a href='mailto:$user->user_email'>$user->user_email" ?></p>

                          <p><?php echo $user->user_company ? "Works at: $user->user_company" : "$user->user_name_first $user->user_name_last hasn't entered his/her company yet" ?></p>
                        </div>
                      </div>

                      <div class="shell col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                          <p class="title">Address</p>

                          <p><?php echo $user->user_address ? address::get_instance_pretty($user->user_address) : "$user->user_name_first $user->user_name_last hasn't entered his/her address yet" ?></p>
                        </div>
                      </div>

                      <div class="shell col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                          <p class="title">Subscriptions</p><?php
                                              function date_sort($a, $b) {
                                                if ($a->sub_date_created === $b->sub_date_created) return 0;
                                                return ($a->sub_date_created < $b->sub_date_created) ? 1 : -1;
                                              }
                                              $subs = subscription::get_by_user($user_id);
                                              usort($subs, "date_sort");
                                              if ($subs) {
                                                $len = count($subs);
                                                $num = 0;
                                                foreach (array_splice($subs, 0, 3) as $_sub) {
                                                  if ($_sub->sub_status !== 'deleted') {
                                                    $num += 1;
                                                    echo '<div class="col-lg-6 col-md-12 col-sm-12">' .
                                                         '<p>Plan: '.plan::get_instance($_sub->sub_plan)->plan_name.'</p>' .
                                                         "<p>Status: $_sub->sub_status</p><br />" .
                                                         '</div>';
                                                  }
                                                }
                                                if ($num % 2 === 0) {echo '<div>';}
                                                else echo '<div class="col-lg-6 col-md-12 col-sm-12">';
                                                if ($num<$len) {
                                                  echo '<p class="center"><a href="./'.$user_id.'/subs">' . ($len-$num) . ' more ...</a></p></div>';
                                                }
                                                else {
                                                  echo '<p class="center"><a href="./'.$user_id.'/subs">More details</a></p></div>';
                                                }
                                                echo '<div class="clearfix"><p></p></div>';
                                              }
                                              else {
                                                echo "<p>$user->user_name_first $user->user_name_last has no subscriptions.</p>";
                                              }}
                                              else {
                                                function date_sort($a, $b) {
                                                  if ($a->sub_date_created === $b->sub_date_created) return 0;
                                                  return (strtotime($a->sub_date_created) < strtotime($b->sub_date_created)) || ($a->sub_status === 'deleted' && $b->sub_status !== 'deleted') ? 1 : -1;
                                                }
                                                $subs = subscription::get_by_user($user_id);
                                                usort($subs, "date_sort");
                                                if ($subs) {
                                                  echo '<table class="table">' .
                                                       '</td><td>Plan</td><td>Start Date</td><td>Payment Schedule</td><td></td></tr>';
                                                  foreach ($subs as $_sub) {
                                                      $date = strtotime($_sub->sub_date_created);
                                                      echo '<tr class="' . ($_sub->sub_status === 'active' ? 'success': ($_sub->sub_status === 'suspended' ? 'warning' : ($_sub->sub_status === 'pending' ? 'info' : 'danger'))) . '">' .
                                                           '<td>'.plan::get_instance($_sub->sub_plan)->plan_name.'</td>' .
                                                           '<td>'. (date('y', $date) == '15' ? date('F j', $date) : date('n/j/Y', $date)) .'</td>' .
                                                           "<td>$_sub->sub_pmt_schedule</td>" .
                                                           '<td>';
                                                          if ($_sub->sub_status === 'suspended') {
                                                            if ($_sub->sub_balance > 0) echo "Suspended - Balance due $$_sub->sub_balance";
                                                          }
                                                          else if ($_sub->sub_status === 'pending') {
                                                            echo 'Awaiting verification';
                                                          }
                                                          else if ($_sub->sub_status === 'active') {
                                                            echo "Active";
                                                          }
                                                          else echo "Deleted";

                                                          echo '</td></tr>';
                                                  }
                                                  echo '</table>';
                                                } else echo "<p>$user->user_name_first $user->user_name_last has no subscriptions.</p>";
                                              }
                                            ?>
                        </div>
                      </div>
                    </div><!-- .entry-content -->

                    <footer class="entry-meta clearfix"></footer><!-- .entry-meta -->
                  </article><!-- #post-1230 -->
                </div><!-- .row -->

                <nav class="navigation-paging" id="nav-below">
                  <h1 class="screen-reader-text">Post navigation</h1>
                </nav><!-- #nav-below -->
              </div><!-- #content .site-content -->
            </div><!-- .row -->
          </div><!-- #primary .content-area -->
        </div><!-- #page -->
        <!-- #page -->

        <footer class="site-footer" id="colophon">
          <div class="site-info container">
            <div class="col-lg-10 col-md-9 col-sm-8" id="footer-left"></div>

            <div class="col-lg-2 col-md-3 col-sm-4" id="credits">
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

              <p>Developed by <a href="http://starverte.com">Star Verte</a><br class="hidden-xs">
              <span class="visible-xs-inline">|</span> Powered by <a href="http://wordpress.org">WordPress</a></p>
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
        </script>

        <div style="display:none"></div><script src='http://starverte.com/wp-content/plugins/jetpack/modules/photon/photon.js?ver=20130122' type='text/javascript'></script> <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js?ver=3.3.5' type='text/javascript'></script> <script src='http://starverte.com/wp-content/plugins/steel/js/run.js?ver=1.2.1' type='text/javascript'></script> <script src='http://s0.wp.com/wp-content/js/devicepx-jetpack.js?ver=201533' type='text/javascript'></script> <script src='http://s.gravatar.com/js/gprofiles.js?ver=2015Augaa' type='text/javascript'></script> <script type='text/javascript'>
      /* <![CDATA[ */
        var WPGroHo = {"my_hash":""};
        /* ]]> */
        </script> <script src='http://starverte.com/wp-content/plugins/jetpack/modules/wpgroho.js?ver=4.2.4' type='text/javascript'></script> <script src='http://starverte.com/wp-content/themes/flint/js/skip-link-focus-fix.js?ver=9f3e2cd' type='text/javascript'></script> <script async="" defer src='http://stats.wp.com/e-201533.js' type='text/javascript'></script> <script type='text/javascript'>
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
