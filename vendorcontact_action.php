<?php
include('dbconnect.php');
include('functions.php');


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
else{
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
    if($_POST['action'] == "save_update"){
    	$relateEID = $_POST['relateEID'];
    	$ecid = $_POST['ecid'];
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
        $ecstatus = $_POST['status'];
        $eccountry = $_POST['eccountry'];
        $modify_date = date('Y-m-d H:i');
        $modify_by = $_SESSION['acct_id'];

        $eid = $_POST['eid'];
        $erctitle = $_POST['erctitle'];
        $priority = $_POST['priority'];
        $ercstatus;
        if(empty($_POST['ecrstatus'])){
            $ercstatus = 'InActive';
        }
        else{
            $ercstatus = 'Active';
        }

        // query update contact
        $sql = "UPDATE PD_Entity_Contact_Person SET ECname = '$ecname', ECEmail = '$ecemail', ECPhone = '$ecphone', ECFax = '$ecfax', ECWebsite = '$ecwebsite', ECAddress1 = '$ecaddress1', ECAddress2 = '$ecaddress2', ECCity = '$eccity', ECState = '$ecstate', ECZip = '$eczip', ECCountry = '$eccountry', ECModifyDate = '$modify_date', ECModifyBy = $modify_by
                WHERE ECPID = $ecid";

        // query update relationship
        $relationupdatesql = "UPDATE PD_Entity_RelateTo_Contact SET EID = $eid, ECID = $ecid, Priority = '$priority', ERCTitle = '$erctitle', ERCStatus = '$ercstatus', ERCModifyDate = '$modify_date', ERCModifyBy = $modify_by WHERE ECID = $ecid AND EID = $relateEID";

        if(($dbconnect->query($sql) === TRUE) && ($dbconnect->query($relationupdatesql) === TRUE)){
            echo "Contact Updated";
        }
        else{
            echo $relationupdatesql;
        }
    }     
}


?>