<?php
//Start session
session_start();

// Unset all of the session variables.
$_SESSION = array();

//Delete cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session.
session_destroy();

//Redirect to index page
header("location:index.php");
?>