<?php
    session_start();
    #check if user is logged in, else redirect to 404 page
    #if (!isset($_SESSION['username'])) {
    #	header("Location: index.php");
	#	die();
    #}
 ?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  include("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
        <?php include("./includes/imageupload.php") ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>