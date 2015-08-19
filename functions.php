<?php
/**
 * Functions
 *
 * All function definitions for the site
 */

/**
 * Sanitize text
 *
 * First, use FILTER_SANITIZE_STRING to filter raw input
 * Next, if length is specificied, trim to length.
 *
 * @param  string $unfiltered The unfiltered text
 * @param  int    $length The length of the string
 * @return string
 * @var    string $new The sanitized string
 */
function _text( $unfiltered, $length = 0 ) {
  $new = filter_var( addslashes($unfiltered), FILTER_SANITIZE_STRING ); 

  $length = (int) $length;

  if ( $length != 0 )
    return substr($new, 0, $length);
  else
    return $new;
}

/**
 * Sanitize email
 *
 * Use FILTER_SANITIZE_EMAIL to filter raw input
 *
 * @param  string $unfiltered The unfiltered email
 * @return string
 */
function _email($unfiltered) {
  return filter_var( addslashes($unfiltered), FILTER_SANITIZE_EMAIL ); 
}

/**
 * Validate method
 *
 * First, use _text to filter raw input
 * Next, validate filtered input against methods
 *
 * @param  string $unfiltered The unfiltered method
 * @return mixed
 * @var    string $new The filtered method
 */
function _method($unfiltered) {
  $new = _text($unfiltered);
  
  if (
    'get' === $new ||
    'set' === $new ||
    'new' === $new ||
    'del' === $new
  ) {
    return $new;
  }
  else {
    return false;
  }
}

/**
 * Validate class
 *
 * First, use _text to filter raw input
 * Next, validate filtered input against classes
 *
 * @param  string $unfiltered The unfiltered class
 * @return mixed
 * @var    string $new The filtered class
 */
function _class($unfiltered) {
  $new = _text($unfiltered);
  
  if (
    'extra' === $new ||
    'plan' === $new ||
    'site' === $new ||
    'subscription' === $new ||
    'user' === $new
  ) {
    return $new;
  }
  else {
    return false;
  }
}

/**
 * Validates that a foreign key is correct
 *
 * @since 0.0.3
 *
 *
 * @param string $input The key to be validated
 * @param string $table The table to check
 * @param string $match The column to check (e.g. sub_id)
 * @return bool
 *
 */
function fcc_validate_fk($input, $table, $match) {
  global $fccdb;

  $input = (int) $input;

  $conn = $fccdb->connect();
  
  try {
    $query = $conn->query("SELECT * from $table WHERE $match=$input");
    $matches = ($query->rowCount()!==0);
    $conn = null;
    return $matches;
  }
  catch (PDOException $e) {
    $conn = null;
    die ('Query failed: ' . $e->getMessage());
  }
}

/**
 * Rounds a dollar amount to cents
 *
 * @since 0.0.3
 *
 *
 * @param string $input The string to be validated
 * @return float
 *
 */
function fcc_validate_dollars($input) {
  return round(floatval($input),2);
}

/**
 * Checks to see if anyone is logged in
 *
 * @since 0.0.3
 *
 * @uses get_user() Gets user object to make sure user actually exists
 *
 * @return bool
 * @var    int    $u_id  The ID of the user logged in
 * @var    object $_user The user object with the ID of the user logged in
 *
 * @todo Do additional checks besides just if the id exists
 */
function is_logged_in() {
  if (!empty($_SESSION['user_id'])) {
    global $edb;
    $user_id = (int) $_SESSION['user_id'];
    $_user = user::get_instance($user_id);
    return !empty($_user);
  }
  else {
    return false;
  }
}
