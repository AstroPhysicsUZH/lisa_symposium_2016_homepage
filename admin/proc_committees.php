<?php

require_once "lib/headerphp.php";
require_once "../data/events.php";
require_once "../lib/app.php";



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

</style>


</head>
<body>
    <h1>Committees</h1>
    <h2>Science Advisory Committee (SAC)</h2>
    <table>
        <tr>
<?php
    $news = csv_to_array('../data/science_advisory_committee.csv');
    // sort by date, newest on top
    function compare_lastname($a, $b)
    {
        return strnatcmp($a['last_name'], $b['last_name']);
    }
    usort($news, 'compare_lastname');

    echo "<td><ul>\n";
    $ii = 0;
    foreach ($news as $v) {
        echo "  <li>{$v['first_name']} {$v['last_name']}</li>\n";
        if ($ii == (count($news)/2)-1) {
            echo "</ul></td><td><ul>";
        }
        $ii += 1;
    }
    echo "</ul></td>\n";

?>
        </tr>
    </table>

    <h2>Local Organizing Committee (LOC)</h2>
    <table>
        <tr>
            <td>

                <ul>
                    <li><b>Domenico Giardini</b></li>
                    <li><b>Philippe Jetzer</b></li>
                    <li>Ruxandra Bondarescu</li>
                    <li>Yannick Bötzel</li>
                    <li>Luigi Ferraioli</li>
                    <li>Carmelina Genovese</li>
                    <li>Elisabeth L&auml;derach</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>Rafael Küng</li>
                    <li>Davor Mance</li>
                    <li>Neda Meshksar</li>
                    <li>Lionel Philippoz</li>
                    <li>Jan Ten Pierick</li>
                    <li>Andreas Schärer</li>
                    <li>Peter Zweifel</li>
                </ul>
            </td>
        </tr>
    </table>

</body>
</html>
