<?php
require_once("../includes/initialize.php");

// redirect to main page if already logged in
if($session->is_logged_in()) {
    header("Location: ../main");
    exit;
}

// Process submitted form data
if(isset($_POST["submit"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    $passwordErrors=User::validatePassword($password, $password2);
    $usernameErrors=User::validateUsername($username);

    $errors = null;

    if(!empty($passwordErrors) && !empty($usernameErrors))
        $errors = array_merge($usernameErrors, $passwordErrors);
    elseif(!empty($usernameErrors))
        $errors = $usernameErrors;
    elseif(!empty($passwordErrors))
        $errors = $passwordErrors;

    // No errors.  Create the user
    if(empty($errors)) {
    		$result = User::addUser($username, $password);
    		Session::setMessage("You have successfully registered");
		Logger::log("User: " . htmlentities($username) . " has registered");
    		header("Location: ../");
		exit;
    }
}
?>


<?php include_once("../includes/layouts/header.php"); ?>

<div id="content">
    <p><a href="../login">Login here</a></p>
    <h3>Create Account</h3>
    <?php

        $message = Session::getMessage();
        if($message) {
        	echo "<p>". htmlentities($message) . "</p>";
        }
    
        if(isset($errors)) {
            for($count=0;$count<count($errors);$count++) {
                echo "<p>" . $errors[$count] . "</p>";
            }
        }
    ?>
    
    <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" value=""><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" value=""><br>

        <label for="password2">Confirm Password</label><br>
        <input type="password" id="password2" name="password2" value=""><br><br>
        

        <input type="submit" name="submit" value="Create user">
        
    </form>
</div>

<?php
include_once("../includes/layouts/footer.php");
?>
