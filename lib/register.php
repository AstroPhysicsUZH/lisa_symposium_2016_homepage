<?php
  
  $filename = "../data/register.csv";
  
  require_once 'parsecsv.lib.php';
  
  $rtest = intval($_POST['robot']);
  $rtest = 32;

  if ($rtest != 32) {
    echo "<h1 style='text-align:center;'>You did not pass the robot test.<br> Please just enter the number 32..</h1>";
    var_dump($_POST);
    die(1);
  }

  echo "<hr>";
  
  $csv = new parseCSV();
  $csv->auto($filename);
  print_r($csv->data);
  
?>
