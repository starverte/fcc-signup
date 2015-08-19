<?php
/**
 * Defines class User and related functions
 *
 * @author CJ Dvorak
 */

/**
 * User class
 *
 * Connects to database and creates User object.
 *
 * @author CJ Dvorak
 * @since 0.2.0
 */
class User {

  /**
   * @var int $user_id The ID of the User
   */
  public $user_id;
  
  /**
   * @var string $user_desc The description of the User
   */
  public $user_email = '';

  /**
   * @var string $user_name The first name of the User
   */
  public $user_name_first = '';

  /**
   * @var float $user_cost The last name of the User
   */
  public $user_name_last = '';

  /**
   * @var float $user_cost The last name of the User
   */
  public $user_level = 10;

  /**
   * Construct User object
   *
   * Takes PDO and constructs User class
   *
   * @since 0.0.4
   *
   * @param  object $Users The PHP Data Object
   */
  public function __construct( $Users ) {
    foreach ( $Users as $User ) {
      get_class($User);
      foreach ( $User as $key => $value )
        $this->$key = $value;
    }
  }

  /**
   * Execute query
   *
   * Attempt to connect to database and execute SQL query
   * If successful, return results.
   *
   * @since 0.0.4
   *
   * @uses fccdb::connect()
   * @throws PDOException if connection or query cannot execute
   *
   * @param  string $query The SQL query to be executed
   * @return object        Data retrieved from database
   * @var    string $conn  The PHP Data Object
   */
  public static function query( $query ) {
    global $fccdb;
    $conn = $fccdb->connect();
    try {
      $query = $conn->query($query);
      do {
        if ($query->columnCount() > 0) {
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }
      }
      while ($query->nextrowset());

      $conn = null;

      return $results;
    }
    catch (PDOException $e) {
      $conn = null;
      die ('Query failed: ' . $e->getMessage());
    }
  }


  /**
   * Check if there is a user with that email + password
   *
   * Return user if correct password, false otherwise.
   *
   * @since 0.0.4
   *
   * @uses fccdb::connect()
   * @throws PDOException if connection or query cannot execute
   *
   * @param  string $mail  The email to be checked
   * @param  string $pw    The password to be checked
   * @return object or false
   */
  public static function login($mail, $pw) {
    global $fccdb;

    $mail = _text($mail);
    $pw = _text($pw);

    $q = self::query("SELECT * FROM users WHERE user_email = '$mail' AND user_password = '$pw' ORDER BY user_id DESC LIMIT 1");
    $u = new User ($q);
    return $u->user_id ? $u : false;
  }


  /**
   * Get User information from database
   *
   * Prepare and execute query to select User from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $user_id The primary key of the User being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $user_id ) {
    global $fccdb;

    $user_id = (int) $user_id;

    if ( ! $user_id )
      return false;

    $_User = self::query("SELECT user_id, user_email, user_name_first, user_name_last, user_address, user_company FROM users WHERE user_id = $user_id LIMIT 1");

    return new User ( $_User );
  }

  /**
   * Insert User in database
   *
   * Prepare and execute query to create User in Users table
   *
   * @since 0.0.4
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param string $user_name  The name of the User
   * @param float $user_cost    The variable cost of the User
   * @param string $user_desc    The description of the User
   *
   * @return void
   *
   * @var int $user_id The primary key of the User being registered, as created in User database
   *
   * @todo Test
   */
  public static function new_instance( $user_name, $user_cost = null, $user_desc = null ) {
    global $fccdb;

    $user_name  = _text( $user_name, 32 );
    $user_cost    = !empty($user_cost)    ? floatval($user_cost)    : '777777';
    $user_desc  = _text( $user_desc, 32 );

    $fccdb->insert('Users', 'user_name,user_cost,user_desc', "'$user_name', $user_cost, '$user_desc'" );
  }

  /**
   * Update User in database
   *
   * Prepare and execute query to create User in Users table
   *
   * @since 0.2.0
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $user_id         The ID of the User to update
   * @param string $user_email      The email of the user
   * @param string $user_name_first The user's first name
   * @param string $user_name_last  The user's last name
   * @param int    $user_address    The ID of the address of the user
   * @param string $user_company    Where the user works
   * @param int    $user_level      The level of the user (10 = default, 100 = admin)
   *
   * @return void
   *
   * @var int $user_id The primary key of the User being registered, as created in User database
   *
   * @todo Test
   */
  public static function set_instance( $user_id, $user_email = null, $user_name_first = null, $user_name_last = null, $user_address = null, $user_company = null, $user_level = null) {
    global $fccdb;

    $user_id = (int) $user_id;

    $_user = self::get_instance( $user_id );

    $user_email = empty($user_email) ? $_user->user_email : _email($user_email);
    $user_name_first = empty($user_name_first) ? $_user->user_name_first : _text($user_name_first);
    $user_name_last = empty($user_name_last) ? $_user->user_name_last : _text($user_name_last);
    $user_address = empty($user_address) ? $_user->user_address : +($user_address);
    $user_company = empty($user_company) ? $_user->user_company : _text($user_company);
    $user_level = empty($user_level) ? 10 : +($user_level);
    
    $fccdb->update('users', "user_email = '$user_email',user_name_first = '$user_name_first',user_name_last = '$user_name_last',user_address = $user_address,user_company = '$user_company',user_level = $user_level", "user_id = $user_id" );
  }
}
