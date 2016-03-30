<?php

require_once "lib/db_settings.php";


if (isset($_GET['mid'])){ $id = $_GET['mid']; }
else { $id = "no_msg"; }


if ($id == "no_msg") {
    echo "";
}

elseif ($id=="reg_suc") {
    echo "<h1>Registration successfull</h1>";
    echo "<p>We sent you a link to activate, check and modify your registration.</p>";
    echo "<ul>\n";
    echo "<li>userid: {$_GET['lid']}</li>\n";
    echo "<li>access key: {$_GET['akey']}</li>\n";
    echo "</ul>\n\n";

    echo "<h2>Payment Instructions</h2>";
    require "items/payment_instructions.php";
}

?>
