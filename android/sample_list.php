<?php
include ("dbconnect.php");

class Sample{
	function Sample($sid, $sname, $sdescription, $simage){
    	$this->SID = $sid;
    	$this->SName = $sname;
    	$this->SDescription = $sdescription;
    	$this->SImage = $simage;
    }
}

$samplearray = array();

$sql = "SELECT * FROM Sample ";
$result = $dbconnect->query($sql);
while($row = $result->fetch_assoc()){
	//array_push($samplearray, new Sample($row['SID'], $row['SName'], $row['SDescription'], $row['SImages']));
	array_push($samplearray, new Sample($row['SID'], $row['SName'], $row['SDescription'], 'http://10.0.0.201/~hvu/images/sample/'. $row['SImages']));
	//echo '<img src="images/sample/'. $row['SImages'].'" height="30" width="30">';
}

echo json_encode(array("Sample" => $samplearray));

?>