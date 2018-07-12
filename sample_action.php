<?php

//product_action.php

include('dbconnect.php');

include('functions.php');

if(isset($_POST['btn_action']))
{
	//// load single item into update form
	if($_POST['btn_action'] == 'fetch_single')
	{
    	$sid = $_POST['sid'];
		$query = "SELECT * FROM Sample WHERE SID = $sid";
		$result = $dbconnect->query($query);
    	while($row = $result->fetch_assoc()){
        	// retrieve data from database and load into edit form
			$output['sname'] = $row['SName'];
        	$output['sdescription'] = $row['SDescription'];
			$output['simage'] = $row['SImages'];
		}
		echo json_encode($output);
	}

	//// submit update/edit item information
	if($_POST['btn_action'] == 'Edit')
	{
    	$sid = $_POST['sid'];
    	$sdescription = $simage = "";
    	$sname = $_POST['sname'];
    	$sdescription = $_POST['sdescription'];
    	$simage = $_POST['simage'];
    	$modify_date = date("Y-m-d h:i");
    	$modify_by = $_SESSION['acct_id'];
    
    	$query = "UPDATE Sample SET SName = '$sname', SDescription = '$sdescription', SImages = '$simage', SModifyDate = '$modify_date', SModifyBy = $modify_by WHERE SID = $sid";

		if($dbconnect->query($query) == TRUE)
		{
			echo 'Sample '.$sid.' Updated';
		}
    	else
        {
        	echo "Failed to Update";
        }
	}

	/// delete an item
	if($_POST['btn_action'] == 'delete')
	{	
    	$status = "Active";
    	if($_POST['status'] == "Active"){
        	$status = "InActive";
        }	
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	$sid = $_POST['sid'];
    	$query = "UPDATE Sample SET SStatus = '$status', SModifyDate = '$modify_date', SModifyBy = $modify_by WHERE SID = $sid";
		if($dbconnect->query($query) == TRUE){
			echo 'Sample '.$_POST['sid'].'  Set to '.$status;
		}
    	else{
        	echo "Failed to Delete";
        }
    	
	}

}
if(isset($_POST['Add'])){
	echo "1";
}
?>