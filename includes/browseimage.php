<?php
    $dir = 'img/showcase/';
    array_multisort(array_map('filemtime', ($images = glob("{$dir}*.{jpg,png,gif,jpeg}", GLOB_BRACE))), SORT_DESC, $images);
    $imgpath = $images[htmlspecialchars($_GET["img"])];
?>
<div>
	<h2><?php echo basename($imgpath);?></h2>
    <img <?php echo "src='{$imgpath}'"; ?>>
</div>