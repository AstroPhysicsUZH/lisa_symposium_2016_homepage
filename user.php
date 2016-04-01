<!--
<?php
require_once "lib/app.php";
$db_address = 'sqlite:db/registration.sqlite3';

$data = null;

try {
    $db = open_db();

    $stmt = $db->prepare("SELECT * FROM {$tableName} WHERE accessKey = :akey");


    if ($stmt->execute(array(':akey'=>$_GET['akey']))) {
        while ($row = $stmt->fetch()) {
            print_r($row);
            $data = $row;
        }
    }

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

-->
<h1>Participants corner</h1>
<p>
    <?=$data['title']?> <?=$data['firstname']?> <?=$data['lastname']?> <br>
    price: <?=$data['price']?> <br>
    has payed: <?=$data['hasPayed']?> <br>
</p>
