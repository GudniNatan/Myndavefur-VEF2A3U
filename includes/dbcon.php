<?php
	$servername = "tsuts.tskoli.is";
	$serverusername = "1803982879";
	$serverpassword = "mypassword";
	$dbname = "1803982879_PictureBase";
	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $serverusername, $serverpassword);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	catch(PDOException $e)
	    {
	    echo "Connection failed: " . $e->getMessage();
	    }
?>