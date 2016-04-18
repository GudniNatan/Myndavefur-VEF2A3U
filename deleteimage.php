<?php
//Check if user is logged in and trying to delete their own image
require_once './includes/session_timeout.php';
require_once './includes/dbcon.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
if (!isset($_GET["id"])) {
    header("Location: index.php");
    die();
}
$id = $_GET["id"];
$userID = $_SESSION['userID'];

require_once './includes/Images/Images.php';
$dbImages = new Images($conn);
$image = $dbImages->getImage($id);
if ($image[5] != $userID) {
	header("Location: userpage.php");
    die();
}
//Safe to delete
unlink("./img/thumbs/thumb_{$image[2]}");
unlink("./img/large/{$image[2]}");

$result = $dbImages->deleteImage($id);
if ($result) {
	header("Location: userpage.php");
    die();
}
else{
	echo "Eitthvað bilaði. <a href='userpage.php'>Til baka?</a>";
}