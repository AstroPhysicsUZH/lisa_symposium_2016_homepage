
<?php
require_once "_header.php";

$notPayed = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email
    FROM {$tableName}
    WHERE hasPayed<>1");

$payed = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, amountPayed
    FROM {$tableName}
    WHERE hasPayed=1");

?>


<h1>
    Manage Payments
</h1>

<form action="_update_payment.php" method="post">
<input type="submit" value="SAVE ALL CHANGES">

<h2>People that havent yet payed:</h2>

<table>
    <thead>

    </thead>
    <tbody>
<?php

foreach($notPayed as $p) {
    //print_r($p);
    print("    <tr class='line_bot'>\n");
    print("        <td>{$p['id']}</td>\n");
    print("        <td>{$p['title']}</td>\n");
    print("        <td>{$p['firstname']}<br />{$p['lastname']}</td>\n");
    print("        <td>{$p['affiliation']}</td>\n");
    print("        <td><a href='mailto:{$p['email']}'>send<br />email</a></td>\n");
    print("
        <td>
            <label for='p{$p['id']}'>payed:</label>
            <input id='p{$p['id']}' name='p{$p['id']}' class='left' type='checkbox' value='X' />
        </td>\n");
    print("
        <td>
            <label for='nPersons'>amount (CHF)</label>
            <input id='a{$p['id']}' name='a{$p['id']}'
                class='left' type='number' style='width:8em;height:2em;text-align:center;'
                min='0' max='20000' />
        </td>\n");
    print("    </tr>\n");
}
?>
    </tbody>
</table>


<h2>People that have payed:</h2>
<table>
    <thead>

    </thead>
    <tbody>

<?php

foreach($payed as $p) {
    //print_r($p);
    print("    <tr class='line_bot'>\n");
    print("        <td>{$p['id']}</td>\n");
    print("        <td>{$p['title']}</td>\n");
    print("        <td>{$p['firstname']}<br />{$p['lastname']}</td>\n");
    print("        <td>{$p['affiliation']}</td>\n");
    print("        <td><a href='mailto:{$p['email']}'>send<br />email</a></td>\n");
    print("
        <td>
            <label for='p{$p['id']}'>payed:</label>
            <input id='p{$p['id']}' name='p{$p['id']}' class='left' type='checkbox' value='X' checked />
        </td>\n");
    print("
        <td>
            <label for='nPersons'>amount (CHF)</label>
            <input id='a{$p['id']}' name='a{$p['id']}'
                class='left' type='number' style='width:8em;height:2em;text-align:center;'
                value='{$p['amountPayed']}' min='0' max='20000' />
        </td>\n");
    print("    </tr>\n");
}
?>
    </tbody>
</table>

</form>


<?php require "_footer.php"; ?>
