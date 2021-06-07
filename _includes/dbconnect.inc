<?php
	//  replace mysqllogin and mysqlpassword with your own
//	$conn = mysqli_connect("localhost", "root", "root", "cw2_db");
	$conn = mysqli_connect("localhost", "21918149", "phpcw2", "db1_21918149");

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
	}

?>