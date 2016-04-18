<?php 
	$currentPage = basename($_SERVER['SCRIPT_FILENAME']); 
    require_once './includes/dbcon.php';
    require_once './includes/Images/Images.php';

    $dbImages = new Images($conn);
    if (count($dbImages->imageList()) > 0) {
    	$latestImage = array_reverse($dbImages->imageList())[0][0];
    }
    else{
    	$latestImage = 0;
    }
?>

<nav>
	<ul>
		<li <?php if ($currentPage == "index.php") { echo "class=\"current\""; } ?>>
			<a href="index.php">Heim</a>
		</li>
		<li <?php if ($currentPage == "ummig.php") { echo "class=\"current\""; } ?>>
			<a href="ummig.php">Um mig</a>
		</li>
		<li <?php if ($currentPage == "browse.php") { echo "class=\"current\""; } ?>>
			<a href="browse.php?img=<?php echo $latestImage; ?>">Browse</a>
		</li>
		<li <?php if ($currentPage == "login.php") { echo "class=\"current\""; } ?>>
			<a href="login.php">Login/Register</a>
		</li>
		<?php if (isset($_SESSION['username'])): #Ef notandi er skráður inn?>
		<li <?php if ($currentPage == "userpage.php") { echo "class=\"current\""; } ?>>
			<a href="userpage.php" >Mitt svæði</a>
		</li>
		<?php endif ?>
	</ul>
	<div class="sammieCont hidden">
		<div class="sammie">
		  	<span></span>
		  	<span></span>
		  	<span></span>
		  	<span></span>
		</div>
	</div>
</nav>
<script type="text/javascript" src="js/collapsingNav.js"></script>
