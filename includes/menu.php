<?php $currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
<nav>
	<h3>Síður:</h3>
	<ul>
		<li>
			<a href="index.php" <?php if ($currentPage == "index.php") { echo "class=\"current\""; } ?>>Heim</a>
		</li>
		<li>
			<a href="ummig.php" <?php if ($currentPage == "ummig.php") { echo "class=\"current\""; } ?>>Um mig</a>
		</li>
		<li>
			<a href="browse.php?img=0" <?php if ($currentPage == "browse.php") { echo "class=\"current\""; } ?>>Browse</a>
		</li>
		<li>
			<a href="login.php" <?php if ($currentPage == "login.php") { echo "class=\"current\""; } ?>>Login/Register</a>
		</li>
		<?php if (isset($_SESSION['username'])): #Ef notandi er skráður inn?>
		<li>
			<a href="upload.php" <?php if ($currentPage == "upload.php") { echo "class=\"current\""; } ?>>Upload</a>
		</li>
		<li>
			<a href="upload.php" <?php if ($currentPage == "upload.php") { echo "class=\"current\""; } ?>>Þínar myndir</a>
		</li>
		<?php endif ?>
	</ul>
</nav>
