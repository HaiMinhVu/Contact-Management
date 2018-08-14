<?php
include('dbconnect.php');
include('functions.php');

if(($_POST['action'] == "addmore") || ($_POST['action'] == "save")){

	// infomation to add new contact
	
	$ecname = $_POST['ecname'];
	$ecemail = $_POST['ecemail'];
	$ecphone = $_POST['ecphone'];
	$ecfax = $_POST['ecfax'];
	$ecwebsite = $_POST['ecwebsite'];
	$ecaddress1 = $_POST['ecaddress1'];
	$ecaddress2 = $_POST['ecaddress2'];
	$eccity = $_POST['eccity'];
	$ecstate = $_POST['ecstate'];
	$eczip = $_POST['eczip'];
	$eccountry = $_POST['eccountry'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];

	// information to add relationship between vendor and representative
	$eid = $_POST['eid'];
    $ecid;
    $erctitle = $_POST['erctitle'];
    $priority = $_POST['priority'];
    $modify_date = date("Y-m-d h:i");
    $modify_by = $_SESSION['acct_id'];
	$status = '';
	if(empty($_POST['ecpstatus'])){
    	$status = 'InActive';
    }
	else{
    	$status = 'Active';
    }
	
	$sql = "INSERT INTO PD_Entity_Contact_Person VALUES(null, '$ecname', '$ecemail', '$ecphone', '$ecfax', '$ecwebsite', '$ecaddress1', '$ecaddress2', '$eccity', '$ecstate', '$eczip', '$eccountry', $modify_by, '$modify_date', $modify_by)";
    if($dbconnect->query($sql) === TRUE){
    	$tmpsql = "SELECT MAX(ECPID) FROM PD_Entity_Contact_Person";
    	$tmpresult = $dbconnect->query($tmpsql);
    	$erow = $tmpresult->fetch_assoc();
        $ecid = $erow['MAX(ECPID)'];
        
    	$relationquery ="INSERT INTO PD_Entity_RelateTo_Contact VALUES ($eid, $ecid, '$erctitle', '$priority', '$modify_date', '$modify_date', '$modify_by', '$status')";
    	if($dbconnect->query($relationquery) === TRUE){
        	if($_POST['action'] == "addmore"){
            	echo "New Contact Added";
            }
        	else if($_POST['action'] == "save"){
            	echo "New Contact Saved";
            }
        }
	}
    else{
        echo $sql;
    }
}     

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'delete')
	{	
    	$ercid =  $_POST['ercid'];
        $ercarray = explode(".", $ercid);
        $ecid = $ercarray[0];
        $eid = $ercarray[1];
    	
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	$status = "Active";
        if($_POST['status'] == "Active"){
            $status = "InActive";
        }   
        $query = "UPDATE PD_Entity_RelateTo_Contact SET ERCStatus = '$status', ERCModifyDate = '$modify_date', ERCModifyBy = $modify_by WHERE EID = $eid AND ECID = $ecid";
        if($dbconnect->query($query) == TRUE){
            echo 'Relationship is Set to '.$status;
        }
        else{
            echo "Failed: ".$query;
        }
	}
}

?>