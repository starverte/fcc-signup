<?php
include_once('config.php');
include_once('functions.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-user.php');

$fccdb = new fccdb;

session_start();

if ( (!empty($_POST['mail']) && !empty($_POST['pw'])) && $u = user::login($_POST['mail'],$_POST['pw']) ) {
  include_once('inc/class-address.php');
  $_SESSION['user_id'] = $u->user_id;
  $_SESSION['user_email'] = $u->user_email;
  $_SESSION['user_name_first'] = $u->user_name_first;
  $_SESSION['user_name_last'] = $u->user_name_last;
  $_SESSION['user_address'] = address::get_instance($u->user_address);
  $_SESSION['user_company'] = $u->user_company;
  $_SESSION['user_level'] = $u->user_level;
  header('Location: ' . ($_REQUEST['goto'] ?: './user/'.$u->user_id));
}
else {
  global $the_title;
  $the_title = 'Login';
  include_once('header.php');
?>
<div class="content-area container" id="primary">
  <div class="row">
    <div class="site-content col-xs-12" id="content">
      <div class="row">
        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">
        </div>


        <article class="col-xs-12 post-1230 page type-page status-publish hentry" id="post-1230">
          <header class="entry-header">
            <h1 class="entry-title"></h1>


            <div class="entry-meta">
            </div>
            <!-- .entry-meta -->
          </header>
          <!-- .entry-header -->


          <div class="entry-content">
            <?php if (!is_logged_in()) { ?>
            <form action = "<?php echo empty($_REQUEST['goto']) ? './login.php' : './login.php?goto='.urlencode($_REQUEST['goto']) ?>" method="post">
              <span><?php if ($_REQUEST['goto']) {echo "You must log in to see that page<br />";} ?></span>
              <label>Email: </label><br />
              <input name="mail" placeholder="Email" <?php echo empty($_REQUEST['mail']) ? '' : 'value=\''.$_REQUEST['mail'].'\''; ?> type="text" /><br />
              <label>Password: </label><br />
              <input name="pw" placeholder="***" type="password"><br />
              <input name="submit" type="submit" value="Login"><br />
              <span><?php echo !empty($_POST['pw']) ? 'Email or password incorrect' : ''; ?></span>
            </form><?php } else echo 'You are already logged in as '.$_SESSION['user_name_first'].' '.$_SESSION['user_name_last'].'. <a href="javascript:history.back();">Click here</a> to go back.'; ?>
          </div><!-- .entry-content -->


          <footer class="entry-meta clearfix">
          </footer>
          <!-- .entry-meta -->
        </article>
        <!-- #post-1230 -->
      </div>
      <!-- .row -->


      <nav class="navigation-paging" id="nav-below">
        <h1 class="screen-reader-text">Post navigation</h1>
      </nav>
      <!-- #nav-below -->
    </div>
    <!-- #content .site-content -->
  </div>
  <!-- .row -->
</div>
<!-- #primary .content-area -->
<?php
  include_once('footer.php');
}

