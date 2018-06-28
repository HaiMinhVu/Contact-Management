<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action']))
{
	//// add new item
	if($_POST['btn_action'] == 'Add')
	{	
    	$paymentterm = $warrantyterm = $shippingterm = "";
    	$sid = $_POST['sid'];
    	$eid = $_POST['eid'];
    	$quantity = $_POST['quantity'];
    	$price = $_POST['price'];
    	$daterequested = $_POST['daterequested'];
    	$type = $_POST['type'];
    	$estdeliver = (($_POST['estdeliver'] != '') ? ($estdeliver = $_POST['estdeliver']) : ($estdeliver = "1969-12-31"));
    	
    	$arrivaldate = (($_POST['arrivaldate'] != '') ? ($arrivaldate = $_POST['arrivaldate']) : ($arrivaldate = "1969-12-31"));
    	$paymentterm = $_POST['paymentterm'];
    	$warrantyterm = $_POST['warrantyterm'];
    	$shippingterm = $_POST['shippingterm'];
    	$modify_date = date("Y-m-d h:i");
    	$modify_by = $_SESSION['acct_id'];
    	$status = "Active";
    	$query = "INSERT INTO SampleRecord VALUES(null, $sid, $eid, $quantity, $price, '$daterequested', '$type', '$estdeliver', '$arrivaldate', '$paymentterm', '$warrantyterm', '$shippingterm', $modify_by, '$modify_date', $modify_by, '$status')";
    
		if($dbconnect->query($query) == TRUE)
		{
			echo 'New Record Added';
		}
    	else
        {
        	echo "Failed to Add";
        }
	}

	//// load single item into update form
	if($_POST['btn_action'] == 'fetch_single')
	{
    	$srid = $_POST['srid'];
		$query = "SELECT * FROM SampleRecord WHERE SRID = $srid";
		$result = $dbconnect->query($query);
    	while($row = $result->fetch_assoc()){
        	// retrieve data from database and load into edit form
			$output['sid'] = $row['SID'];
        	$output['eid'] = $row['EID'];
			$output['quantity'] = $row['Quantity'];
        	$output['price'] = $row['PriceperUnit'];
        	$output['daterequested'] = date('Y-m-d', strtotime($row['DateRequested']));
        	$output['type'] = $row['Type'];
        	$output['estdeliver'] = date('Y-m-d', strtotime($row['EstDeliver']));
        	$output['arrivaldate'] = date('Y-m-d', strtotime($row['ArrivalDate']));
        	$output['paymentterm'] = $row['PaymentTerms'];
        	$output['shippingterm'] = $row['ShippingTerms'];
        	$output['warrantyterm'] = $row['WarrantyTerms'];
		}
		echo json_encode($output);
	}

	//// submit update/edit item information
	if($_POST['btn_action'] == 'Edit')
	{
    	$srid = $_POST['srid'];
    	$sid = $_POST['sid'];
    	$eid = $_POST['eid'];
    	$quantity = $_POST['quantity'];
    	$price = $_POST['price'];
    	$daterequested = $_POST['daterequested'];
    	$type = $_POST['type'];
    	$estdeliver = $_POST['estdeliver'];
    	$arrivaldate = $_POST['arrivaldate'];
    	$paymentterm = $_POST['paymentterm'];
    	$warrantyterm = $_POST['warrantyterm'];
    	$shippingterm = $_POST['shippingterm'];
    	$modify_date = date("Y-m-d h:i");
    	$modify_by = $_SESSION['acct_id'];
    
    	$query = "UPDATE SampleRecord SET SID = $sid, EID = $eid, Quantity = $quantity, PriceperUnit = $price, DateRequested = '$daterequested', Type = '$type', EstDeliver = '$estdeliver', ArrivalDate = '$arrivaldate', PaymentTerms = '$paymentterm', WarrantyTerms = '$warrantyterm', ShippingTerms = '$shippingterm', SRModifyDate = '$modify_date', SRModifyBy = $modify_by WHERE SRID = $srid";

		if($dbconnect->query($query) == TRUE)
		{
			echo 'Sample '.$sid.' Updated';
		}
    	else
        {
        	echo $query;
        }
	}

	/// delete an item
	if($_POST['btn_action'] == 'delete')
	{	
    	$srid = $_POST['srid'];
    	$status = "Active";
    	if($_POST['status'] == "Active"){
        	$status = "InActive";
        }	
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	
    	$query = "UPDATE SampleRecord SET SRStatus = '$status', SRModifyDate = '$modify_date', SRModifyBy = $modify_by WHERE SRID = $srid";
		if($dbconnect->query($query) == TRUE){
			echo 'Record '.$_POST['srid'].'  Set to '.$status;
		}
    	else{
        	echo "Failed to Delete";
        }
    	
	}
}

?>