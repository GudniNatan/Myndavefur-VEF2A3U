<?php
    $dir = 'img/showcase';
    $files = preg_grep('/^([^.])/', scandir($dir));
    foreach ($files as $key => $value) {
        echo "<article>
            <p>$value</p>
            <figure class='img'>
                <a href='browse.php?img={$key}'><img src='{$dir}/{$value}'></a>
            </figure>
        </article>
        ";
    }