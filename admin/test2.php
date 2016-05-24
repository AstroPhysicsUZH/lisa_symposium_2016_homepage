
<?php
require "lib/header.php";
?>


<p>
    testing of user system
</p>



<?php
print_r($USER);

print "<hr />";


try {
    $db = open_db('sqlite:../db/registration.sqlite3');


    $stmtstr = "UPDATE {$tableName} SET price='456' WHERE id = '1'";
    $stmt = $db->prepare($stmtstr);
    $res = $stmt->execute();
    print_r($res);

    $db = null;

}
catch(PDOException $e) {
    // Print PDOException message
    $db = null;
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
    die();
}





require "lib/footer.php"
?>
