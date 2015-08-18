<?php
/**
 * Users
 *
 * The template to display users
 *
 * @author Matt Beall
 * @since 0.0.1
 */

global $the_title;
$the_title = 'Profile';
include_once('header.php');
$user_id = $_REQUEST['id'] ?: $_SESSION['user_id'];
if (!is_logged_in() || ($_SESSION['user_level']<100 && $user_id!==$_REQUEST['id'])) {
  if ($_REQUEST['subs']) header("Location: ../../login.php?goto=.%2fuser%2f$user_id%2fsubs");
  else header("Location: ../login.php?goto=.%2fuser%2f$user_id");
}
$user = user::get_instance($user_id);?>
<style type="text/css">
  a.edit {
    float:right; margin-top: -3.5em
  }
</style>
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
                <h2>About</h2>
                <?php if ($_SESSION['user_id'] === $user_id || $_SESSION['user_level'] > 99) { ?>
                <a href="./edit/<?php echo $user_id ?>" class="btn btn-default edit" aria-label="Left Align">Edit</a>
                <?php } ?>
                <p>Name: <?php echo "$user->user_name_first $user->user_name_last" ?></p>

                <p>Email: <?php echo "<a href='mailto:$user->user_email'>$user->user_email</a>" ?></p>

                <p><?php echo $user->user_company ? "Works at: $user->user_company" : "$user->user_name_first $user->user_name_last hasn't entered his/her company yet" ?></p>
              </div>
            </div>

            <div class="shell col-lg-4 col-md-4 col-sm-6">
              <div class="card">
                <h2>Address</h2>

                <p><?php echo $user->user_address ? address::get_instance_pretty($user->user_address) : "$user->user_name_first $user->user_name_last hasn't entered his/her address yet" ?></p>
              </div>
            </div>

            <div class="shell col-lg-4 col-md-4 col-sm-6">
              <div class="card">
                <h2>Subscriptions</h2>
                <a href="./<?php echo $user_id ?>/subs" class="btn btn-default edit" aria-label="Left Align">View All</a>
                <?php
                  function date_sort($a, $b) {
                    if ($a->sub_date_created === $b->sub_date_created) return 0;
                    return ($a->sub_date_created < $b->sub_date_created) ? 1 : -1;
                  }
                  $subs = subscription::get_by_user($user_id);
                  usort($subs, "date_sort");
                  if ($subs) {
                    $len = count($subs);
                    $num = 0;
                    foreach ($subs as $_sub) {
                      if ($num > 2) break;
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
<?php include_once('footer.php');

