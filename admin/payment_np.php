
<?php

require_once "lib/header.php";

$not_payed_people = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed
    FROM {$tableName}
    WHERE hasPayed<>1");

$sel_people = $not_payed_people;

$h2tit = "List of people that haven't yet payed";

require_once "lib/payment.php";
require_once "lib/footer.php";
