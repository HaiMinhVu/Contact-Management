<?php
include("dbconnect.php");

class SampleRecord{
	function SampleRecord($srid, $ename, $requestby, $quantity, $price, $type){
    	$this->SRID = $srid;
    	$this->EName = $ename;
    	$this->RequestBy = $requestby;
    	$this->Quantity = $quantity;
    	$this->Price = $price;
    	$this->Type = $type;
    }
}

$sid = (int)$_POST['SID'];

$recordarray = array();
$recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy
                                INNER JOIN Sample s ON s.SID = sr.SID
                                WHERE sr.SID = $sid";
$recordfetch = $dbconnect->query($recordquery);
while($row = $recordfetch->fetch_array()){
	array_push($recordarray, new SampleRecord($row['SRID'], $row['EName'], $row['username'], $row['Quantity'], $row['PriceperUnit'], $row['Type']));
}

echo json_encode(array("SampleRecord" => $recordarray));
?>