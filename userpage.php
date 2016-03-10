<?php require_once './includes/session_timeout.php'; 
//check if user is logged in, else redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  require("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
    	<h3>Kemur inn seinna</h3>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>
