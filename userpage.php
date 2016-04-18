<?php
//Session Timeout
require_once './includes/session_timeout.php';
require_once './includes/dbcon.php';
require_once './includes/Images/Images.php';
require_once './includes/Users/Users.php';
//check if user is logged in, else redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
?>
<?php
require_once './includes/Upload/Upload.php';
require_once'./includes/formprocess.php';

use Includes\Upload;

// set the maximum upload size in bytes
$max = 2048 * 1024; // 600 KB
if (isset($_POST['upload'])) {
	if (isset($_SESSION['upload'])) {
		foreach ($_SESSION['upload'] as $key => $value) {
			unlink("./img/thumbs/thumb_" . $value);
			unlink("./img/large/" . $value);
		}
		unset($_SESSION['upload']);
	}
    // define the path to the upload folder
    $tempdestination = 'img/temp/large/';
    $destination = 'img/large/';
    try {
        $loader = new Upload($destination, $tempdestination);
        $loader->setMaxSize($max);
        $loader->upload();
        $result = $loader->getMessages();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if ($result) {
        if (isset($_SESSION['upload'])) {
            $_SESSION['upload'] = array_merge($_SESSION['upload'], $loader->getNameList());
        }
        else{
            $_SESSION['upload'] = $loader->getNameList();
        }
        header("Location: review.php");
        die();
    }
}
if (isset($validUpdate)) {
	$dbUsers = new Users($conn);
	$dbUsers->updateUser($_SESSION['userID'], $_SESSION['first_name'], $_SESSION['last_name'], $email, $username, $password );
	$_SESSION['username'] = $username;
	$_SESSION['user_email'] = $email;
}

//Gets all images user can delete.
//Replace with database
$dbImages = new Images($conn);
$filenames = $dbImages->imageList($_SESSION['userID']);

if (isset($_POST['delete'])) {
	//delete Code (rember to check if user has permission to delete image)
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
        <div class="fullWidthCenter mobileOnly">
            <div class="info">
                <div>
                    <p>User: <?php echo $_SESSION['username']; ?> | <a href="logout.php" class="warning">Logout</a></p>
                </div>
            </div>
        </div>
    	<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
	    	<?php
			if (isset($result)) {
			    echo '<ul>';
			    foreach ($result as $message) {
			        echo "<li>$message</li>";
			    }
			    echo '</ul>';
			}
			?>
            <div class="form-group">
		        <p><label>Select image to upload (Max 2mb):</label></p>
                <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
            </div>
            <p>Nafn, lýsing, tegund o.s.frv. valið á næstu síðu.</p>
		    <input type="submit" name="upload" id="upload" value="Upload">
		</form>
        <form action="" method="post">
            <label>Breyta grunnupplýsingum</label>
        	<div class="form-group">
	        	<p for="username">Notendanafn:
				<?php if ($missing && in_array('username', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	           	<input type="text" name="username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" <?php if (isset($_SESSION['username'])) { echo 'value="' . htmlentities($_SESSION['username']) . '"'; } ?>>
	        </div>
	        <div class="form-group">
	           	<p for="password">Lykilorð:
				<?php if ($missing && in_array('password', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	        	<input type="password" name="password" placeholder="Lykilorð*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Lykilorð" <?php if (($missing || $errors) && isset($password)) { echo 'value="' . htmlspecialchars($password) . '"'; } ?>>
	        </div>
	        <div class="form-group">
	        	<p for="email">Netfang:
				<?php if ($missing && in_array('email', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	        	<input type="email" name="email" placeholder="Netfang*" required title="Netfang" <?php if (isset($_SESSION['user_email'])) { echo 'value="' . htmlentities($_SESSION['user_email']) . '"'; } ?>>
	        </div>
            <input type="submit" name="sendupdate" id="sendupdate" value="Update info">
        </form>
        <div class="flexContainer">
	        <div style="width: 100%; text-align: center;">
				<label class="warning">Skoða og eyða skrám</label>
			</div>
			<?php if (empty($filenames)): ?>
			<div>
				<p>Hérna gætir þú séð myndirnar þínar... </p>
				<p>Ef þú ætti einhverjar.</p>
			</div>
			<?php endif ?>
            <?php foreach ($filenames as $key => $value):?>
            <div>
            	<?php $imageTitle = (strlen($value[2]) >= 40) ? substr($value[2], 0, 37)."..." : $value[2]; ?>
			    <p><?php echo htmlspecialchars($imageTitle)?></p>
		        <a href="deleteimage.php?id=<?php echo $value[0]; ?>">Delete image</a>
			    <figure>
			        <a href='browse.php?img=<?php echo $value[0];?>'><img src='./img/thumbs/thumb_<?php echo $value[1];?>'></a>
			    </figure>
			</div>	
            <?php endforeach ?>
        </div>

    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>
