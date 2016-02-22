<?php
    require("getimages.php");
    $error = false;
    if (!isset($_GET["img"]) || $_GET["img"] > count($images) - 1 || $_GET["img"] < 0 || !is_numeric($_GET["img"])) {
    	$error = "Engin mynd valin.";
    	if (isset($_GET["img"])) {
    		$error = "Mynd {$_GET["img"]} ekki fundin.";
    	}
    	echo "<h1 style='width: 100%'>404.</h1> <h1 style='width: 100%'>{$error}</h1>";
        $error = true;
    }
    else{
    	$imgpath = $images[htmlspecialchars($_GET["img"])];
    }

    $nextimg = $_GET["img"] + 1;
    $previmg = $_GET["img"] -1;

    if (!$error): ?>
<div>
	<h2><?php echo basename($imgpath);?></h2>
    <a href="<?php echo($imgpath); ?>"><img <?php echo "src='{$imgpath}'"; ?>></a>
    <div class="imageMenu">
    <?php if ($_GET["img"] != 0): ?>
        <button><a href="browse.php?img=<?php echo "$previmg"; ?>" style="color: #1f6684;" class="prevImg">←</a></button>
    <?php endif ?>
    <button><a href="browse.php?img=<?php echo random_int(0, count($images)-1); ?>" style="color: #1f6684;" class="randImg">🔀</a></button>
    <?php if ($_GET["img"] != count($images) - 1): ?>
        <button><a href="browse.php?img=<?php echo "$nextimg"; ?>" style="color: #1f6684;" class="nextImg">→</a></button>
    <?php endif ?>
    </div>
</div>
<?php endif ?>
