<?php

  include 'funcs.php';

  header('Content-Type: text/html; charset=utf-8');

  // Sanity checks

  if (array_key_exists('page', $_GET)) { $page = $_GET['page']; }
  else { $page = NULL; }

  if (in_array(basename($page), $PAGES)) { $page = basename($page); }
  else { $page = "overview"; }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>LISA Symposium Meeting; 5. -- 9. Sept. 2016; University of Zurich</title>
  
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Rafael Kueng <rafi.kueng@gmx.ch>" >
  <meta name="designer" content="Rafael Kueng <rafi.kueng@gmx.ch>" >
  
  <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="shortcut icon" href="/favicon.ico">


</head>

<body>
<div id="wrapper">

<header>
  <h1>11th International LISA Symposium</h1>
  <h2>5. &ndash; 9. September 2016<br>Irchel Campus, University of Zurich, Switzerland</h2>
</header>

<nav>
  <ul>
<?php
  # get menu
  print_menu($page);
?>
  </ul>
  
  <p id='contact'>
    contact:<br>
    <a href=''>lisa2016@physik.uzh.ch</a>
  </p>
</nav>

<main>
<?php
  # get main content
  if (file_exists("$page" . ".php")) { include("$page" . ".php"); }
  else { include("not_found.php"); }
?>
</main>

<!--
<?php
  # get side content
  if (file_exists("$page" . "_aside.php")) { include("$page" . "_aside.php"); }
  else { include("default_aside.php"); }
?>
-->


<footer>
  <img class="footerimg left" src="img/lisapf_logo.png" alt="lisa_pathfinder_logo" />
  <img class="footerimg" src="img/uzh.png" alt="uzhlogo" />
  <img class="footerimg" src="img/eth_logo.png" alt="ethlogo" />
  <img class="footerimg" src="img/pauli.png" alt="paulilogo" />
</footer>

</div>
</body>
</html>

