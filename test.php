<?php
include('dbconnect.php');
$email; $phone;
$tmpsql = 'SELECT * FROM Entity_Attribute WHERE EID = 1 AND EASubCategoty = "Primary"';
$tmpresult = $dbconnect->query($tmpsql);
while($tmprow = $tmpresult->fetch_assoc()){
	//echo 1;
	if($tmprow['EACategory'] == "email"){
		$email = $tmprow['EAString'];
    }
	else if($tmprow['EACategory'] == "phone"){
    	$phone = $tmprow['EAString'];
    }
}
echo $email.$phone;
?>