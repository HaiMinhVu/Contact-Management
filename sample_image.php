<?php
include ('dbconnect.php');

$id = $_GET['id'];
$sql = "SELECT SImages FROM Sample WHERE SID = $id";
$result = $dbconnect->query($sql);
while($row = $result->fetch_assoc()){
	echo "<img src='images/sample/". $row['SImages']."'>";
}
?>