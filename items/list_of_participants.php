<?php

/**
    Use this script for a simple database dump
**/

require_once "lib/app.php";

try {
    // Create (connect to) SQLite database (creates if not exists)
    $db = open_db($db_address_abs);

    // Create table
    // -------------------------------------------------------------------------
    $style = " style='border: 0px solid black;'";
    echo "<table{$style}'>\n";

    // Select all data from memory db messages table
    $result = $db->query("SELECT * FROM {$tableName}", PDO::FETCH_ASSOC);

    echo "  <tbody>\n";
    foreach($result as $r) {
        echo "    <tr>\n";
        echo "      <td{$style}>".nl2br(htmlentities($r['title'],FALSE))."</td>\n";
        echo "      <td{$style}>".nl2br(htmlentities($r['firstname'], FALSE))." ";
        echo " ".nl2br(htmlentities($r['lastname'], FALSE))."</td>\n";
        echo "      <td{$style}> (".nl2br(htmlentities($r['affiliation'], FALSE)).")</td>\n";
        echo "    </tr>\n";
    }
    echo "  </tbody>\n</table>\n";
    echo "</body></html>\n";

    // Close file db connection
    // -------------------------------------------------------------------------
    $db = null;
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
}
?>
