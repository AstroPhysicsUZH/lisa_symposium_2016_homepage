<?php

require_once('auth_config.php');
session_start();

if (
        ( ! ( isset($_SESSION['uid']) && $_SESSION['uid']) )
    or  ( isset($_SESSION['ip']) &&  ! $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] )
    or  ( ($_SESSION['last_action'] + SESSION_MAX_IDLE_TIME) < time() )
) {

    header('Status: 403 Forbidden');
    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login.php');
    #print_r($_SESSION);
    #echo SESSION_MAX_IDLE_TIME;
    #echo $_SESSION['last_action'] + SESSION_MAX_IDLE_TIME;
    #echo "auto logout";
    exit;
}

$_SESSION['last_action'] = time();
$_SESSION['loggedin'] = TRUE;  // need to set this here for get login
// Kein Exit, da das aufrufende Skript weiter arbeiten muss!

?>
