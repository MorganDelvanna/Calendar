<?php
    session_start();

    echo "<!DOCTYPE html>\n<html>\n<head>\n";

    require_once "functions.php";

    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
        $loggedIn = TRUE;
    }
    else $loggedIn = FALSE;

    echo "\t<title>PFGA Calendar</title>\n" . 
        "\t<link rel='stylesheet' href='styles.css' type='text/css' />\n"  .
        "\t<script type='text/javascript' src='scripts\script.js'></script>\n" .
        "</head>\n<body>\n";


?>