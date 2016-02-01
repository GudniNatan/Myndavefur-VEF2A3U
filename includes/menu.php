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
			<a href="browse.php" <?php if ($currentPage == "browse.php") { echo "class=\"current\""; } ?>>Browse</a>
		</li>
	</ul>
</nav>
