<?php
header('Content-Type: text/plain; charset=utf-8');
include("../reg_functions.php");
?>

<?php
  $data = get_data();

  function compareByName($a, $b)
  {
    return strcmp(ucfirst($a["lastname"]), ucfirst($b["lastname"]));
  }

  usort($data, 'compareByName');


  foreach( $data as $i => $hash )
  {
     print ucwords(strtolower($hash[firstname])) . " " . ucwords(strtolower($hash[lastname])) . ", $hash[email], $hash[affiliation]\n";
  }
?> 
