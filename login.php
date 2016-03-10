<?php
    //Starts session and checks timeout
	require_once './includes/session_timeout.php';
 ?>
<?php require'./includes/formprocess.php'; ?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  require("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
    	<?php if ($missing || $errors) { ?>
    	<div class="message">
			<p class="warning"><label>Lagaðu eftirfarandi villur.</label></p>
			<ul>
			<?php if ($errors) {
				foreach ($errors as $key => $value) {
					echo "<li>{$value}</li>";
				}
			} ?>
			</ul>
		</div>
		<?php if (isset($_GET["expired"]) && $_GET["expired"] == 'yes'): ?>
		<div class="message">
			<h2 class="warning">Your session has expired</p>
		</div>
		<?php endif ?>
		<?php } ?>
        <?php include("./includes/loginform.php") ?>
        <?php include("./includes/registerform.php") ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>