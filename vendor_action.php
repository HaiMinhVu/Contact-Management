<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action']))
{
    if($_POST['btn_action'] == 'delete')
    {   
        $modify_date = date("Y-m-d H:i");
        $modify_by = $_SESSION['acct_id'];
        $eid = $_POST['eid'];
        $status = "Active";
        if($_POST['status'] == "Active"){
            $status = "InActive";
        }   
        $querydelete = "UPDATE PD_Entity SET EStatus = '$status', EModifyDate = '$modify_date', EModifyBy = $modify_by WHERE EID = $eid";
        if($dbconnect->query($querydelete) == TRUE){
            echo 'Vendor '.$eid.'  Set to '.$status;
        }
        else{
            echo "Failed to Delete";
        }
    }
    

}
else{
    if($_POST['action'] == "addmore" || $_POST['action'] == "save"){
    	$addressresult; $emailresult; $phoneresult;
    	$estatus = '';
    	if(empty($_POST['estatus'])){
        	$estatus = 'InActive';
        }
    	else{
        	$estatus = 'Active';
        }
        $epid = (($_POST['epid'] != '') ? ($epid = $_POST['epid']) : ($epid = 0));
        $ename = $_POST['ename'];
        $eregisteredname = $_POST['eregisteredname'];
        $owner = $_POST['owner'];
        $supplier = (($_POST['supplier'] != '') ? ($supplier = $_POST['supplier']) : ($supplier = ""));
        $oemcustomer = (($_POST['oemcustomer'] != '') ? ($oemcustomer = $_POST['oemcustomer']) : ($oemcustomer = ""));
        $numberofworker = (($_POST['numberofworker'] != '') ? ($numberofworker = $_POST['numberofworker']) : ($numberofworker = 0));
        $annualsale = (($_POST['annualsale'] != '') ? ($annualsale = $_POST['annualsale']) : ($annualsale = 0));
        $productmanufactured = $_POST['productmanufactured'];
        $eenterby = $_SESSION['acct_id'];
        $emodifydate = date("Y-m-d h:i");
        $emodifyby = $_SESSION['acct_id'];

    	$subaddressArr = $_POST['esubaddress'];
    	$address1Arr = $_POST['eaddress1'];
    	$address2Arr = $_POST['eaddress2'];
    	$cityArr = $_POST['ecity'];
    	$stateArr = $_POST['estate'];
    	$countryArr = $_POST['ecountry'];
    	$zipArr = $_POST['ezip'];
    	$poboxArr = $_POST['epobox'];
    	$subemailArr = $_POST['esubemail'];
    	$emailArr = $_POST['eemail'];
    	$subphoneArr = $_POST['esubphone'];
    	$phoneArr = $_POST['ephone'];

        $query ="INSERT INTO PD_Entity(EPID, Ename, ERegisteredName, Owner, Supplier, OEMCustomer, NumberofWorker, AnnualSales, ProductManufactured, EStatus, EEnterBy, EModifyDate, EModifyBy) VALUES ($epid, '$ename', '$eregisteredname', '$owner', '$supplier', '$oemcustomer', $numberofworker, $annualsale, '$productmanufactured', '$estatus', $eenterby, '$emodifydate', $emodifyby)";
    	if($dbconnect->query($query) == TRUE){
        	$tmpsql = "SELECT MAX(EID) FROM PD_Entity";
        	$tmpresult = $dbconnect->query($tmpsql);
        	while($erow = $tmpresult->fetch_assoc()){
            	$maxeid = $erow['MAX(EID)'];
        		if(!empty($address1Arr)){
        			for($i = 0; $i < count($address1Arr); $i++){
            			if(!empty($address1Arr[$i])){
                			$subaddress = $subaddressArr[$i];
                			$address['address1'] = $address1Arr[$i];
                			$address['address2'] = $address2Arr[$i];
                			$address['city'] = $cityArr[$i];
                			$address['state'] = $stateArr[$i];
                			$address['country'] = $countryArr[$i];
                			$address['zip'] = $zipArr[$i];
                			$address['pobox'] = $poboxArr[$i];
                        	$jsonaddress = json_encode($address);
                			//$jsonaddress = json_encode(array($subaddress." Address".$i => $address));
                			$insertaddress = "INSERT INTO PD_Entity_Attribute VALUES (null, $maxeid, 'address', '$subaddress', '$jsonaddress', 'Active' )";
                			$addressresult = $dbconnect->query($insertaddress);
                		}
            		}
        		}
            	if(!empty($emailArr)){
        			for($i = 0; $i < count($emailArr); $i++){
            			if(!empty($emailArr[$i])){
                			$subemail = $subemailArr[$i];
                			$email = $emailArr[$i];
                			$insertemail = "INSERT INTO PD_Entity_Attribute VALUES (null, $maxeid, 'email', '$subemail', '$email', 'Active')";
                			$emailresult = $dbconnect->query($insertemail);
                		}
            		}
        		}
    			if(!empty($phoneArr)){
        			for($i = 0; $i < count($phoneArr); $i++){
            			if(!empty($phoneArr[$i])){
                			$subphone = $subphoneArr[$i];
                			$phone = $phoneArr[$i];
                			$insertphone = "INSERT INTO PD_Entity_Attribute VALUES (null, $maxeid, 'phone', '$subphone', '$phone', 'Active')";
                			$phoneresult = $dbconnect->query($insertphone);
                        }
            		}
        		}
    			
            }
        	if($addressresult == true && $emailresult == true && $phoneresult == true){
            	if($_POST['action'] == "addmore"){
            		echo "New Vendor Added";
                }
            	else if($_POST['action'] == "save"){
                	echo "Vendor Saved";
                }
            }
    	}
        else{
            echo "Error: ".$dbconnect->error;
        }
    	
    }

    if($_POST['action'] == "save_update"){
    	
    	// all addresses, emails, phones which are retrieved from database
    	$eaidadd = array();
    	$eaidemail = array();
    	$eaidphone = array();

    	$eid = $_POST['eid'];
    	
    	$retrieveaddress = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "address" AND EAStatus = "Active"';
    	$resultaddress = $dbconnect->query($retrieveaddress);
    	while($addrow = $resultaddress->fetch_assoc()){
        	array_push($eaidadd, $addrow['EAID']);
        }
    	$retrieveemail = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "email" AND EAStatus = "Active"';
    	$resultemail = $dbconnect->query($retrieveemail);
    	while($emailrow = $resultemail->fetch_assoc()){
            array_push($eaidemail, $emailrow['EAID']);
        }
    	$retrievephone = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "phone" AND EAStatus = "Active"';
    	$resultphone = $dbconnect->query($retrievephone);
    	while($phonerow = $resultphone->fetch_assoc()){
            array_push($eaidphone, $phonerow['EAID']);
        }

    	if(empty($_POST['estatus'])){
        	$status = 'InActive';
        }
    	else{
        	$status = 'Active';
        }
    	$epid = (($_POST['epid'] != '') ? ($epid = $_POST['epid']) : ($epid = 0));
        $ename = $_POST['ename'];
        $eregisteredname = $_POST['eregisteredname'];
        $owner = $_POST['owner'];
        $supplier = (($_POST['supplier'] != '') ? ($supplier = $_POST['supplier']) : ($supplier = ""));
        $oemcustomer = (($_POST['oemcustomer'] != '') ? ($oemcustomer = $_POST['oemcustomer']) : ($oemcustomer = ""));
        $numberofworker = (($_POST['numberofworker'] != '') ? ($numberofworker = $_POST['numberofworker']) : ($numberofworker = 0));
        $annualsale = (($_POST['annualsale'] != '') ? ($annualsale = $_POST['annualsale']) : ($annualsale = 0));
        $productmanufactured = $_POST['productmanufactured'];
    	$modify_date = date('Y-m-d H:i');
    	$modify_by = $_SESSION['acct_id'];

    	// EXISTING ADDRESS, EMAIL, PHONE
    	$subaddressArr = $_POST['esubaddress'];
    	$address1Arr = $_POST['eaddress1'];
    	$address2Arr = $_POST['eaddress2'];
    	$cityArr = $_POST['ecity'];
    	$stateArr = $_POST['estate'];
    	$countryArr = $_POST['ecountry'];
    	$zipArr = $_POST['ezip'];
    	$poboxArr = $_POST['epobox'];
    	$subemailArr = $_POST['esubemail'];
    	$emailArr = $_POST['eemail'];
    	$subphoneArr = $_POST['esubphone'];
    	$phoneArr = $_POST['ephone'];
    	
    	// all addresses, emails, phones get from submitting form
    	$eaidaddress = $_POST['eaidaddress'];
    	$eaidemails = $_POST['eaidemail'];
    	$eaidphones = $_POST['eaidphone'];
    	
    	$lostadd = array_diff($eaidadd,$eaidaddress);
    	$lostemail = array_diff($eaidemail,$eaidemails);
    	$lostphone = array_diff($eaidphone,$eaidphones);
    
    	// NEW ADDRESS, EMAIL, PHONE ADDED 
    	$subaddresscopyArr = $_POST['esubaddresscopy'];
    	$address1copyArr = $_POST['eaddress1copy'];
    	$address2copyArr = $_POST['eaddress2copy'];
    	$citycopyArr = $_POST['ecitycopy'];
    	$statecopyArr = $_POST['estatecopy'];
    	$countrycopyArr = $_POST['ecountrycopy'];
    	$zipcopyArr = $_POST['ezipcopy'];
    	$poboxcopyArr = $_POST['epoboxcopy'];
    	$subemailcopyArr = $_POST['esubemailcopy'];
    	$emailcopyArr = $_POST['eemailcopy'];
    	$subphonecopyArr = $_POST['esubphonecopy'];
    	$phonecopyArr = $_POST['ephonecopy'];
    	
    	// ---------UPDATE BASIC INFO ---------------
    	$sql = "UPDATE PD_Entity SET EPID = $epid, EName = \"$ename\", ERegisteredName = \"$eregisteredname\", Owner = \"$owner\", Supplier = \"$supplier\", OEMCustomer = \"$oemcustomer\", NumberofWorker = $numberofworker, AnnualSales = $annualsale, ProductManufactured = \"$productmanufactured\", EModifyDate = '$modify_date', EModifyBy = $modify_by, EStatus = '$status'
                WHERE EID = $eid";

    	// ---------REMOVE ADDRESS, EMAIL, PHONE----------
    	foreach($lostadd as $lost){
    		$addressremove = "UPDATE PD_Entity_Attribute SET EAStatus = 'InActive' WHERE EAID = $lost";
        	$dbconnect->query($addressremove);
        
        }
    	foreach($lostemail as $lost){
    		$emailremove = "UPDATE PD_Entity_Attribute SET EAStatus = 'InActive' WHERE EAID = $lost";
        	$dbconnect->query($emailremove);
        }
    	foreach($lostphone as $lost){
    		$phoneremove = "UPDATE PD_Entity_Attribute SET EAStatus = 'InActive' WHERE EAID = $lost";
        	$dbconnect->query($phoneremove);
        }

    	// -------------- ADD NEW ADDRESS, EMAIL, PHONE ----------------
    	if(!empty($address1copyArr)){
        	for($i = 0; $i < count($address1copyArr); $i++){
            	if(!empty($address1copyArr[$i])){
                	$subaddress = $subaddresscopyArr[$i];
                	$address['address1'] = $address1copyArr[$i];
                	$address['address2'] = $address2copyArr[$i];
                	$address['city'] = $citycopyArr[$i];
                	$address['state'] = $statecopyArr[$i];
                	$address['country'] = $countrycopyArr[$i];
                	$address['zip'] = $zipcopyArr[$i];
                	$address['pobox'] = $poboxcopyArr[$i];
                    $jsonaddress = json_encode($address);
                	$insertaddress = "INSERT INTO PD_Entity_Attribute VALUES (null, $eid, 'address', \"$subaddress\", '$jsonaddress', 'Active' )";
                	$addressresult = $dbconnect->query($insertaddress);
                }
            }
        }
        if(!empty($emailcopyArr)){
        	for($i = 0; $i < count($emailcopyArr); $i++){
            	if(!empty($emailcopyArr[$i])){
                	$subemail = $subemailcopyArr[$i];
                	$email = $emailcopyArr[$i];
                	$insertemail = "INSERT INTO PD_Entity_Attribute VALUES (null, $eid, 'email', \"$subemail\", '$email', 'Active')";
                	$emailresult = $dbconnect->query($insertemail);
                }
            }
        }
    	if(!empty($phonecopyArr)){
        	for($i = 0; $i < count($phonecopyArr); $i++){
            	if(!empty($phonecopyArr[$i])){
                	$subphone = $subphonecopyArr[$i];
                	$phone = $phonecopyArr[$i];
                	$insertphone = "INSERT INTO PD_Entity_Attribute VALUES (null, $eid, 'phone', \"$subphone\", '$phone', 'Active')";
                	$phoneresult = $dbconnect->query($insertphone);
                }
            }
        }

    	// ------------UPDATE ADDRESS, EMAIL, PHONE -----------------
    	for($i = 0; $i < count($eaidaddress); $i++){
            if(!empty($address1Arr[$i])){
                $subaddress = $subaddressArr[$i];
               	$address['address1'] = $address1Arr[$i];
          		$address['address2'] = $address2Arr[$i];
           		$address['city'] = $cityArr[$i];
           		$address['state'] = $stateArr[$i];
           		$address['country'] = $countryArr[$i];
           		$address['zip'] = $zipArr[$i];
           		$address['pobox'] = $poboxArr[$i];
                $jsonaddress = json_encode($address);
                $updateaddress = "UPDATE PD_Entity_Attribute SET EASubCategory = \"$subaddress\", EAString = '$jsonaddress' WHERE EAID = $eaidaddress[$i]";
                $addressresult = $dbconnect->query($updateaddress);
            }
        }
    	for($i = 0; $i < count($eaidemails); $i++){    			
            if(!empty($emailArr[$i])){
                $subemail = $subemailArr[$i];
                $email = $emailArr[$i];
                $updateemail = "UPDATE PD_Entity_Attribute SET EASubCategory = \"$subemail\", EAString = '$email' WHERE EAID = $eaidemails[$i]";
                $emailresult = $dbconnect->query($updateemail);
           }
        }
    	for($i = 0; $i < count($eaidphone); $i++){    			
            if(!empty($phoneArr[$i])){
                $subphone = $subphoneArr[$i];
                $phone = $phoneArr[$i];
                $updatephone = "UPDATE PD_Entity_Attribute SET EASubCategory = \"$subphone\", EAString = '$phone' WHERE EAID = $eaidphone[$i]";
                $emailresult = $dbconnect->query($updatephone);
           }
        }
        
        if($dbconnect->query($sql) === true){
    		echo "Vendor Updated";
    	}
        else{
           	echo "Error: ".$dbconnect->error;
        }
    }
}



?>