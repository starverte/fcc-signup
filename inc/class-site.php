<?php
/**
 * Defines class site and related functions
 *
 * @author CJ Dvorak
 */

/**
 * site class
 *
 * Connects to database and creates site object.
 *
 * @author CJ Dvorak
 * @since 0.2.0
 */
class site {

  /**
   * @var int $site_id The ID of the site
   */
  public $site_id;
  
  /**
   * @var string $site_user The owner of the site
   */
  public $site_user = '';
  
  /**
   * @var string $site_url The URL of the site
   */
  public $site_url = '';

  /**
   * Construct site object
   *
   * Takes PDO and constructs site class
   *
   * @since 0.0.4
   *
   * @param  object $sites The PHP Data Object
   */
  public function __construct( $sites ) {
    foreach ( $sites as $site ) {
      get_class($site);
      foreach ( $site as $key => $value )
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
   * Get site information from database
   *
   * Prepare and execute query to select site from database
   *
   * @since 0.0.4
   *
   * @uses self::query()
   *
   * @param  int    $site_id The primary key of the site being retrieved from the database
   * @return object         Data retrieved from database
   * @var    string $conn   The PHP Data Object for the connection
   */
  public static function get_instance( $site_id ) {
    global $fccdb;

    $site_id = (int) $site_id;

    if ( ! $site_id )
      return false;

    $_site = self::query("SELECT site_id, site_user, site_url FROM sites WHERE site_id = $site_id LIMIT 1");

    return new site ( $_site );
  }

  /**
   * Insert site in database
   *
   * Prepare and execute query to create site in sites table
   *
   * @since 0.0.4
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param string $site_name  The name of the site
   * @param float $site_cost    The variable cost of the site
   * @param string $site_desc    The description of the site
   *
   * @return void
   *
   * @var int $site_id The primary key of the site being registered, as created in site database
   *
   * @todo Test
   */
  public static function new_instance( $site_name, $site_cost = null, $site_desc = null ) {
    global $fccdb;

    $site_name  = _text( $site_name, 32 );
    $site_cost    = !empty($site_cost)    ? floatval($site_cost)    : '777777';
    $site_desc  = _text( $site_desc, 32 );

    $fccdb->insert('sites', 'site_name,site_cost,site_desc', "'$site_name', $site_cost, '$site_desc'" );
  }

  /**
   * Update site in database
   *
   * Prepare and execute query to create site in sites table
   *
   * @since 0.2.0
   *
   * @uses fccdb::insert()
   * @uses _text()
   *
   * @param int    $site_id      The ID of the site to update
   * @param string $site_name    The name of the site
   * @param float $site_cost      The variable cost of the site
   * @param string $site_desc    The description of the site
   *
   * @return void
   *
   * @var int $site_id The primary key of the site being registered, as created in site database
   *
   * @todo Test
   */
  public static function set_instance( $site_id, $site_name = null, $site_cost = null, $site_desc = null ) {
    global $fccdb;

    $site_id = (int) $site_id;

    $_site = self::get_instance( $site_id );

    $site_name    = !empty($site_name)  ? _text( $site_name, 32 ) : $_site->site_name;
    $site_cost      = !empty($site_cost)    ? floatval($site_cost)      : $_site->site_cost;
    $site_desc    = !empty($site_desc)  ? _text( $site_desc, 32 ) : $_site->site_desc;

    $fccdb->update('sites', 'site_name,site_cost,site_desc', "'$site_name', $site_cost, '$site_desc'", "site_id = $site_id" );
  }
}
