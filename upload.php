<?php
//Session Timeout
require_once './includes/session_timeout.php';
require_once './includes/Images/Images.php';
//check if user is logged in, else redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
?>
<?php
require_once("./includes/getimages.php");
require_once './includes/Upload/Upload.php';

use Includes\Upload;

// set the maximum upload size in bytes
$max = 2048 * 1024; // 600 KB
if (isset($_POST['upload'])) {
    // define the path to the upload folder
    $destination = 'img/temp/large/';
    try {
        $loader = new Upload($destination);
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

//Gets all images user can delete.
//Replace with database
$filenames = buildFileList($dir, ['jpg', 'png', 'gif', 'jpeg']);

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    unlink($dir . $filenames[$id]);
    unlink($thumbdir . "thumb_" . $filenames[$id]);
    unset($filenames[$id]);
    natcasesort($filenames);
}

//Gets files in image dir
//Replace with database
function buildFileList($dir, $extensions) {
    if (!is_dir($dir) || !is_readable($dir)) {
        return false;
    } else {
        if (is_array($extensions)) {
            $extensions = implode('|', $extensions);
        }
        $pattern = "/\.(?:{$extensions})$/i";
        $folder = new FilesystemIterator($dir);
        $files = new RegexIterator($folder, $pattern);
        $filenames = [];
        foreach ($files as $file) {
            $filenames[] = $file->getFilename();
        }
        natcasesort($filenames);
        return $filenames;
    }
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
            <div class="form-group">
                <label>Skoða og eyða skrám</label>
                <select name="id">
                    <?php
                    foreach ($filenames as $key => $value) {
                        $name = basename($value);
                        echo "<option value='{$key}'>{$name}</option>";
                    } 
                    ?>
                </select>
            </div>
            <input type="submit" name="delete" id="delete" value="Delete image">
        </form>
        <?php  if (isset($_POST['upload'])) {
        }  
        ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
</body>
</html>
