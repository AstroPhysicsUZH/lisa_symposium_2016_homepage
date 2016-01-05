<?php
    include 'funcs.php';
    
    header('Content-Type: text/html; charset=utf-8');
    if (array_key_exists('page', $_GET)) {
        $PAGE = $_GET['page'];
    }
    else {
        $PAGE = NULL;
    }

    // Prevent skript skiddies from fucking around
    $PAGE = basename($PAGE);
    #$PAGE = ereg_replace("\.", "GO_AWAY", $PAGE);
    #$PAGE = ereg_replace("\.\.", "GO_AWAY", $PAGE);
    #$PAGE = preg_replace("~", "GO_AWAY", $PAGE);

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

<?php
  if (file_exists("$PAGE" . ".php")) { include("$PAGE" . ".php"); }
  else { print "<article><h1>Page not found!</h1></article>"; }
?>

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
