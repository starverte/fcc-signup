<?php
/**
 * Defines class Address and related functions
 *
 * @author CJ Dvorak
 */

/**
 * Address class
 *
 * Connects to database and creates Address object.
 *
 * @author CJ Dvorak
 * @since 0.2.0
 */
class Address {

  /**
   * @var int $addr_id The ID of the Address
   */
  public $addr_id;

  /**
   * @var string $addressestreet The street of the Address
   */
  public $addressestreet = '';

  /**
   * @var string $addr_city The city of the Address
   */
  public $addr_city = '';

  /**
   * @var string $addr_state The 2-character abbreviation of the state of the Address
   */
  public $addr_state = '';

  /**
   * @var int $addr_zip_code The zip_code of the Address
   */
  public $addr_zip_code = '';

  /**
   * Construct Address object
   *
   * Takes PDO and constructs Address class
   *
   * @since 0.0.4
   *
   * @param  object $Addresses The PHP Data Object
   */
  public function __construct( $Addresses ) {
    foreach ( $Addresses as $Address ) {
      get_class($Address);
      foreach ( $Address as $key => $value )
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
   * Get Address information from database
   *
   * Prepare and execute query to select Address from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $addr_id The primary key of the Address being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $addr_id ) {
    global $fccdb;

    $addr_id = (int) $addr_id;

    if ( ! $addr_id )
      return false;

    $_Address = self::query("SELECT * FROM addresses WHERE addr_id = $addr_id LIMIT 1");

    return new Address ( $_Address );
  }

  /**
   * Get Address information from database as a formatted string
   *
   * Prepare and execute query to select Address from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $addr_id The primary key of the Address being retrieved from the database
   * @param  bool   $nl     Whether or not there should a newline in the string
   * @return string         Address retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance_pretty( $addr_id, $nl=true) {
    global $fccdb;

    $addr_id = (int) $addr_id;

    if ( ! $addr_id )
      return false;

    $_Address = self::query("SELECT * FROM addresses WHERE addr_id = $addr_id LIMIT 1");

    $addr = new Address ( $_Address );

    if (!$addr->addr_id) {return false;}

    $nl = $nl ? "<br />" : ", ";
    $addr->addr_state = strtoupper($addr->addr_state);

    return "$addr->addr_street$nl$addr->addr_city, $addr->addr_state $addr->addr_zip_code";
  }

  /**
   * Insert Address in database
   *
   * Prepare and execute query to create Address in Addresses table
   *
   * @since 0.0.4
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param string $addr_name  The name of the Address
   * @param float $addr_cost    The variable cost of the Address
   * @param string $addr_desc    The description of the Address
   *
   * @return void
   *
   * @var int $addr_id The primary key of the Address being registered, as created in Address database
   *
   * @todo Test
   */
  public static function new_instance( $addr_name, $addr_cost = null, $Address_description = null ) {
    global $fccdb;

    $addr_name  = _text( $addr_name, 32 );
    $addr_cost    = !empty($addr_cost)    ? floatval($addr_cost)    : '777777';
    $addr_desc  = _text( $addr_desc, 32 );

    $fccdb->insert('addresses', 'addr_name,addr_cost,addr_desc', "'$addr_name', $addr_cost, '$addr_desc'" );
  }

  /**
   * Update Address in database
   *
   * Prepare and execute query to create Address in Addresses table
   *
   * @since 0.2.0
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $addr_id      The ID of the Address to update
   * @param string $addr_name    The name of the Address
   * @param float $addr_cost      The variable cost of the Address
   * @param string $addr_desc    The description of the Address
   *
   * @return void
   *
   * @var int $addr_id The primary key of the Address being registered, as created in Address database
   *
   * @todo Test
   */
  public static function set_instance( $addr_id, $addr_name = null, $addr_cost = null, $addr_desc = null ) {
    global $fccdb;

    $addr_id = (int) $addr_id;

    $_Address = self::get_instance( $addr_id );

    $addr_name    = !empty($addr_name)  ? _text( $addr_name, 32 ) : $_Address->addr_name;
    $addr_cost      = !empty($addr_cost)    ? floatval($addr_cost)      : $_Address->addr_cost;
    $addr_desc    = !empty($addr_desc)  ? _text( $addr_desc, 32 ) : $_Address->addr_desc;

    $fccdb->update('addresses', 'addr_name,addr_cost,addr_desc', "'$addr_name', $addr_cost, '$addr_desc'", "addr_id = $addr_id" );
  }
}
