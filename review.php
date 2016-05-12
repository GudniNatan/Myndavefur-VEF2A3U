<?php
//Session Timeout
require_once './includes/session_timeout.php';
require_once './includes/Images/Images.php';
require_once './includes/Categories/Categories.php';
require_once './includes/AnalyzeImage/AnalyzeImage.php';
require_once './includes/dbcon.php';
require_once './includes/formprocess.php';
//check if user is logged in, else redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
if (!isset($_SESSION['upload'])) {
	header("Location: userpage.php");
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

		$filesize[$i] = filesize("./img/temp/large/" . $_SESSION['upload'][$i]);
		$imagetype[$i] = exif_imagetype("./img/temp/large/" . $_SESSION['upload'][$i]);
		$result = $dbImages->newImage($nafn[$i], utf8_encode($_SESSION['upload'][$i]), $texti[$i], $flokkur[$i], $_SESSION['userID'], $visibility[$i], $filesize[$i], $imagetype[$i]);
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
    	<form method="post" action="" class="superForm" id="reviewForm">
    		<?php 
    			$chw = getcwd();
    			chdir('./includes/');
    		 ?>
    		<?php foreach ($_SESSION['upload'] as $key => $value): ?>
    		<?php
				$AnalyzeImage = new AnalyzeImage("http://tsuts.tskoli.is/2t/1803982879/VEF2A3U/Myndavefur/img/temp/large/{$value}");
		   		$imageInfo = json_decode($AnalyzeImage->Analyze(),true);
		   		if (isset($imageInfo['categories'][0]["name"])) {
					$AssignedCategory = $imageInfo['categories'][0]["name"];
		   			$AssignedCategoryNumber = $dbCategories->getCategoryID($AssignedCategory);
		   		}
		   		if (isset($imageInfo['description']['captions'][0]["text"])) {
		   			$AssignedDescription = $imageInfo['description']['captions'][0]["text"];
		   		}
    		?>
    		<div class="subForm"> 
	   			<img <?php $temp = utf8_encode($value); echo "src='./img/temp/thumbs/thumb_{$temp}'"; ?>>
	   			<div class="form-group">
		        	<p for="name<?php echo $key; ?>">Nafn á mynd:</p>
	   				<input type="text" name="nafn[]" value="<?php echo basename($value, "." . pathinfo($value)['extension']); ?>" required class="form-control input-md">
	        	</div>
	        	<div class="form-group">
		        	<p for="texti<?php echo $key; ?>">Texti með mynd:</p>
	   				<textarea form="reviewForm" name="texti[]" rows="4" cols="50" placeholder="Texti með mynd..." class="form-control input-md"><?php if (isset($AssignedDescription)) {echo $AssignedDescription;} ?></textarea>
	        	</div>
	        	<div class="form-group">
		        	<p for="flokkur[]">Flokkur:</p>
	   				<select name="flokkur[]" class="form-control">
	   					<?php foreach ($dbCategories->categoryList() as $key2 => $value2) : ?>
	   					<option value="<?php echo $key2+1; ?>" <?php if (isset($AssignedCategoryNumber[0]) && $AssignedCategoryNumber[0] == $key2+1){echo "selected='selected'";}  ?>><?php echo $value2[1]; ?></option>
	   					<?php endforeach; ?>
	   				</select>
	        	</div>
	        	<div class="form-group">
		        	<p for="visibility[]">Friðhelgisvernd:</p>
	   				<select name="visibility[]" class="form-control">
	   					<option value="1">Opið Öllum</option>
	   					<option value="2">Falið, nema með hlekk</option>
	   					<option value="3">Falið öllum nema þér</option>
	   				</select>
	        	</div>
        	</div>
    		<?php endforeach; ?>
    		<?php 
    			chdir($chw);
    		 ?>
    		<div class="fullWidth center">
	    		<button name="reviewImage" type="submit" class="btn btn-primary">Samþykkja</button>
	    		<button name="cancel" type="submit" class="btn btn-warning">Eyða</button>
    		</div>
   		</form>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>