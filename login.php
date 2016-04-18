<?php
    //Starts session and checks timeout
	require_once './includes/session_timeout.php';
	require_once './includes/dbcon.php';
    require_once './includes/Users/Users.php';
 ?>
<?php require'./includes/formprocess.php'; ?>
<?php
$status = false;
$dbUsers = new Users($conn);

if (isset($validRegister)) {//Validated
	$status = $dbUsers->newUser($firstname,$lastname,$email,$username,$password, $sq1, $sq1ans, $sq2, $sq2ans);

	if ($status) {
		$success = "$username has been registered. You may now log in.";
	}else{
		$errors['Username'] = "{$username} is already in use. Please choose another username.";
   	}
}
if (isset($validLogin)) {
	$status = $dbUsers->validateUser($login_username,$login_password);

	if ($status) {
		$success = "Logged In";
	}else{
		$errors['Password'] = "Notendanafn eða aðgangsorð er ekki rétt. Vinsamlegast reyndu aftur.";
   	}
}
if ((isset($validRegister) || isset($validLogin)) && $status) {//Valid
    $_SESSION['username'] = (isset($username) ? htmlspecialchars($username) : htmlspecialchars($login_username));
    $_SESSION['userID'] = $dbUsers->getUserByUsername($_SESSION['username'])[0];
    $user = $dbUsers->getUser($_SESSION['userID']);
    $_SESSION['first_name'] = $user[1];
    $_SESSION['last_name'] = $user[2];
    $_SESSION['user_email'] = $user[3];
    $_SESSION['start'] = time();
    header('Location: userpage.php');
}
?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  require("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
    	<?php if ($missing || $errors) { ?>
    	<div class="fullWidthCenter">
			<div class="info">
				<div>
					<p>Lagaðu eftirfarandi <span class="warning">villur</span>.</p>
					
					<?php if ($errors): ?>
					<ul>
					<?phpu
						foreach ($errors as $key => $value) {
							if (is_array($value)) {
								echo "<li>";
								print_r($value);
								echo "</li>";
							}
							else{
								echo "<li>{$value}</li>";
							}
						}
					?>
					</ul>
					<?php endif; ?>					
				</div>
			</div>
		</div>			
		<?php } ?>
		<?php if (isset($_GET["expired"]) && $_GET["expired"] == 'yes'): ?>
		<div class="fullWidthCenter">
			<div class="info">
				<div>
					<p>
				    	Innskráningartími hefur <span class="warning">runnið út</span>.
					</p>
					<p>
						Vinsamlegast <span class="warning">skráðu þig inn</span> aftur.
					</p>
				</div>
			</div>
		</div>

		<?php endif ?>
		<?php if (isset($success)): ?>
		<div class="fullWidthCenter">
			<div class="info">
				<div>
					<p><?php echo $success; ?></p>
				</div>
			</div>
		</div>

		<?php endif ?>

        <?php include("./includes/loginform.php") ?>
        <?php include("./includes/registerform.php") ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>