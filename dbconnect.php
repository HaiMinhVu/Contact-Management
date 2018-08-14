<?php
	$server = "localhost";
	$username = "hvu";
	$password = "minhhai";
	$dbname = "factorydb";

	$dbconnect = mysqli_connect($server,$username,$password,$dbname);
	if(!$dbconnect){
		die("Connection failed: ".mysqli_connect_error());
	}
	
	session_set_cookie_params(0);
	session_start();

?>
