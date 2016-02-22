<?php
    require("getimages.php");

    for ($i= count($images) - 1; $i >= 0; $i--) { 
        echo "<article>
            <p>".basename($images[$i])."</p>
            <figure class='img'>
                <a href='browse.php?img={$i}'><img src='{$images[$i]}'></a>
            </figure>
        </article>
        ";
    }
    