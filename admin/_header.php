<?php
/**
    Index generator for the admin area
**/

require_once "../lib/app.php";


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

    <script src='../js/jquery-1.12.1.min.js'></script>
    <script src='../js/moment.min.js'></script>
</head>

<body>


<div id="wrap">
    <header>
        <h1>LISA Symposium</h1>
        <h2>Admin area</h2>
    </header>

    <nav>
<?php
require "_menu.php";
?>
    </nav>

    <div id="main">
