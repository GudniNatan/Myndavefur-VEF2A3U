<?php
    require_once './includes/dbcon.php';
    require_once './includes/Images/Images.php';

    $status = false;
    $dbImages = new Images($conn);

    $list = $dbImages->imageList();

    $imgID = null;
    $imgpath = null;
    $imgname = null;
    $imgdesc = null;
    $imgcat = 0;
    $rowNumber = 0;

    $error = false;
    if (!isset($_GET["img"])) {
        $error = true;
    }
    else{
        $exists = false;
        $counter = 0;
        foreach ($list as $key => $value) {
            if ($value[0] == $_GET["img"]) {
                $exists = true;
                $rowNumber = $counter;
                $imgID = $value[0];
                $imgpath = $value[1];
                $imgname = $value[2];
                $imgdesc = $value[3];
            }
            $counter++;
        }
        if (!$exists) {
            $error = true;
        }
    }
    if (!$error) {
        $nextimg = ($rowNumber < count($list)-1) ? $list[$rowNumber+1][0] : 0;
        $previmg = ($rowNumber > 0) ? $list[$rowNumber-1][0] : 0;
        shuffle($list);
        $randomimg = $list[0][0];
    }
    

    if (!$error): ?>
<div>
	<h3><?php echo htmlentities($imgname);?></h3>
    <a href="<?php echo('./img/large/' . $imgpath); ?>"><img class="browseImg" id="image"<?php echo "src='./img/large/{$imgpath}'"; ?>></a>
    <div class="imageMenu">
    <?php if ($previmg != 0): //PREV BUTTON?>
        <a href="browse.php?img=<?php echo "$previmg"; ?>#image" style="color: #1f6684;" class="prevImg btn btn-default">←</a>
    <?php endif ?>
        <a href="browse.php?img=<?php echo "$randomimg";?>#image" style="color: #1f6684;" class="randImg btn btn-default convert-emoji">🔀</a>
    <?php if ($nextimg != 0): //NEXT BUTTON?>
        <a href="browse.php?img=<?php echo "$nextimg"; ?>#image" style="color: #1f6684;" class="nextImg btn btn-default">→</a>
    <?php endif ?>
    </div>
</div>
<?php else: ?>
    <?php if (!isset($_GET["img"])): ?>
<h1 style='width: 100%'>404.</h1> <h1 style='width: 100%'>Engin mynd valin.</h1>
    <?php else: ?>
<h1 style='width: 100%'>404.</h1> <h1 style='width: 100%'>Mynd <?php echo $_GET["img"];?> var ekki fundin.</h1>
    <?php endif ?>
<?php endif?>
