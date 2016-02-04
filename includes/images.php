<?php
    $dir = 'img/showcase/';
    array_multisort(array_map('filemtime', ($images = glob("{$dir}*.{jpg,png,gif,jpeg}", GLOB_BRACE))), SORT_DESC, $images);

    foreach ($images as $key => $value) {
        echo "<article>
            <p>".basename($value)."</p>
            <figure class='img'>
                <a href='browse.php?img={$key}'><img src='{$value}'></a>
            </figure>
        </article>
        ";
    }