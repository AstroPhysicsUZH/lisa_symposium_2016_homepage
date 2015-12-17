<?php
header('Content-Type: text/html; charset=utf-8');
$PAGE = $_GET['page'];

// Prevent skript skiddies from fucking around
$PAGE = basename($PAGE);
#$PAGE = ereg_replace("\.", "GO_AWAY", $PAGE);
#$PAGE = ereg_replace("\.\.", "GO_AWAY", $PAGE);
$PAGE = ereg_replace("~", "GO_AWAY", $PAGE);

if(empty($PAGE)) $PAGE = "overview";
?>
<html>
<head>
<title>eLISA Consortium meeting March 2014</title>
<link rel="stylesheet" href="style.css">
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
	  <td><img src="head.jpg" width="950"></td>
	 </tr>
	 <tr>
	  <td align="left" id="navbar">
	     <table border="0" cellspacing="10">
 	      <tr>
	       <td width="20"></td>
	       <td id="navbar"><a href="?page=overview" id="navlink"><b>OVERVIEW</b></a></td>
               <td id="navtext"> | </td>
               <td id="navbar"><a href="?page=programme" id="navlink"><b>PROGRAMME</b></a></td>
               <td id="navtext"> | </td>
               <td id="navbar"><a href="?page=accomodation" id="navlink"><b>ACCOMODATION</b></a></td>
               <td id="navtext"> | </td>
               <td id="navbar"><a href="?page=travel" id="navlink"><b>TRAVEL</b></a></td>
               <td id="navtext"> | </td>
               <td id="navbar"><a href="?page=registration" id="navlink"><b>REGISTRATION</b></a></td>
               <td id="navtext"> | </td>
              </tr>
             </table>
           </td>
	 </tr>
	 <tr height="460">
	  <td align="center" valign="top">
	   <table width="100%" border="0" cellspacing="10" cellpadding="10">
	    <tr>
	     <td valign="top" align="justify" id="normaltext">
	      
             <?php
               if(file_exists("$PAGE" . ".php")) include("$PAGE" . ".php");
               else print "<br><h1>Page not found!</h1>";
             ?>
                                                          	     
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
