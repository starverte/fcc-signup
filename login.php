<?php
include_once('config.php');
include_once('functions.php');
include_once('inc/class-fccdb.php');
include_once('inc/class-user.php');

$fccdb = new fccdb;

session_start();

if ( (!empty($_POST['mail']) && !empty($_POST['pw'])) && $u = User::login($_POST['mail'],$_POST['pw']) ) {
  $_SESSION['user'] = $u->user_id;
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
                
                <form action = "<?php echo empty($_REQUEST['goto']) ? './login.php' : './login.php?goto='.$_REQUEST['goto'] ?>" method="post">
                  <label>Email: </label><br />
                  <input name="mail" placeholder="Email" <?php echo empty($_REQUEST['mail']) ? '' : 'value=\''.$_REQUEST['mail'].'\''; ?> type="text" /><br />
                  <label>Password: </label><br />
                  <input name="pw" placeholder="***" type="password"><br />
                  <input name="submit" type="submit" value="Login"><br />
                  <span><?php echo $u; ?></span>
                </form>
              <!-- .entry-content -->


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

