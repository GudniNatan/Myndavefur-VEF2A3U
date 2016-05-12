<?php
//Velur random mynd í header
    $qoutes = array("Þar sem enginn þekkir nafnið þitt.", "Núna á 50% afslætti", "Ég skoðaði vefsíðuna og dó ekki! 10/10", "Gakktu til liðs við okkur, við erum með smákökur", '"May the force be ever in your favor" - Spock', "Við geymum myndir");
    shuffle($qoutes);
  ?>
<header class="custom-wrapper pure-g" id="menu">
	<?php if (isset($_SESSION['username'])):  ?>
	<div class="userinfo">
		<p>User: <a href="userpage.php" class="white-text"><?php echo $_SESSION['username']; ?></a> | <a href="logout.php">Logout</a></p>
	</div>
	<?php endif; ?>
	<div class="logo">
		<a href="index.php" class="headerLink"><h1 class="_i_myndun">(í)<i>myndun</i></h1></a>
		<p>-<?php echo $qoutes[0]; ?></p>
	</div>
</header>
