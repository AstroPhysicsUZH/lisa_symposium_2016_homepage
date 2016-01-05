<?php
header('Content-Type: text/html; charset=utf-8');
include("reg_functions.php");

$BGCOLOR = array("#dddddd", "#eeeeee");
$data = get_data();

$total = count_participants();

function compareByName($a, $b) 
{
  return strcmp(ucfirst($a["lastname"]), ucfirst($b["lastname"]));
}

usort($data, 'compareByName');

?>

<h2>List of Participants</h2>

<table border="0" cellpadding="5" cellspacing="0" width="100%">
 <tr><td><b>Name</b></td><td><b>Affiliation</b></td><td><b>LPF Alternative Theories Workshop</b></td><td><b>eLISA Consortium Meeting</b></td><td><b>Conference Dinner</b></td><td></tr>
<?php
  foreach( $data as $i => $hash )
  {
     $bg = $BGCOLOR[$i%2];
     $hash[mond] == "on" ? $mond_color="#00b515" : $mond_color=$bg;
     $hash[elisa] == "on" ? $elisa_color="#00b515" : $elisa_color=$bg;
     $hash[dinner] == "on" ? $dinner_text="yes" : $dinner_text="no";
     
     print "<tr bgcolor=\"$bg\"><td id=\"small\">$hash[firstname] $hash[lastname]</td><td id=\"small\">$hash[affiliation]</td><td bgcolor=\"$mond_color\"> </td><td bgcolor=\"$elisa_color\"> </td><td align=\"center\">$dinner_text</td>";
  }
?> 
</table>
