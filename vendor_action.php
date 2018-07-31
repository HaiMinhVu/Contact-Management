<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action']))
{
	
	/// delete an item
	if($_POST['btn_action'] == 'delete')
	{	
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	$eid = $_POST['eid'];
		$status = "Active";
    	if($_POST['status'] == "Active"){
        	$status = "InActive";
        }	
		$query = "UPDATE Entity SET EStatus = '$status', EModifyDate = '$modify_date', EModifyBy = $modify_by WHERE EID = $eid";
		if($dbconnect->query($query) == TRUE){
			echo 'Vendor '.$eid.'  Set to '.$status;
		}
    	else{
        	echo "Failed to Delete";
        }
	}
	/*
	
	if($_POST['btn_action'] == 'Add')
	{	
    	$query = "";
    	// get information from the Add form;
    	$epid = $_POST['epid'];
    	$ename = $_POST['ename'];
    	$eregisteredname = $_POST['eregisteredname'];
    	$owner = $_POST['owner'];
    	$supplier = $_POST['supplier'];
    	$oemcustomer = $_POST['oemcustomer'];
    	$numberofworker = $_POST['numberofworker'];
    	$annualsale = $_POST['annualsale'];
    	$productmanufactured = $_POST['productmanufactured'];
    	$estatus = "Active";
    	$eenterby = $_SESSION['acct_id'];
    	$emodifydate = date("Y-m-d h:i");
    	$emodifyby = $_SESSION['acct_id'];
    
    	if($epid == ""){
    		$query ="INSERT INTO Entity(Ename, ERegisteredName, Owner, Supplier, OEMCustomer, NumberofWorker, AnnualSales, ProductManufactured, EStatus, EEnterBy, EModifyDate, EModifyBy) VALUE ('$ename', '$eregisteredname', '$owner', '$supplier', '$oemcustomer', $numberofworker, $annualsale, '$productmanufactured', '$estatus', $eenterby, '$emodifydate', $emodifyby)";
        }
    	else{
        	$query ="INSERT INTO Entity(EPID, Ename, ERegisteredName, Owner, Supplier, OEMCustomer, NumberofWorker, AnnualSales, ProductManufactured, EStatus, EEnterBy, EModifyDate, EModifyBy) VALUE ($epid, '$ename', '$eregisteredname', '$owner', '$supplier', '$oemcustomer', $numberofworker, $annualsale, '$productmanufactured', '$estatus', $eenterby, '$emodifydate', $emodifyby)";
        }
		if($dbconnect->query($query) === TRUE){
			echo "New Vendor Added";
		}
    	else{
        	echo "Failed to Add";
        }
	}

	
	if($_POST['btn_action'] == 'fetch_single')
	{
    	$eid = $_POST['eid'];
		$query = "SELECT * FROM Entity WHERE EID = $eid";
		$result = $dbconnect->query($query);
    	while($row = $result->fetch_assoc()){
        	// retrieve data from database and load into edit form
			$output['ename'] = $row['EName'];
        	$output['eregisteredname'] = $row['ERegisteredName'];
			$output['owner'] = $row['Owner'];
			$output['supplier'] = $row['Supplier'];
        	$output['oemcustomer'] = $row['OEMCustomer'];
        	$output['numberofworker'] = $row['NumberofWorker'];
        	$output['annualsale'] = $row['AnnualSales'];
        	$output['productmanufactured'] = $row['ProductManufactured'];
		}
		echo json_encode($output);
	}

	
	if($_POST['btn_action'] == 'Edit')
	{
    	$query = "";
    	$eid = $_POST['eid'];
    	$epid = $_POST['epid'];
    	$ename = $_POST['ename'];
    	$eregisteredname = $_POST['eregisteredname'];
    	$owner = $_POST['owner'];
    	$supplier = $_POST['supplier'];
    	$oemcustomer = $_POST['oemcustomer'];
    	$numberofworker = $_POST['numberofworker'];
    	$annualsale = $_POST['annualsale'];
    	$productmanufactured = $_POST['productmanufactured'];
    	$emodifydate = date("Y-m-d h:i");
    	$emodifyby = $_SESSION['acct_id'];
    
    	if($epid == ""){
        	$query = "UPDATE Entity SET EName = '$ename', ERegisteredName = '$eregisteredname', Owner = '$owner', Supplier = '$supplier', OEMCustomer = '$oemcustomer', NumberofWorker = $numberofworker, AnnualSales = $annualsale, ProductManufactured = '$productmanufactured', EModifyDate = '$emodifydate', EModifyBy = $emodifyby 
            WHERE EID = $eid";
        }
    	else{
			$query = "UPDATE Entity SET EPID = $epid, EName = '$ename', ERegisteredName = '$eregisteredname', Owner = '$owner', Supplier = '$supplier', OEMCustomer = '$oemcustomer', NumberofWorker = $numberofworker, AnnualSales = $annualsale, ProductManufactured = '$productmanufactured', EModifyDate = '$emodifydate', EModifyBy = $emodifyby 
            WHERE EID = $eid";
        }
		if($dbconnect->query($query) === TRUE){
			echo 'Vendor '.$eid.' Updated';
		}
    	else{
        	echo "Failed to Update";
        }
	}*/

}

?>