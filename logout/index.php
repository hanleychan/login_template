<?php
    require_once("../includes/initialize.php");

	if($session->is_logged_in()) {
		$session->logout();
	}
    
    header("Location: ../");
?>
