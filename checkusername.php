<?php 
	require_once './includes/session_timeout.php';
	require_once './includes/dbcon.php';
    require_once './includes/Users/Users.php';

	if (!isset($_POST['username'])) {
		die();
	}
	$dbUsers = new Users($conn);

	$user = $dbUsers->getUserByUsername($_POST['username']);

	if (empty($user)) {
		die();
	}
	$_SESSION['tempusername'] = $_POST['username'];
	echo json_encode($user);
