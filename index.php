<?php
    require_once("includes/initialize.php");

    if($session->is_logged_in())
        header("Location: main");
    else
        header("Location: login");
?>

