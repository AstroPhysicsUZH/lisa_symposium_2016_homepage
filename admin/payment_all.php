
<?php

require_once "lib/header.php";

/*
$not_payed_people = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed
    FROM {$tableName}
    WHERE hasPayed<>1");
*/
$all_people = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed
    FROM {$tableName}")->fetchAll(PDO::FETCH_ASSOC);

$sel_people = $all_people;

$h2tit = "List of all people";

require_once "lib/payment.php";
require_once "lib/footer.php";
