<?php
 $title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
 $title = str_replace('_', ' ', $title);
 $title = ucwords($title);
 if ($title == "Ummig") {
 	$title = "Um mig";
 }
 if ($title == "Login") {
 	$title = "Login/Register";
 }