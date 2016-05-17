<?php

/**
 *  Admin interface sends updates tor payment page here
**/

require_once "../lib/app.php";

print_r($_POST);



try {
    // Create (connect to) SQLite database (creates if not exists)
    $db = open_db();
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
}


?>
