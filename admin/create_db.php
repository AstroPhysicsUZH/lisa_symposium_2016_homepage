<?php

/**
    Use this script to initially create a database.
    Only run it once, doesn't do anything if database exists.

    Can also be used to test the database connection..

    use `sqlite3 registration.sqlite ".databases"` to create a ampty db from
    command line
**/

require_once "../lib/app.php";

try {
    // Create (connect to) SQLite database (creates if not exists)
    $db = open_db();

    // Create table
    // -------------------------------------------------------------------------

    $createTableFields = array();
    foreach ($tableFields as $key => $elems) {
        $type = $elems[0];
        $createTableFields[] = "$key $type";
    }
    $createTableFields = implode(",", $createTableFields);

    $db->exec(  "CREATE TABLE IF NOT EXISTS {$tableName} (
                    id INTEGER PRIMARY KEY,
                    {$createTableFields}
                )"
        );

    // Close file db connection
    // -------------------------------------------------------------------------
    $db = null;

    // write csv header
    $header = implode(", ", array_keys($tableFields));
    file_put_contents($csv_db_name, "id,".$header, FILE_APPEND | LOCK_EX);
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
}
?>
