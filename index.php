<?php
    include 'funcs.php';
    
    header('Content-Type: text/html; charset=utf-8');
    $PAGE = $_GET['page'];

    // Prevent skript skiddies from fucking around
    $PAGE = basename($PAGE);
    #$PAGE = ereg_replace("\.", "GO_AWAY", $PAGE);
    #$PAGE = ereg_replace("\.\.", "GO_AWAY", $PAGE);
    $PAGE = ereg_replace("~", "GO_AWAY", $PAGE);

    if(empty($PAGE)) $PAGE = "overview";
    
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>LISA Consortium Meeting Sept 2016</title>
  
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Rafael Kueng <rafi.kueng@gmx.ch>" >
  <meta name="designer" content="Rafael Kueng <rafi.kueng@gmx.ch>" >
  
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="shortcut icon" href="/favicon.ico">
</head>

<body>
<div id="wrapper">

<header>
  <h1>LISA Symposium</h1>
  <h2>September 2016</h2>
</header>

<nav>
  <ul>
<?php print_menu($PAGE); ?>
  </ul>
</nav>

<article>
  <h1>Welcome</h1>
  <p>
    Dear eLISA Consortium members,<br>
    the year 2013 has brought a big step forward with the choice of «The Gravitational Universe» as an approved Science Theme with a firm launch slot as L3 mission in the ESA program.
    The next step after the successful LISA Pathfinder flight in 2015 will be the selection of the specific mission concept to be flown.
    To make rapid progress in this direction it has been decided by the Consortium Board to held on 12 and 13 March a full eLISA Consortium Meeting which will be held in Zurich.
    On 10 March we will also have a workshop on «Testing Alternative Theories of Gravity with LPF».
  </p>
  
  <h2>Programme</h2>
  <p>
    On Wednesday evening there will be a conference dinner at the Dozentenfoyer at the ETH Zürich.
    Please indicate in your registration if you like to come
    (cost participation: approx. CHF 50). 
  </p>
  
  <h2>Participants</h2>
  <p>
    You can find a list of all participants here.
  </p>
  
  <h2>Location</h2>
  <p>
    The meeting will take place at the University of Zürich Irchel campus.
    Please check the programme for more information on the associated rooms.
    For information about how to get there, please consult the travel information page.
  </p>
</article>

<aside>
  <h1>Contact:</h1>
  <p>Philippe Jetzer</p>
  <h1>Organisation comitee</h1>
  <p>
    Ruxandra Bondarescu<br>
    Lionel Philippoz<br>
    Andreas Schärer<br>
    Rafael Küng<br>
    Yannick Bötzel
  </p>
</aside>

<footer>
  2016; Physik-Institut; University of Zurich
</footer>

</div>
</body>
</html>


<!--


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

-->
