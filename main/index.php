<?php
    require_once("../includes/initialize.php");

	// redirect back to login page if not logged in
	if(!$session->is_logged_in()) {
		header("Location: ../login");
		exit;
	}
	
	$user = User::find_by_id($session->user_id);
    $username = htmlentities($user->username);
?>


<?php
include_once("../includes/layouts/header.php");
?>

<div id="content">
    <h3>Main Page</h3>
    <p>Hello <?php echo $username; ?></p>
    <p><a href="../logout">Logout</a></p>
</div>

<?php
include_once("../includes/layouts/footer.php");
?>
