<?php
    include'./includes/title.php';
    $dir = 'img/slideshow';
    $files = preg_grep('/^([^.])/', scandir($dir));
    rsort($files);
?>
<!DOCTYPE html>
<head>
    <title>Myndr<?php echo " - " . "{$title}"; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="GRU2L4U Vefsíða">
    <meta name="author" content="Guðni Natan Gunnarsson, Jóhann Rúnarsson, Óli Pétur Olsen">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stilsida.css">
</head>
<body>
    <header class="custom-wrapper pure-g" id="menu">
            <h1>Myndr</h1>            
    </header>
<div class="containall">
    <?php include("./includes/menu.php") ?>
    <main>
        <?php 
            foreach ($files as $key => $value) {
                echo "<article>
            <p>$value</p>
            <figure class='img'>
                <a href='browse.php#img$key'><img src='img/slideshow/$value'></a>
            </figure>
        </article>
        ";
            }
        ?>
    </main>
</div>
<?php include("./includes/footer.html") ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</body>
</html>