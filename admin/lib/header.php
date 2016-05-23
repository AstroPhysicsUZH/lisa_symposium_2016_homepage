<?php
/**
    Index generator for the admin area
**/

require_once "user.php";
require_once "../lib/app.php";

$USER = new User();

try {
    // Create (connect to) SQLite database (creates if not exists)
    $db = open_db();
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
}

header('Content-Type: text/html; charset=utf-8');

?>

<html>

<head>
    <title>LISA meeting - administraion area</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="css/style.css">

    <script src='../js/jquery/jquery.min.js'></script>
    <script src='../js/jquery.are-you-sure/jquery.are-you-sure.js'></script>
    <script src='../js/moment/moment.min.js'></script>
    <script src='js/sha1.js'></script>
    <script src='js/user.js'></script>
</head>

<body>


<div id="wrap">
    <header>
<?php if($USER->authenticated) { ?>
        <form class="loggedinbox" name="log out" id="logout" action="index.php" method="POST">
            <input type="hidden" name="op" value="logout"/>
            <input type="hidden" name="username"value="<?php echo $_SESSION["username"]; ?>" />
            <p>
                Logged in as <?php echo $_SESSION["username"]," ($USER->role)"; ?>
                <input type="submit" value="log out"/>
            </p>
        </form>
<?php } ?>

        <h1>LISA Symposium</h1>
        <h2>Admin area</h2>

    </header>

    <nav>
<?php if($USER->authenticated) {require "menu.php";} ?>
    </nav>

    <div id="main">

<?php

# if not logged in, show login form
if(!$USER->authenticated) {
?>

    <!-- Allow a user to log in -->
		<form class="controlbox" name="log in" id="login" action="index.php" method="POST">
			<input type="hidden" name="op" value="login"/>
			<input type="hidden" name="sha1" value=""/>
			<table>
				<tr><td>user name </td><td><input type="text" name="username" value="" /></td></tr>
				<tr><td>password </td><td><input type="password" name="password1" value="" /></td></tr>
			</table>
			<input type="button" value="log in" onclick="User.processLogin()"/>
		</form>
<?php
    require_once "footer.php";
    exit;
}

# check if user really has access to this module
if($USER->authenticated) {
    $curr_fn = basename($_SERVER["SCRIPT_FILENAME"]);
    if (! in_array($USER->role, $get_acl[$curr_fn]) ) {
        print "$curr_fn: Access Error";
        require_once "footer.php";
        exit;
    }
}



?>