<?php
//Velur random mynd í header
    $dir = 'img/header/';
    if (isset($_SESSION["files"]) == false || count($_SESSION["files"]) == 0) {
    	array_multisort(array_map('filemtime', ($_SESSION["files"] = glob("{$dir}*.{jpg,png,gif,jpeg}", GLOB_BRACE))), SORT_DESC, $_SESSION["files"]);
    }
    shuffle($_SESSION["files"]);
    $imgpath = $_SESSION["files"][0];
    unset($_SESSION["files"][0]);
  ?>
<header class="custom-wrapper pure-g" id="menu" style="background-image: url('<?php echo $imgpath; ?>')">
	<div>
		<a href="index.php" class="headerlink"><h1 class="_i_myndun">(í)<i>myndun</i></h1></a>
	</div>
</header>