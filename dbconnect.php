<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$dbname = "factorydb";

	$dbconnect = mysqli_connect($server,$username,$password,$dbname);
	if(!$dbconnect){
		die("Connection failed: ".mysqli_connect_error());
	}
	session_start();

?>
