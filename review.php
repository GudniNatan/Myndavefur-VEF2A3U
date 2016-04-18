<?php
//Session Timeout
require_once './includes/session_timeout.php';
require_once './includes/Images/Images.php';
require_once './includes/Categories/Categories.php';
require_once './includes/dbcon.php';
require_once './includes/formprocess.php';
//check if user is logged in, else redirect
if (!isset($_SESSION['username']) || !isset($_SESSION['upload'])) {
    header("Location: login.php");
    die();
}
$dbCategories = new Categories($conn);
if (isset($_POST['reviewImage']) && !isset($validReview)) {
	echo "Einhver villa kom upp.";
}
$result = true;
if (isset($validReview)) {
   	$dbImages = new Images($conn);

	for ($i=0; $i < count($nafn); $i++) {
		$result = $dbImages->newImage($nafn[$i], utf8_encode($_SESSION['upload'][$i]), $texti[$i], $flokkur[$i], $_SESSION['userID'], $visibility[$i]);
	}
	if ($result) {
		foreach ($_SESSION['upload'] as $key => $value) {
			rename("./img/temp/thumbs/thumb_" . $value, "./img/thumbs/thumb_" . $value);
			rename("./img/temp/large/" . $value, "./img/large/" . $value);
		}
		unset($_SESSION['upload']);
		header("Location: index.php");
    	die();
	}
}
if (isset($_POST['cancel'])) {
	foreach ($_SESSION['upload'] as $key => $value) {
		unlink("./img/temp/thumbs/thumb_" . $value);
		unlink("./img/temp/large/" . $value);
	}
	unset($_SESSION['upload']);
	header("Location: userpage.php");
    die();
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
    <?php if (!$result) {
	echo "Ekki gekk að bæta myndum í gagnagrunn.";
} ?>
    	<form method="post" action="" class="superForm">
    		<?php foreach ($_SESSION['upload'] as $key => $value): ?>
    		<div class="subForm"> 
	   			<img <?php $temp = utf8_encode($value); echo "src='./img/temp/thumbs/thumb_{$temp}'"; ?>>
	   			<div class="form-group">
		        	<p for="name<?php echo $key; ?>">Nafn á mynd:</p>
	   				<input type="text" name="nafn[]" value="<?php echo basename($value, "." . pathinfo($value)['extension']); ?>" required>
	        	</div>
	        	<div class="form-group">
		        	<p for="texti<?php echo $key; ?>">Texti með mynd:</p>
	   				<input type="text" name="texti[]">
	        	</div>
	        	<div class="form-group">
		        	<p for="flokkur[]">Flokkur:</p>
	   				<select name="flokkur[]">
	   					<?php foreach ($dbCategories->categoryList() as $key2 => $value2) : ?>
	   					<option value="<?php echo $key2+1; ?>"><?php echo $value2[1]; ?></option>
	   					<?php endforeach; ?>
	   				</select>
	        	</div>
	        	<div class="form-group">
		        	<p for="visibility[]">Friðhelgisvernd:</p>
	   				<select name="visibility[]">
	   					<option value="0">Opið Öllum</option>
	   					<option value="1">Falið, nema með hlekk</option>
	   					<option value="2">Falið öllum nema þér</option>
	   				</select>
	        	</div>
        	</div>
    		<?php endforeach; ?>
    		<div>
	    		<button name="reviewImage" type="submit" class="pure-button pure-input-1 pure-button-primary register">Samþykkja</button>
	    		<button name="cancel" type="submit" class="pure-button pure-input-1 pure-button-primary register">Eyða</button>
    		</div>
   		</form>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>