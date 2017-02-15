<?php

require_once "lib/headerphp.php";
require_once "../data/events.php";
require_once "../lib/app.php";


function print_table($people) {
    //print_r($people);
    print "
    <table style='width:100%;'>
        <tbody>
";

    foreach($people as $p) {
        print "<tr><td>
            {$p['title']} {$p['firstname']} {$p['lastname']} <span class='affil'>{$p['affiliation']}</span>
        </td></tr>";
    }

    print "
        </tbody>
    </table>
";
}

$addQuery = "";

$qry = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed, paymentNotes
    FROM {$tableName} " . $addQuery . ";" );
$sel_people = $qry->fetchAll(PDO::FETCH_ASSOC);
$qry = null;



function cmp($a, $b) {
    $fmt = 'Y-m-d\TH:i:s';
    return strcmp($a['lastname'], $b['lastname']);
}


usort($sel_people, "cmp");


?>
<html>
<head>
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="../css/fullcalendar.min.css">
    <link rel="stylesheet" href="../css/layout_hack.css">
    <script src="../js/jquery-1.12.1.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/fullcalendar.min.js"></script>

    <script src="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css">

<style>
.affil {
    font-size: 80%;
    font-style: italic;
}
</style>


</head>
<body>
    <h1>List of Participants</h1>
<?php

print_table($sel_people);

?>
</body>
</html>
