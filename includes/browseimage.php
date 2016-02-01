<?php
    $dir = 'img/showcase';
    $files = preg_grep('/^([^.])/', scandir($dir));
    $imgpath = $files[htmlspecialchars($_GET["img"])];
?>
<div>
    <?php echo "    <img src='{$dir}/{$imgpath}'>"; ?>
</div>