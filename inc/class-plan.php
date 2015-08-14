<?php
/**
 * Defines class Plan and related functions
 *
 * @author CJ Dvorak
 */

/**
 * Plan class
 *
 * Connects to database and creates Plan object.
 *
 * @author CJ Dvorak
 * @since 0.2.0
 */
class Plan {

  /**
   * @var int $plan_id The ID of the Plan
   */
  public $plan_id;

  /**
   * @var string $plan_name The name of the Plan
   */
  public $plan_name = '';

  /**
   * @var float $plan_cost The variable cost of the Plan
   */
  public $plan_cost = 0.00;

  /**
   * @var string $plan_desc The description of the Plan
   */
  public $plan_desc = '';

  /**
   * Construct Plan object
   *
   * Takes PDO and constructs Plan class
   *
   * @since 0.0.4
   *
   * @param  object $Plans The PHP Data Object
   */
  public function __construct( $Plans ) {
    foreach ( $Plans as $Plan ) {
      get_class($Plan);
      foreach ( $Plan as $key => $value )
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
   * Get Plan information from database
   *
   * Prepare and execute query to select Plan from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $plan_id The primary key of the Plan being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $plan_id ) {
    global $fccdb;

    $plan_id = (int) $plan_id;

    if ( ! $plan_id )
      return false;

    $_Plan = self::query("SELECT * FROM plans WHERE plan_id = $plan_id LIMIT 1");

    return new Plan ( $_Plan );
  }

  /**
   * Insert Plan in database
   *
   * Prepare and execute query to create Plan in Plans table
   *
   * @since 0.0.4
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param string $plan_name  The name of the Plan
   * @param float $plan_cost    The variable cost of the Plan
   * @param string $plan_desc    The description of the Plan
   *
   * @return void
   *
   * @var int $plan_id The primary key of the Plan being registered, as created in Plan database
   *
   * @todo Test
   */
  public static function new_instance( $plan_name, $plan_cost = null, $Plan_description = null ) {
    global $fccdb;

    $plan_name  = _text( $plan_name, 32 );
    $plan_cost    = !empty($plan_cost)    ? floatval($plan_cost)    : '777777';
    $plan_desc  = _text( $plan_desc, 32 );

    $fccdb->insert('plans', 'plan_name,plan_cost,plan_desc', "'$plan_name', $plan_cost, '$plan_desc'" );
  }

  /**
   * Update Plan in database
   *
   * Prepare and execute query to create Plan in Plans table
   *
   * @since 0.2.0
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $plan_id      The ID of the Plan to update
   * @param string $plan_name    The name of the Plan
   * @param float $plan_cost      The variable cost of the Plan
   * @param string $plan_desc    The description of the Plan
   *
   * @return void
   *
   * @var int $plan_id The primary key of the Plan being registered, as created in Plan database
   *
   * @todo Test
   */
  public static function set_instance( $plan_id, $plan_name = null, $plan_cost = null, $plan_desc = null ) {
    global $fccdb;

    $plan_id = (int) $plan_id;

    $_Plan = self::get_instance( $plan_id );

    $plan_name    = !empty($plan_name)  ? _text( $plan_name, 32 ) : $_Plan->plan_name;
    $plan_cost      = !empty($plan_cost)    ? floatval($plan_cost)      : $_Plan->plan_cost;
    $plan_desc    = !empty($plan_desc)  ? _text( $plan_desc, 32 ) : $_Plan->plan_desc;

    $fccdb->update('plans', 'plan_name,plan_cost,plan_desc', "'$plan_name', $plan_cost, '$plan_desc'", "plan_id = $plan_id" );
  }
}
