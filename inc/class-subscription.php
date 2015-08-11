<?php
/**
 * Defines class subscription and related functions
 *
 * @author CJ Dvorak
 */

/**
 * subscription class
 *
 * Connects to database and creates subscription object.
 *
 * @author CJ Dvorak
 * @since 0.2.0
 */
class subscription {

  /**
   * @var int $sub_id The ID of the subscription
   */
  public $sub_id;
  
  /**
   * @var string $sub_plan The plan of the subscription
   */
  public $sub_plan = '';
  
  /**
   * @var string $sub_user The owner of the subscription
   */
  public $sub_user = '';
  
  /**
   * @var string $sub_date_created The date the sub was created
   */
  public $sub_date_created = '';
  
  /**
   * @var string $sub_balance The outstanding balance on the subscription
   */
  public $sub_balance = '';
  
  /**
   * @var string $sub_status The status of the subscription
   */
  public $sub_status = '';
  
  /**
   * @var string $sub_pmt_schedule The schedule for payments for the subscription
   */
  public $sub_pmt_schedule = '';

  /**
   * Construct subscription object
   *
   * Takes PDO and constructs subscription class
   *
   * @since 0.0.4
   *
   * @param  object $subscriptions The PHP Data Object
   */
  public function __construct( $subscriptions ) {
    foreach ( $subscriptions as $subscription ) {
      get_class($subscription);
      foreach ( $subscription as $key => $value )
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
   * Get subscription information from database
   *
   * Prepare and execute query to select subscription from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $sub_id The primary key of the subscription being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $sub_id ) {
    global $fccdb;

    $sub_id = (int) $sub_id;

    if ( ! $sub_id )
      return false;

    $_subscription = self::query("SELECT * FROM subscriptions WHERE sub_id = $sub_id LIMIT 1");

    return new subscription ( $_subscription );
  }

  /**
   * Insert subscription in database
   *
   * Prepare and execute query to create subscription in subscriptions table
   *
   * @since 0.0.4
   *
   * @uses fccdb::insert()
   * @uses fccdb::lastInsertId()
   * @uses _text()
   *
   * @param string $sub_name  The name of the subscription
   * @param float $sub_cost    The variable cost of the subscription
   * @param string $sub_desc    The description of the subscription
   *
   * @return void
   *
   * @var int $sub_id The primary key of the subscription being registered, as created in subscription database
   *
   * @todo Test
   */
  public static function new_instance( $sub_plan,$sub_user,$sub_balance,$sub_status,$sub_pmt_schedule ) {
    global $fccdb;

    $sub_plan = !empty($sub_plan) && fcc_validate_fk($sub_plan, 'plans', 'plan_id') ? floatval($sub_plan) : '5';
    $sub_user = !empty($sub_user) && fcc_validate_fk($sub_user, 'users', 'user_id') ? floatval($sub_user) : '1';
    $sub_date_created = date('Y-m-d H:i:s');
    $sub_balance = !empty($sub_balance) ? fcc_validate_dollars($sub_balance) : '1.00';
    $sub_status = !empty($sub_status) ? _text($sub_status, 32) : 'new';
    $sub_pmt_schedule = $sub_pmt_schedule === 'yearly' ? 'yearly' : 'monthly';

    return $fccdb->insert('subscriptions', 'sub_plan,sub_user,sub_date_created,sub_balance,sub_status,sub_pmt_schedule', "$sub_plan,$sub_user,NOW(),$sub_balance,'$sub_status','$sub_pmt_schedule'" );
  }

  /**
   * Update subscription in database
   *
   * Prepare and execute query to create subscription in subscriptions table
   *
   * @since 0.2.0
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $sub_id      The ID of the subscription to update
   * @param string $sub_name    The name of the subscription
   * @param float  $sub_cost    The variable cost of the subscription
   * @param string $sub_desc    The description of the subscription
   *
   * @return void
   *
   * @var int $sub_id The primary key of the subscription being registered, as created in subscription database
   *
   * @todo Test
   */
  public static function set_instance( $sub_id, $sub_plan=null, $sub_user=null, $sub_balance=null, $sub_status=null, $sub_pmt_schedule=null ) {
    global $fccdb;

    $sub_id = (int) $sub_id;

    $_subscription = self::get_instance( $sub_id );

    $sub_plan = !empty($sub_plan) && fcc_validate_fk($sub_plan, 'plans', 'plan_id') ? $sub_plan : $_subscription->sub_plan;
    $sub_user = !empty($sub_user) && fcc_validate_fk($sub_user, 'users', 'user_id') ? $sub_user : $_subscription->sub_user;
    $sub_balance = !empty($sub_balance) ? fcc_validate_dollars($sub_balance) : $_subscription->sub_balance;
    $sub_status = !empty($sub_status) ? _text($sub_status, 32) : $_subscription->sub_status;
    $sub_pmt_schedule = !empty($sub_pmt_schedule) ? _text($sub_pmt_schedule, 32): $_subscription->sub_pmt_schedule;

    $fccdb->update('subscriptions', "sub_plan=$sub_plan,sub_user=$sub_user,sub_balance=$sub_balance,sub_status='$sub_status',sub_pmt_schedule='$sub_pmt_schedule'", "sub_id = $sub_id" );
  }
}