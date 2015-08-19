<?php
/**
 * Defines class Extra and related functions
 *
 * @author Star Verte LLC
 */

/**
 * Extra class
 *
 * Connects to database and creates extra object.
 *
 * @author Star Verte LLC
 */
class Extra {

  /**
   * @var int $extr_id The ID of the extra
   */
  public $extr_id;

  /**
   * @var string $extr_name The name of the extra
   */
  public $extr_name = '';

  /**
   * @var float $extr_cost The variable cost of the extra
   */
  public $extr_cost = 0.00;

  /**
   * @var string $extr_desc The description of the extra
   */
  public $extr_desc = '';

  /**
   * Construct Extra object
   *
   * Takes PDO and constructs Extra class
   *
   * @param  object $extras The PHP Data Object
   */
  public function __construct( $extras ) {
    foreach ( $extras as $extra ) {
      get_class($extra);
      foreach ( $extra as $key => $value )
        $this->$key = $value;
    }
  }

  /**
   * Execute query
   *
   * Attempt to connect to database and execute SQL query
   * If successful, return results.
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
      while ($query->nextRowset());

      $conn = null;

      return $results;
    }
    catch (PDOException $e) {
      $conn = null;
      die ('Query failed: ' . $e->getMessage());
    }
  }

  /**
   * Get extra information from database
   *
   * Prepare and execute query to select extra from database
   *
   * @uses self::query()
   *
   * @param  int    $extr_id The primary key of the extra being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $extr_id ) {
    global $fccdb;

    $extr_id = (int) $extr_id;

    if ( ! $extr_id )
      return false;

    $_extra = self::query("SELECT * FROM extras WHERE extr_id = $extr_id LIMIT 1");

    return new Extra ( $_extra );
  }

  /**
   * Insert extra in database
   *
   * Prepare and execute query to create extra in extras table
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param string $extr_name  The name of the extra
   * @param float $extr_cost    The variable cost of the extra
   * @param string $extr_desc    The description of the extra
   *
   * @return void
   *
   * @var int $extr_id The primary key of the extra being registered, as created in extra database
   *
   * @todo Test
   */
  public static function new_instance( $extr_name, $extr_cost = null, $extr_desc = null ) {
    global $fccdb;

    $extr_name  = _text( $extr_name, 32 );
    $extr_cost    = !empty($extr_cost)    ? floatval($extr_cost)    : '777777';
    $extr_desc  = _text( $extr_desc, 32 );

    $fccdb->insert('extras', 'extr_name,extr_cost,extr_desc', "'$extr_name', $extr_cost, '$extr_desc'" );
  }

  /**
   * Update extra in database
   *
   * Prepare and execute query to create extra in extras table
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $extr_id      The ID of the extra to update
   * @param string $extr_name    The name of the extra
   * @param float $extr_cost      The variable cost of the extra
   * @param string $extr_desc    The description of the extra
   *
   * @return void
   *
   * @var int $extr_id The primary key of the extra being registered, as created in extra database
   *
   * @todo Test
   */
  public static function set_instance( $extr_id, $extr_name = null, $extr_cost = null, $extr_desc = null ) {
    global $fccdb;

    $extr_id = (int) $extr_id;

    $_extra = self::get_instance( $extr_id );

    $extr_name    = !empty($extr_name)  ? _text( $extr_name, 32 ) : $_extra->extr_name;
    $extr_cost      = !empty($extr_cost)    ? floatval($extr_cost)      : $_extra->extr_cost;
    $extr_desc    = !empty($extr_desc)  ? _text( $extr_desc, 32 ) : $_extra->extr_desc;

    $fccdb->update('extras', 'extr_name,extr_cost,extr_desc', "'$extr_name', $extr_cost, '$extr_desc'", "extr_id = $extr_id" );
  }
}
