<?php
//Velur random mynd í header
    $dir = 'img/header/';
    if (isset($_SESSION["files"]) == false || count($_SESSION["files"]) == 0) {
    	$_SESSION["files"] = glob("{$dir}*.{jpg,png,gif,jpeg}", GLOB_BRACE);
    }
    shuffle($_SESSION["files"]);
    $imgpath = $_SESSION["files"][0];
    unset($_SESSION["files"][0]);
    $qoutes = array("Þar sem enginn þekkir nafnið þitt.", "Núna á 50% afslætti", "Ég skoðaði vefsíðuna og dó ekki! 10/10", "Gakktu til liðs við okkur, við erum með smákökur", '"May the force be ever in your favor" - Spock', "eg er homi");
    shuffle($qoutes);
  ?>
<header class="custom-wrapper pure-g" id="menu" style="background-image: url('<?php echo $imgpath; ?>')">
	<div>
		<a href="index.php" class="headerlink"><h1 class="_i_myndun">(í)<i>myndun</i></h1></a><br>
	</div>
	<div class="quote">
		<p>-<?php echo $qoutes[0]; ?></p>
	</div>
</header>