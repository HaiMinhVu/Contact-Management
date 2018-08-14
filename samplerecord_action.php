<?php
include('dbconnect.php');
include('functions.php');

if($_POST['action'] == "Add"){
	$sid = $_POST['sid'];
	$eid = $_POST['eid'];
	$type = $_POST['type'];
	$quantity = $_POST['quantity'];
	$priceperunit = (($_POST['priceperunit'] != '') ? ($priceperunit = $_POST['priceperunit']) : ($priceperunit = 0));
	$daterequested = $_POST['daterequested'];
	$estdeliver = $_POST['estdeliver'];
	$arrivaldate = $_POST['arrivaldate'];
	$paymentterm = $_POST['paymentterm'];
	$shippingterm = $_POST['shippingterm'];
	$warrantyterm = $_POST['warrantyterm'];
	$status = "Active";
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "INSERT INTO PD_SampleRecord VALUES(null, $sid, $eid, $quantity, 0, $quantity, $priceperunit, '$daterequested', '$type', '$estdeliver', '$arrivaldate', '$paymentterm', '$warrantyterm', '$shippingterm', $modify_by, '$modify_date', '$modify_by', '$status')";
    if($dbconnect->query($sql) === TRUE){
		echo '<div class="alert alert-info">New Record Added</div>';
	}
    else{
        echo '<div class="alert alert-danger">Failed to Add</div>';
    }
}

if($_POST['action'] == "save_update"){
	$srid = $_POST['srid'];
	$sid = $_POST['sid'];
	$eid = $_POST['eid'];
	$type = $_POST['type'];
	$quantity = $_POST['quantity'];
	$used = $_POST['used'];
	$available = $_POST['available'];
	$priceperunit = $_POST['priceperunit'];
	$daterequested = $_POST['daterequested'];
	$estdeliver = $_POST['estdeliver'];
	$arrivaldate = $_POST['arrivaldate'];
	$paymentterm = $_POST['paymentterm'];
	$shippingterm = $_POST['shippingterm'];
	$warrantyterm = $_POST['warrantyterm'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "UPDATE PD_SampleRecord SET SID = $sid, EID = $eid, Type = '$type', Quantity = $quantity, Used = $used, Available = $available, PriceperUnit = $priceperunit, DateRequested = '$daterequested', EstDeliver = '$estdeliver', ArrivalDate = '$arrivaldate', PaymentTerms = '$paymentterm', ShippingTerms = '$shippingterm', WarrantyTerms = '$warrantyterm', SRModifyDate = '$modify_date', SRModifyBy = $modify_by
            WHERE SRID = $srid";
    if($dbconnect->query($sql) === TRUE){
    	echo '<div class="alert alert-info">Record Updated</div>';
	}
    else{
        
    	echo '<div class="alert alert-danger">Failed to Update</div>';
    }
}

if(isset($_POST['btn_action']))
{
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
    	
    	$query = "UPDATE PD_SampleRecord SET SRStatus = '$status', SRModifyDate = '$modify_date', SRModifyBy = $modify_by WHERE SRID = $srid";
		if($dbconnect->query($query) == TRUE){
			echo 'Record '.$_POST['srid'].'  Set to '.$status;
		}
    	else{
        	echo "Failed to Delete";
        }
	}
}

?>