<?php
	include("./includes/main.php");
	$check_ban_ip = check_ban_ip();
		if($check_ban_ip == TRUE) 
		{
			echo "You are banned from this server.";
		}
		else {
	 		style();
	 	}
?>