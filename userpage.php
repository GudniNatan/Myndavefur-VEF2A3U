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
			unlink("./img/temp/thumbs/thumb_" . $value);
			unlink("./img/temp/large/" . $value);
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
        $success = $loader->getSuccessStatus();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if ($success) {
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
        <?php if (isset($result)): ?>        
        <div class="fullWidthCenter">
			<div class="info">
				<div>
					<p>Lagaðu eftirfarandi <span class="warning">villur</span>.</p>
					<?php
					    echo '<ul>';
					    foreach ($result as $message) {
					        echo "<li>$message</li>";
					    }
					    echo '</ul>';
					?>
				</div>
			</div>
		</div>
		<?php endif ?>
    	<form action="" method="post" enctype="multipart/form-data" id="uploadImage" class="updateImageDiv col-md-3 col-xs-10">	
		    <label>Veldu eina eða fleiri myndir til að hala upp (Max 2mb):</label>
		    <div class="form-group">
		    	<div class="input-group">
		            <span class="input-group-btn">
		                <span class="btn btn-default btn-file">
		                    Velja skár&hellip; <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
		                </span>
		            </span>
		            <input type="text" class="form-control" readonly>
		        </div>
		    </div>
            <p><i>Nafn, lýsing, tegund o.s.frv. valið á næstu síðu.</i></p>
		    <input type="submit" name="upload" id="upload" value="Hala upp skrá" class="btn btn-default">
		</form>
        <form action="" method="post" class="updateImageDiv col-md-3 col-xs-10">
            <label>Breyta grunnupplýsingum</label>
        	<div class="form-group">
	        	<p for="username">Notendanafn:
				<?php if ($missing && in_array('username', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	           	<input type="text" class="form-control input-md" name="username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" <?php if (isset($_SESSION['username'])) { echo 'value="' . htmlentities($_SESSION['username']) . '"'; } ?>>
	        </div>
	        <div class="form-group">
	           	<p for="password">Lykilorð:
				<?php if ($missing && in_array('password', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	        	<input type="password" class="form-control input-md" name="password" placeholder="Lykilorð*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Lykilorð" <?php if (($missing || $errors) && isset($password)) { echo 'value="' . htmlspecialchars($password) . '"'; } ?>>
	        </div>
	        <div class="form-group">
	        	<p for="email">Netfang:
				<?php if ($missing && in_array('email', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	        	<input type="email" class="form-control input-md" name="email" placeholder="Netfang*" required title="Netfang" <?php if (isset($_SESSION['user_email'])) { echo 'value="' . htmlentities($_SESSION['user_email']) . '"'; } ?>>
	        </div>
            <input type="submit" name="sendupdate" id="sendupdate" value="Update info" class="btn btn-default">
        </form>
        <div class="flexContainer">
	        <div style="width: 100%; text-align: center;">
				<h2>Þínar myndir</h2>
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
		        <a href="deleteimage.php?id=<?php echo $value[0]; ?>" class="warning">Eyða mynd</a>
			    <figure>
			        <a href='browse.php?img=<?php echo $value[0];?>'><img src='./img/thumbs/thumb_<?php echo $value[1];?>'></a>
			    </figure>
			</div>	
            <?php endforeach ?>
        </div>

    </main>
</div>
<?php include("./includes/footer.php") ?>
<script type="text/javascript">
	$(document).on('change', '.btn-file :file', function() {
	    var input = $(this),
	        numFiles = input.get(0).files ? input.get(0).files.length : 1,
	        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    input.trigger('fileselect', [numFiles, label, this]);
	});
	$(document).ready( function() {
	    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
	        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;
	        
	        if( input.length ) {
	            input.val(log);
	        } else {
	            if( log ) alert(log);
	        }
	        
	    });
	});
</script>
</body>
</html>
