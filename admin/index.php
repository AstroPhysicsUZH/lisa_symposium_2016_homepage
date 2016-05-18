<?php require "lib/header.php"; ?>

<?php
$nRows = (int)$db->query("SELECT count(*) FROM {$tableName}")->fetchColumn();
$nLunch = (int)$db->query("SELECT sum(nPersons) from {$tableName}")->fetchColumn();
$nVeggies = (int)$db->query("SELECT SUM(CASE WHEN isVeggie THEN nPersons ELSE 0 END) FROM {$tableName}")->fetchColumn();
?>

<h1>Welcome back</h1>
<h2>Overview</h2>
<p>
    We currently have:<br />
    <?=$nRows?> Persons registered <br />
    <?=$nLunch?> Lunchs to be served (of that <?=$nVeggies?> Veggies) <br />
</p>


<?php require "lib/footer.php" ?>
