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
<div class="containall">
    <?php include("./includes/menu.php") ?>
    <main>
        <?php include("./includes/imageupload.php") ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</body>
</html>
