<?php
include('dbconnect.php');

$username = $_POST['username'];
$password = $_POST['password'];

//$username = "hvu";
//$password = "minhhai";

$validatesql = "SELECT * FROM SMDBAccounts WHERE username = '$username' AND password = '$password'";
$validate = $dbconnect->query($validatesql);

$row_count = mysqli_num_rows($validate);

if($row_count == 1){
	while($row = $validate->fetch_assoc()){
    	echo $row['username'];
    }
}


?>