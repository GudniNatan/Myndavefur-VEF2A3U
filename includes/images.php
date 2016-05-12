<?php
    require_once './includes/dbcon.php';
    require_once './includes/Images/Images.php';

    $status = false;
    $dbImages = new Images($conn);

    $list = $dbImages->imageList();

    for ($i= count($list) - 1; $i >= 0; $i--) {
        if ($dbImages->getImage($list[$i][0])[7] == 1){
        echo "<article>
            <p>".htmlspecialchars($list[$i][2])."</p>
            <figure class='img'>
                <a href='browse.php?img={$list[$i][0]}'><img src='./img/thumbs/thumb_{$list[$i][1]}'></a>
            </figure>
            <div class='fadeout'></div>
        </article>
        ";
        }
        
    }
    