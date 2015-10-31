<?php
    require_once("../includes/initialize.php");

	if($session->is_logged_in()) {
		Session::setMessage("You have been logged out");
		$user = User::find_by_id($session->user_id);
    		Logger::log("User: " . $user->username . " has logged out");
		$session->logout();
	}
    
    header("Location: ../");
    exit;
?>
