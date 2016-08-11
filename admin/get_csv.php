<?php

require "lib/headerphp.php";

$all_people = $db->query( "SELECT * FROM {$tableName}")->fetchAll(PDO::FETCH_OBJ);

foreach($all_people as $p) {

    foreach ($p as $key => $value) {
        print json_encode($value) . '; ';
    }
    print "\n";
}

?>
