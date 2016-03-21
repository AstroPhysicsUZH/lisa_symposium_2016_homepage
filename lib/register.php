<?php

$filename = "../data/register.csv";

require_once 'parsecsv.lib.php';

$rtest = intval($_POST['robot']);
$rtest = 37;
print_r($_POST);

if ($rtest != 37) {
    echo "<h1 style='text-align:center;'>You did not pass the robot test.<br> Please just enter the number 32..</h1>";
    var_dump($_POST);
    die(1);
}

// init to default values
// because checkboxes only give a value if checked..
$vals = [
    "first" => "",
    "last" => "",
    "email" => "",
    "affil" => "",
    "talk" => "none",
    "vegie" => FALSE,
    "nPers" => 1,
    "impared" => FALSE,
];

// parse string properties
foreach (["first","last", "email", "affil", "talk"] as $key) {
    if (isset($_POST[$key])) { $vals[$key] = $_POST[$key]; }
}

// parse bool properties
foreach (["vegie", "impared"] as $key) {
    if (isset($_POST[$key])) { $vals[$key] = TRUE; }
    else { $vals[$key] = FALSE; }
}

// parse int properties
foreach (["nPers"] as $key) {
    if (isset($_POST[$key])) { $vals[$key] = intval($_POST[$key]); }
    else { $vals[$key] = FALSE; }
}


print_r($vals);

echo "<hr>";

$csv = new parseCSV();
$csv->sort_by = 'email';
$csv->parse($filename);
$csv->data[$vals['email']] = $vals;
$csv->save();
print_r($csv->data);


$from = "LISA Website <lisa.website@fake_webhost.iiiirgendwo>";
$to1 = "rafik@physik.uzh.ch";
$to2 = "relativityUZH@gmail.com";
$subj = "[LISA] registration";
$msg  = "this is just an automated backup mail in case of database corruption\n\n";
$msg .= json_encode($vals);

$headers  = 'From: ' . $from . "\r\n";
$headers .= "Reply-To:" . $from . "\r\n" .
$headers .= "X-Mailer: PHP/" . phpversion();

mail($to1, $subj, $msg, $headers);
mail($to2, $subj, $msg, $headers);

?>
