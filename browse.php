<?php
    //Starts session and checks timeout
	require_once './includes/session_timeout.php';
	require_once './includes/dbcon.php';
 ?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  include("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
        <?php include("./includes/browseimage.php") ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
    <script src="js/changeImageArrowKeys.js"></script>
</body>
</html>
