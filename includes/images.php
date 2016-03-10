<?php
    $dir = 'img/thumbs/';
    array_multisort(array_map('filemtime', ($images = glob("{$dir}*.{jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG}", GLOB_BRACE))), SORT_ASC, $images); 

    for ($i= count($images) - 1; $i >= 0; $i--) { 
        echo "<article>
            <p>".htmlspecialchars(substr(basename($images[$i]), 6, strlen(basename($images[$i]))))."</p>
            <figure class='img'>
                <a href='browse.php?img={$i}'><img src='{$images[$i]}'></a>
            </figure>
        </article>
        ";
    }
    