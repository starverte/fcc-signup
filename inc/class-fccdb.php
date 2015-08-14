<?php
/**
 * Defines fccdb class and related functions
 *
 * @author Star Verte LLC
 */

/**
 * fccdb class
 *
 * Connects to database and creates object.
 *
 * @author Star Verte LLC
 */
class fccdb {

  /**
   * Connect to database
   *
   * @param string $dbuser     The user connecting to the database
   * @param string $dbpassword The password for the user connecting to the database
   * @param string $dbhost     The host of the database (i.e. 'localhost')
   *
   * @return object PHP Data Object
   *
   * @var object $conn PHP Data Object
   */
  function connect( $dbuser = DB_USER, $dbpassword = DB_PASSWORD, $dbhost = DB_HOST, $dbname = DB_NAME ) {

    $dbname     = empty($dbname)     ? $this->dbname     : $dbname;
    $dbuser     = empty($dbuser)     ? $this->dbuser     : $dbuser;
    $dbpassword = empty($dbpassword) ? $this->dbpassword : $dbpassword;
    $dbhost     = empty($dbhost)     ? $this->dbhost     : $dbhost;
    $dbname     = empty($dbname)     ? $this->dbname     : $dbname;

    $conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    return $conn;
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
   * @param  string       $query The SQL query to be executed
   * @return object|array        stdClass object or array of stdClass objects containing data from
   * @var    string       $conn  The PHP Data Object
   */
  function query( $query ) {

    $conn = $this->connect();

    try {

      $query = $conn->query($query);

      do {
        if ($query->columnCount() > 0) {
          $results = $query->fetchAll(PDO::FETCH_OBJ);
        }
      }
      while ($query->nextRowset());

      if (empty($results)) {
        $insertID = $conn->lastInsertId();
        $conn = null;
        return $insertID;
      }
      else {
        $conn = null;
        return $results;
      }
    }
    catch (PDOException $e) {
      $conn = null;
      die ('Query failed: ' . $e->getMessage());
    }

  }

  /**
   * Execute delete statement
   *
   * Build a SQL delete statement, and execute the statement
   *
   * @uses fccdb::query()
   *
   * @param string $table   The database table to delete from
   * @param int $statement  The stqatement to delete
   *
   * @var    string $query The select statement to be executed
   */
  function delete($table, $statement) {
    /**
     * Build the query
     */
    $query = "DELETE FROM $table WHERE $statement";

    /**
     * Execute the query
     */
    $this->query($query);

  }

  /**
   * Execute select statement
   *
   * Build a SQL select statement, and execute the statement
   *
   * @uses fccdb::query()
   *
   * @param string $table   The database table to query
   * @param string $columns The columns or data fields to query from the table
   * @param string $match   Search condition for row
   * @param array  $args    Additional, optional parameters (see below)
   *
   * @return array         Data results
   * @var    string $query The select statement to be executed
   */
  function select( $table, $columns = '*', $match = NULL, $args = array() ) {

    /**
     * Default parameters for select statement
     *
     * @param string $groupby Group by expression
     * @param string $having  Search condition for group
     * @param string $orderby Order expression
     * @param string $order   Ascending or descending ('ASC' or 'DESC')
     */
    $defaults = array(
      'groupby' => '',
      'having'  => '',
      'orderby' => '',
      'order'   => 'ASC',
    );

    /**
     * Parse connection arguments
     */
    $args = array_merge( $defaults, $args );

    /**
     * Build the query
     */
    $query  = '';
    $query .= 'SELECT ' . $columns;
    $query .= ' FROM ' . $table;
    $query .= !empty($match)         ? ' WHERE '    . $match         : '';
    $query .= !empty($args->groupby) ? ' GROUP BY ' . $args->groupby : '';
    $query .= !empty($args->having)  ? ' HAVING '   . $args->having  : '';
    $query .= !empty($args->orderby) ? ' ORDER BY ' . $args->orderby . ' ' . $args->order : '';
    $query .= ';';

    /**
     * Execute the query
     */
    $results = $this->query($query);
    return $results;

  }

  /**
   * Insert data into the database
   *
   * Build a SQL insert statement, and execute the statement
   *
   * @uses fccdb::query()
   *
   * @param string $table   The database table that the data will be inserted into
   * @param string $columns The columns, delimited by commas, that specifies which data will be inserted
   * @param array  $values  A one-dimensional array of comma-separated values to be inserted into the database
   *
   * @return void
   * @var string $query The insert statement to be executed
   *
   * @todo Change $values to sanitize input and not require strings to be in quotes
   */
  function insert( $table, $columns, $values ) {

    /**
     * Build the query
     */
    $query  = '';
    $query .= 'INSERT INTO ' . $table . ' (' . $columns . ')';
    $query .= ' VALUES (' . $values . ')';
    $query .= ';';

    /**
     * If there are multiple rows, make sure they are comma-separated
     */
    $query = preg_replace('/\)\(/', '\), \(', $query);

    /**
     * Execute the query
     */
    $results = $this->query($query);
    return $results;

  }

  /**
   * Update data in database
   *
   * Build a SQL update statement, and execute the statement
   *
   * @uses fccdb::query()
   *
   * @param string $table The table where the data will be updated
   * @param string $new The column name and new value (i.e. "name = 'Bob'")
   * @param string $match The search condition to limit which rows are updated
   *
   * @return void
   * @var string $query The update statement to be executed
   *
   * @todo Change $new to allow multi-dimensional array input
   */
  function update( $table, $new, $match ) {

    /**
     * Build the query
     */
    $query  = '';
    $query .= 'UPDATE ' . $table;
    $query .= ' SET '   . $new;
    $query .= ' WHERE ' . $match;
    $query .= ';';

    /**
     * Execute the query
     */
    $results = $this->query($query);
    return $results;

  }

}

