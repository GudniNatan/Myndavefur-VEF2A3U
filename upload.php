<?php
//Session Timeout
require_once './includes/session_timeout.php';
//check if user is logged in, else redirect
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
?>
<?php
require_once("./includes/getimages.php");

use Includes\Upload;

// set the maximum upload size in bytes
$max = 2048 * 1024; // 600 KB
if (isset($_POST['upload'])) {
    // define the path to the upload folder
    $destination = 'img/large/';
    require_once 'includes/imageupload.php';
    try {
        $loader = new Upload($destination);
        $loader->setMaxSize($max);
        $loader->upload();
        $result = $loader->getMessages();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

//Gets all images user can delete.
$filenames = buildFileList($dir, ['jpg', 'png', 'gif', 'jpeg']);

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    unlink($dir . $filenames[$id]);
    unlink($thumbdir . "thumb_" . $filenames[$id]);
    unset($filenames[$id]);
    natcasesort($filenames);
}

//Gets files in image dir
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
		    Select image to upload (Max 2mb):
		    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
		    <input type="submit" name="upload" id="upload" value="Upload">
		</form>
        <form action="" method="post">
            <p>Skoða og eyða skrám</p>
            <select name="id">
                <?php
                foreach ($filenames as $key => $value) {
                    $name = basename($value);
                    echo "<option value='{$key}'>{$name}</option>";
                } 
                ?>
            </select>
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
