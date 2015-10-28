<?php
    require_once("../includes/initialize.php");

	if($session->is_logged_in()) {
		Session::setMessage("You have been logged out");
		$session->logout();
	}
    
    header("Location: ../");
?>
