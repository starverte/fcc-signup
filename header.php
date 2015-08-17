<?php
/**
 * Header
 *
 * Contains the opening <html> and <head> section
 * along with the header and navigation that is consistent
 * on all pages.
 *
 * @author Matt Beall
 * @since 0.2.0
 */
session_start();
session_regenerate_id();

include_once('inc/class-fccdb.php');
include_once('inc/class-address.php');
include_once('inc/class-extra.php');
include_once('inc/class-plan.php');
include_once('inc/class-site.php');
include_once('inc/class-subscription.php');
include_once('inc/class-user.php');
include_once('functions.php');

$fccdb = new fccdb;

global $the_title;
global $the_type;

if (!empty($the_type)) {
  switch ($the_type) {
    case 'user':
      global $user;
      if (!empty($_REQUEST['u'])) {
        $u = (int) $_REQUEST['u'];
        $user = get_user( $u );
      }
      else {
        $u = 0;
        $user = null;
      }
      break;

    default:
      break;
  }
}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $the_title; ?> | Fort Collins Creative</title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="stylesheet" id="bootstrap"  href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" media="all" />
  <link rel="stylesheet" id="open-sans"  href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.0" type="text/css" media="all" />
  <link rel="stylesheet" id="flint"  href="//raw.githubusercontent.com/starverte/flint/master/style.css" type="text/css" media="all" />
  <link rel="stylesheet" id="flint"  href="//fortcollinscreative.com/wp-content/themes/canvas/style.css" type="text/css" media="all" />
  <link rel="stylesheet" id="stylesheet"  href="style.css" type="text/css" media="all" />
</head>
<body>
  <div id="page" class="hfeed site">
    <nav class="navbar navbar-canvas navbar-top" role="navigation">
      <h1 class="screen-reader-text">Menu</h1>
      <div class="screen-reader-text skip-link"><a href="#content" title="Skip to content">Skip to content</a></div>
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fcc">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://fortcollinscreative.com"><img src="http://fortcollinscreative.com/wp-content/uploads/2014/08/Fort-Collins-Creative-small.png" alt="Fort Collins Creative Logo"></a>
        </div><!-- .navbar-header -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-fcc">
          <ul id="menu-front" class="nav navbar-nav">
            <li class="menu-item"><a href="http://fortcollinscreative.com#plans">Plans</a></li>
            <li class="menu-item"><a href="http://fortcollinscreative.com/contact/">Contact</a></li>
          </ul>        
          <div class="navbar-right">
            <a class="btn btn-fcc disabled navbar-btn" href="#">Create website</a>
            <?php if (is_logged_in()) { ?>
              <a class="btn btn-default navbar-btn" href="logout.php">Logout</a>
            <?php
            }
            else { ?>
              <a class="btn btn-default navbar-btn" href="login.php">Login</a>
            <?php } ?>
          </div>
        </div><!-- .navbar-collapse -->
      </div><!-- .container -->
    </nav><!-- .navbar -->

    <div id="masthead" class="fill site-header" role="banner">
      <div class="container">
        <div class="site-branding">
          <div class="clearfix"><p></p></div>
        </div><!-- .site-branding -->
      </div><!-- .container -->
    </div><!-- #masthead -->


    <div class="stripe">
      <div class="container">
        <p><?php echo $the_title; ?></p>
      </div><!-- .container -->
    </div><!-- .fill -->

