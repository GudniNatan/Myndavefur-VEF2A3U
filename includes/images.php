<?php
    $dir = 'img/slideshow';
    $files = preg_grep('/^([^.])/', scandir($dir));
    rsort($files);
    foreach ($files as $key => $value) {
    echo "<article>
            <p>$value</p>
            <figure class='img'>
                <a href='browse.php#img$key'><img src='img/slideshow/$value'></a>
            </figure>
        </article>
        ";
    }