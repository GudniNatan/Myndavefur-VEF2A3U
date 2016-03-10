<?php
$dir = 'img/large/';
array_multisort(array_map('filemtime', ($images = glob("{$dir}*.{jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG}", GLOB_BRACE))), SORT_ASC, $images);

$thumbdir = 'img/thumbs/';
array_multisort(array_map('filemtime', ($thumbs = glob("{$thumbdir}thumb_*.{jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG}", GLOB_BRACE))), SORT_ASC, $thumbs);
//Update to change image dir and sorting
//Add support for databases
