<?php
include("reg_functions.php");

$ERROR = false;

function err( $text )
{
   global $ERROR;
   if($ERROR==false) print("<h3><font color=\"red\">$text</font></h3>");
   $ERROR = true;
}

if(isset($_POST['register']))
{
  if(empty($_POST['firstname'])) err( "Please give a valid first name" );
  if(empty($_POST['lastname'])) err( "Please give a valid last name" );
  if(empty($_POST['affiliation'])) err( "Please give a valid affiliation" );
  if(!strstr($_POST['email'], '@')) err( "Please give a valid email address" );
  
  $hash['firstname'] = $_POST['firstname'];
  $hash['lastname'] = $_POST['lastname'];
  $hash['affiliation'] = $_POST['affiliation'];

  $hash['email'] = $_POST['email'];
  $hash['confirmemail'] = $_POST['confirmemail'];


  if( strcmp( $hash['email'], $hash['confirmemail']) != 0) err( "The two email addresses you have given us do not agree. Please check the email fields again." );
  
  $hash['mond'] = $_POST['mond'];
  $hash['elisa'] = $_POST['elisa'];
  $hash['dinner'] = $_POST['dinner'];

  if( $hash['mond'] != "on" && $hash['elisa'] != "on") err( "Please enroll for at least one meeting." );

  $hash['mond'] == "on" ? $mond_checked = "checked" : $mond_checked = "";
  $hash['elisa'] == "on" ? $elisa_checked = "checked" : $elisa_checked = ""; 
  $hash['dinner'] == "on" ? $dinner_checked = "checked" : $dinner_checked = "";

  $hash['date'] = date("d.m.Y",time());
  


  if(!$ERROR)
  {
    $data = get_data();
    $data[] = $hash;
    store_data( $data );

    $hash['mond'] == "on" ? $attends_mond = "yes" : $attends_mond = "no";
    $hash['elisa'] == "on" ? $attends_elisa = "yes" : $attends_elisa = "no"; 
    $hash['dinner'] == "on" ? $attends_dinner = "yes" : $attends_dinner = "no";
 
    $mailbody = $hash['firstname'] . " " . $hash['lastname'] . " <" . $hash['email'] . "> \n" . $hash['affiliation'] . "\n\nAttended meetings:\nLPF/MoND: $attends_mond\neLISA Consortium meeting: $attends_elisa\n\nAttends conference dinner: $attends_dinner";

    mail_utf8("chuwyler@physik.uzh.ch", "New Registration: " . $hash['firstname'] . " " . $hash['lastname'], $mailbody);

    print("<center><h3><font color=\"red\">Thank you, you have been registered.</font></h3><br><br>You can find a list of hotels on the <a href=\"index.php?page=accomodation\">accomodation</a> page.</center>");
  }

}

if($ERROR || !isset($_POST['register']))
{
?>

<h2>Registration form</h2>

<table border="0" width="70%">
 <tr>
  <td>
   There is no registration fee. Please tell us if and on what days
   you will attend the meeting, this will help us organizing the lecture halls, coffee breaks, etc.
  </td>
 </tr>
</table>
<br><br>

<form method="post" action="<?php print $_SERVER['PHP_SELF'] ?>?page=registration">
<table border="0" cellspacing="5" cellpadding="5">
 <tr>
  <td id="normaltext"><b>First Name</b></td><td><input type="text" name="firstname" value="<?php print $hash['firstname'] ?>" size="15"> &nbsp;&nbsp; <b>Last Name</b></td><td><input type="text" name="lastname" value="<?php print $hash['lastname'] ?>"size="15"></td>
 </tr>
  <tr>
  <td id="normaltext"><b>Affiliation</b></td><td><input type="text" name="affiliation" value="<?php print $hash['affiliation'] ?>" size="30"></td><td></td>
 </tr>
 <tr>
  <td id="normaltext"><b>Email</b></td><td><input type="text" name="email" value="<?php print $hash['email'] ?>" size="15"> &nbsp;&nbsp; <b>Confirm Email</b></td><td><input type="text" name="confirmemail" value="<?php print $hash['confirmemail'] ?>" size="15"></td>
 </tr>
 <tr>
  <td colspan="3"></td>
 </tr>
 <tr>
  <td id="normaltext" valign="top"><b>I attend the</b></td><td id="normaltext" valign="top" colspan="2"><input type="checkbox" name="mond" <?php print $mond_checked ?>> Testing Alternative Theories of Gravity with LPF Workshop (10 March)<br> <input type="checkbox" name="elisa" <?php print $elisa_checked ?>> eLISA Consortium Meeting (12/13 March)<br> <input type="checkbox" name="dinner" <?php print $dinner_checked ?>> conference dinner on Wednesday (cost participation: approx. CHF 50)</td>
 </tr>
 <tr>
  <td><input type="submit" name="register" value="Register" disabled></td><td colspan="2"> <font color="#ff0000">(closed)</font></td><td></td>
 </tr>
</table>
</form>

<?php
}
?>