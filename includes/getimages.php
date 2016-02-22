<?php
$dir = 'img/showcase/';
array_multisort(array_map('filemtime', ($images = glob("{$dir}*.{jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG}", GLOB_BRACE))), SORT_ASC, $images); 
//Update to change image dir and sorting