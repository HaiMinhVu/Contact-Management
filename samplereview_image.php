<?php
include ('dbconnect.php');

$sreid = $_GET['id'];
$sql = "SELECT SReImages FROM PD_SampleReview WHERE SReID = $sreid";
$result = $dbconnect->query($sql);
while($row = $result->fetch_assoc()){
	echo "<img src='images/sample_review/". $row['SReImages']."'>";
}
?>