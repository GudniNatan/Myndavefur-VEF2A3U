<?php
    require_once './includes/dbcon.php';
    require_once './includes/Images/Images.php';
    require_once './includes/Categories/Categories.php';
    require_once './includes/formprocess.php';


    $status = false;
    $dbImages = new Images($conn);
    $dbCategories = new Categories($conn);


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
                $imgOwnerID = $value[4];
                $imgdesc = $value[5];
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
    if (isset($validReview)) {
        if (isset($_SESSION['userID']) && $_SESSION['userID'] == $imgOwnerID){
            $dbImages->updateImage($imgID, $nafn, $texti, $flokkur, $visibility);
            $imgname = $nafn;
            $imgdesc = $texti;
        }
    }
    if (isset($_POST['reviewImage']) && !isset($validReview)) {
        echo "Gekk ekki";
    }
    if ($dbImages->getImage($_GET["img"])[7] == 3)
    { 
        if (isset($_SESSION['userID']) && $dbImages->getImage($_GET["img"])[5] == $_SESSION['userID']) {
            # no errors
        }
        else
        {
            $error = true;
        }
    }
    

    if (!$error): ?>
<div>
	<h3 id="image"><?php echo htmlentities($imgname);?></h3>
    <a href="<?php echo('./img/large/' . $imgpath); ?>"><img class="browseImg"<?php echo "src='./img/large/{$imgpath}'"; ?>></a>
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
<div class="fullWidth">
    <p><?php echo $imgdesc ?></p>
</div>
<?php if (isset($_SESSION['userID']) && $_SESSION['userID'] == $imgOwnerID): ?>
    <div class="fullWidth updateImageDiv">
    <p>Þú átt þessa mynd</p>
            <h4>Eyða mynd:</h4> <a href="deleteimage.php?id=<?php echo $imgID; ?>" class="btn btn-danger" title="Ertu alveg viss? Það er ekki hægt að snúa aftur.">Eyða mynd</a>
            <h4>Breyta upplýsingum:</h4>
            <form class="form-horizontal" method="post" action="" id="reviewForm">
                <div class="form-group col-xs-12 col-lg-3">
                    <label for="nafn">Nafn: </label>
                    <input type="text" name="nafn" value="<?php echo $imgname ?>" required id="nafn" class="form-control input-md">
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label for="texti">Ummæli: </label>
                    <textarea id="texti" form="reviewForm" name="texti" rows="1" cols="30" placeholder="Texti með mynd..." class="form-control input-md"><?php echo $imgdesc ?></textarea>
                </div>
                <div class="form-group col-xs-12 col-lg-2">
                    <label for="flokkur">Flokkur:</label>
                    <select name="flokkur" id="flokkur" class="form-control">
                        <?php foreach ($dbCategories->categoryList() as $key2 => $value2) : ?>
                        <option value="<?php echo $key2+1; ?>" <?php if ($dbImages->getImage($_GET["img"])[6] == $key2+1){ echo "selected='selected'"; } ?>><?php echo $value2[1]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-xs-12 col-lg-2">
                    <label for="visibility">Friðhelgisvernd:</label>
                    <select name="visibility" id="visibility" class="form-control">
                        <option value="1" <?php if ($dbImages->getImage($_GET["img"])[7] == 1){ echo "selected='selected'"; } ?>>Opið Öllum</option>
                        <option value="2" <?php if ($dbImages->getImage($_GET["img"])[7] == 2){ echo "selected='selected'"; } ?>>Falið, nema með hlekk</option>
                        <option value="3" <?php if ($dbImages->getImage($_GET["img"])[7] == 3){ echo "selected='selected'"; } ?>>Falið öllum nema þér</option>
                    </select>
                </div>
                <div class="form-group col-xs-12 col-lg-2">
                    <label for="reviewImage">Samþykkja:</label>
                    <button name="reviewImage" type="submit" class="btn btn-primary">Samþykkja</button>
                </div>
            </form>
    </div>
<?php endif ?>
<?php else: ?>
    <?php if (!isset($_GET["img"])): ?>
<h1 style='width: 100%'>404.</h1> <h1 style='width: 100%'>Engin mynd valin.</h1>
    <?php else: ?>
<h1 style='width: 100%'>404.</h1> <h1 style='width: 100%'>Mynd <?php echo $_GET["img"];?> var ekki fundin.</h1>
    <?php endif ?>
<?php endif?>
