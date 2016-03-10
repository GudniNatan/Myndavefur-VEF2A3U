<?php 
	$startYear = 2016; 
	$thisYear = date('Y');
	$yearString = null;

	if ($startYear == $thisYear) {
	 $yearString = $startYear;
	} 
	else 
	{ 
		$yearString = "{$startYear}&ndash;{$thisYear}";
	}
?>
<footer>
	<div class="info">
		<div>
			<p>
		    	&copy; <?php echo $yearString; ?> | Guðni Natan Gunnarsson
			</p>
		</div>
	</div>
</footer>
