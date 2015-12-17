<?php
header('Content-Type: text/html; charset=utf-8');
include("../reg_functions.php");

$BGCOLOR = array("#dddddd", "#eeeeee");
$data = get_data();

$total = count_participants();


# Delete participations address
if( isset( $_GET['delete'] ) )
{
  $id = $_GET['delete'];
  delete_data( $id );
  header("Location: index.php");
} 

?>

<html>
<head>
<title>eLISA / LPF board meeting</title>
<link rel="stylesheet" href="../style.css">
<link rel="shortcut icon" href="/favicon.ico">
</head>

<body>

<table height="5%"><tr><td></td><tr></table>

<center>
<table width="100%">
<tr>

<td valign="middle" align="center">

 <table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td width="950" height="500" bgcolor="#ffffff">
	<table width="100%" height="50%" cellspacing="0" cellpadding="0" border="0">
	 <tr height="135">
	  <td><img src="../head.jpg" width="950"></td>
	 </tr>
	 <tr>
	  <td align="left" id="navbar" height="20"> 
          </td>
	 </tr>
	 <tr height="460">
	  <td align="center" valign="top">
	   <table width="100%" border="0" cellspacing="10" cellpadding="10">
	    <tr>
	     <td valign="top" align="justify" id="normaltext">

<h2>List of Participations</h2>

<table border="0" cellpadding="3" cellspacing="5">
 <tr><td><b>Total number of attendees</b></td><td><?php print $total[0] ?></td></tr>
 <tr><td><b>LPF/MoND attendees</b></td><td><?php print $total[1] ?></td></tr>
 <tr><td><b>eLISA Consortium Meeting attendees</b></td><td><?php print $total[2] ?></td></tr>
 <tr><td><b>conference dinner attendees</b></td><td><?php print $total[3] ?></td></tr>
</table>

<br>
Send a <a href="mailto:<?php print emailstr() ?>">mail</a> to everybody.

<br><br>

<table border="0" cellpadding="5" cellspacing="0" width="100%">
 <tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Email</b></td><td><b>Affiliation</b></td><td><b>LPF/MoND</b></td><td><b>eLISA Consortium Meeting</b></td><td><b>Dinner</b></td><td><b>Date</b></td><td><td></td></tr>
<?php
  foreach( $data as $i => $hash )
  {
     $bg = $BGCOLOR[$i%2];
     $hash[mond] == "on" ? $mond_color="#00b515" : $mond_color=$bg;
     $hash[elisa] == "on" ? $elisa_color="#00b515" : $elisa_color=$bg;
     $hash[dinner] == "on" ? $dinner_text="yes" : $dinner_text="no";
     
     print "<tr bgcolor=\"$bg\"><td id=\"small\">$hash[firstname]</td><td id=\"small\">$hash[lastname]</td><td id=\"small\">$hash[email]</td><td id=\"small\">$hash[affiliation]</td><td bgcolor=\"$mond_color\"> </td><td bgcolor=\"$elisa_color\"> </td><td align=\"center\">$dinner_text</td><td id=\"small\">$hash[date]</td><td></td>";
     print "</td><td><a href=\"$PHP_SELF?mode=participations&delete=$i\"><img src=\"delete.gif\" height=\"20\" border=\"0\"></a>&nbsp;<a href=\"edit.php?edit=$i\"><img src=\"edit.gif\" height=\"20\" border=\"0\"></a></td></tr>";
  }
?> 
</table>

                                                          	     
             </td>
            </tr>
           </table>
          </td>
	 </tr>
	 <tr>
	  <td align="right" id="navbar">&nbsp;</td>
	 </tr>
	</table>

   </td>
  </tr>
 </table>

</td>

</tr>
</table>
</center>

<br><br><br>

</body>
</html>
