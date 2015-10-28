<?php

require_once("../includes/initialize.php");

// redirect to main page if already logged in
if ($session->is_logged_in()) {
    header("Location: ../main");
    exit;
}

if(isset($_POST["submit"])) {
	$username = trim($_POST['username']);
	$password = $_POST['password'];
    
    	$user = User::authenticate($username, $password);
    	if($user) {
    		$session->login($user);
    		header("Location: ../main");
    	}
    	else {
    		Session::setMessage("Incorrect username or password");    		
    	}
    
}
?>

<?php include_once("../includes/layouts/header.php"); ?>

<div id="content">
    <p><a href="../register">+ Create account</a></p>
    <h3>Login</h3>
    <?php
    	   $message = Session::getMessage();
        if($message) {
        	echo "<p>". htmlentities($message) . "</p>";
        }
    ?>
    
    <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" value=""><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" value=""><br><br>

        <input type="submit" name="submit" value="Login">
        
    </form>
</div>

<?php
include_once("../includes/layouts/footer.php");
?>
