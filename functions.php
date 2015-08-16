<?php
/**
 * Functions
 *
 * All function definitions for the site
 */

/**
 * Sanitize text input and trim to size
 *
 * First, make sure only numbers and letters are used.
 * Next, if length is specificied, trim to length.
 *
 * @param  string $text The string to sanitize
 * @param  int    $length The length of the string
 * @return string
 * @var    string $new The sanitized string
 */
function _text( $text, $length = 0 ) {
  $new = preg_replace( '[^0-9a-fA-F]', '', $text);

  $length = (int) $length;

  if ( $length != 0 )
    return substr($new, 0, $length);
  else
    return $new;
}

/**
 * Sanitize text input and trim to size
 *
 * First, make sure only numbers and letters are used.
 * Next, if length is specificied, trim to length.
 *
 * @param  string $text The string to sanitize
 * @param  int    $length The length of the string
 * @return string
 * @var    string $new The sanitized string
 */
function _method( $text ) {
  $new = preg_replace( '[^0-9a-fA-F]', '', $text);
  
  if ('get' === $new || 'set' === $new || 'new' === $new || 'del' === $new) {
    return $new;
  }
  else {
    return false;
  }
}

function fcc_validate_fk($input, $table, $match)
{
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

function fcc_validate_dollars($input)
{
  return round(floatval($input),2);
}
