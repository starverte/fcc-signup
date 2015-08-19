<?php
session_start();
global $the_title;
$the_title = 'Edit Profile';
include_once('header.php');
if ($_SESSION['user_id'] === $_REQUEST['id'] || $_SESSION['user_level'] >= 99) {
  if (!empty($_POST['email'])) {
    user::set_instance($_REQUEST['id'], $_POST['email'], $_POST['first'], $_POST['last'], null, $_POST['company'] ?: null, $_POST['level'] ?: null);
    header('Location: ../'.$_REQUEST['id']);
    exit;
  } else {
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
            <form action="./<?php echo $_REQUEST['id'] ?>" method="POST"> <?php $u = user::get_instance(+$_REQUEST['id']); ?>
              <label>Email: </label> <input type="text" name="email" value="<?php echo $u->user_email; ?>" /> <br />
              <label>First Name: </label> <input type="text" name="first" value="<?php echo $u->user_name_first; ?>" /> <br />
              <label>Last Name:</label> <input type="text" name="last" value="<?php echo $u->user_name_last; ?>" /> <br />
              <label>Company</label> <input type="text" name="company" value="<?php echo $u->user_company; ?>" /> <br />
              <?php $a = Address::get_instance($u->user_address);
                if ($a->addr_id) { ?>
              <h3>Address</h3><br />
                <label>Street: </label> <input type="text" name="street" value="<?php echo $a->addr_street; ?>" /><br />
                <label>Street Line 2: </label> <input type="text" name="street2" value="<?php echo $a->addr_street_2; ?>" /><br />
                <label>City: </label> <input type="text" name="city" value="<?php echo $a->addr_city; ?>" /><br />
                <label>State: </label> <input type="text" name="state" value="<?php echo $a->addr_state; ?>" maxlength="2" /><br />
                <label>Zip Code: </label> <input type="text" name="zipcode" value="<?php echo $a->addr_zip_code; ?>" /><br />
              <?php } if ($_SESSION['user_level'] > 99) { ?>
              <h3>Admin Only: </h3>
              <label>Level: </label> <input type="text" name="level" value="<?php echo $u->user_level; ?>" /><span>10 is default, 100 is admin</span> <br />
              <?php } ?>
              <input type="submit" />
            </form>
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
  
<?php include_once('footer.php');}}
else {
  if (!is_logged_in()) {
    header('Location: ../../login.php?goto=.%2fuser%2fedit%2f'.$_REQUEST['id']);
    exit();
  }
  else {?>
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
            <p>You do not have sufficient priviledges to view this page. Try <a href="../../logout.php?goto=.%2flogin.php%3fgoto%3d.%252fuser%252fedit%252f<?php echo $_REQUEST['id']?>">logging out and then logging in again</a> as someone with more priviledges.</p>
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
  <?php include_once('footer.php');
  }
}
