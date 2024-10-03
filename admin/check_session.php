<?php

// Check if a login is established; if not, redirect to the login page.

// Start the session.

    session_start();

    if($_SESSION["login"] != true) {

        header("location: index.php");
        exit;
    }

?>