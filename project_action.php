<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action'])){
    if($_POST['btn_action'] == 'delete'){   
        $modify_date = date("Y-m-d H:i");
        $modify_by = $_SESSION['acct_id'];
        $project_id = $_POST['project_id'];
        $status = "Active";
        if($_POST['status'] == "Active"){
            $status = "InActive";
        }   
        $query = "UPDATE PD_Project SET ProjectStatus = '$status', ModifyDate = '$modify_date', ModifyBy = $modify_by WHERE ProjectID = $project_id";
        if($dbconnect->query($query) == TRUE){
            echo 'Project '.$project_id.'  Set to '.$status;
        }
        else{
            echo "Failed to Delete";
        }
    }
}
else{
    if($_POST['action']=="add" || $_POST['action']=="save"){
    	$status = '';
    	if(empty($_POST['projectstatus'])){
        	$status = 'InActive';
        }
    	else{
        	$status = 'Active';
        }
    	$end_date = "";
    	$projectname = $_POST['project_name'];
    	$projectdescription = $_POST['project_description'];
    	$date_created = date('Y-m-d H:i');
    	$start_date = (($_POST['startdate'] != '') ? ($start_date = $_POST['startdate']) : ($start_date = "1969-12-31"));
    	$est_end_date = (($_POST['estcompletedate'] != '') ? ($est_end_date = $_POST['estcompletedate']) : ($est_end_date = "1969-12-31"));
    	$end_date = (($_POST['completedate'] != '') ? ($end_date = $_POST['completedate']) : ($end_date = "1969-12-31"));
    	$project_progress = $_POST['progress'];
    	$project_lead = $_POST['project_lead'];
    	$modify_date = date('Y-m-d H:i');
    	$modify_by = $_SESSION['acct_id'];
    	$sampleid = $_POST['sampleid'];

    	$sql = "INSERT INTO PD_Project VALUES(null, '$projectname', '$projectdescription', '$date_created', '$start_date', '$est_end_date', '$end_date', $modify_by, $project_lead, '$modify_date', $modify_by, '$project_progress', '$status')";
        if($dbconnect->query($sql) == TRUE){
        	$maxproid;
        	$tmpsql = "SELECT MAX(ProjectID) FROM PD_Project";
        	$tmpresult = $dbconnect->query($tmpsql);
        	while($prorow = $tmpresult->fetch_assoc()){
            	$maxproid = $prorow['MAX(ProjectID)'];
            	foreach ($sampleid as $sid){
                	$p_require_s = "INSERT INTO PD_Project_Require_Sample VALUES($maxproid, $sid)";
                	$p_require_s_result = $dbconnect->query($p_require_s);
                }
            }
        	if($_POST['action']=="add"){
            	echo "New Project Added. Processing to sample record ...";
            	
            }elseif($_POST['action']=="save"){
            	echo "New Project Saved";
            }
        }
        else{
            echo $sql;
        }
    }

    if($_POST['action']=="save_update"){
        $projectid = $_POST['projectid'];
        $sidarray = array();
        $p_require_s = "SELECT SID FROM PD_Project_Require_Sample WHERE ProjectID = $projectid";
        $p_require_s_result = $dbconnect->query($p_require_s);
        while($sidrow = $p_require_s_result->fetch_assoc()){
            array_push($sidarray, $sidrow['SID']);
        }
    	
    	if(empty($_POST['projectstatus'])){
        	$status = 'InActive';
        }
    	else{
        	$status = 'Active';
        }
    	$projectname = $_POST['project_name'];
    	$projectdescription = $_POST['project_description'];
    	$start_date = (($_POST['startdate'] != '') ? ($start_date = $_POST['startdate']) : ($start_date = "1969-12-31"));
        $est_end_date = (($_POST['estcompletedate'] != '') ? ($est_end_date = $_POST['estcompletedate']) : ($est_end_date = "1969-12-31"));
    	$end_date;
    	$project_progress = $_POST['progress'];
    	$project_lead = $_POST['project_lead'];
    	$modify_date = date('Y-m-d H:i');
    	$modify_by = $_SESSION['acct_id'];
        if($project_progress == "Complete"){
            $end_date = date('Y-m-d H:i');
        }
        else{
            $end_date = (($_POST['completedate'] != '') ? ($end_date = $_POST['completedate']) : ($end_date = "1969-12-31"));
        }
    	
    	$sql = "UPDATE PD_Project SET ProjectName = '$projectname', ProjectDescription = '$projectdescription', StartDate = '$start_date', EstEndDate = '$est_end_date', EndDate = '$end_date', Progress = '$project_progress', ModifyDate = '$modify_date', ModifyBy = $modify_by, ProjectStatus = '$status', ProjectLead = '$project_lead'
                WHERE ProjectID = $projectid";

        $sampleid = $_POST['sampleid'];
    	$oldarray = $newarray = $lostarray = array();
    	foreach ($sampleid as $sid){
        	if(in_array($sid, $sidarray)){
            	array_push($oldarray, $sid);
            }
        	else{
            	array_push($newarray, $sid);
            }
        }
    	$lostarray = array_diff( $sidarray, $sampleid);
    	
        if($dbconnect->query($sql) === TRUE){
        	foreach ($newarray as $newsid){
                	$newsql = "INSERT INTO PD_Project_Require_Sample VALUES($projectid, $newsid)";
                	$newresult = $dbconnect->query($newsql);
            }
        	foreach ($lostarray as $lostsid){
                	$lostsql = "DELETE FROM PD_Project_Require_Sample WHERE ProjectID = $projectid AND SID = $lostsid";
                	$lostresult = $dbconnect->query($lostsql);
            }
    		echo "Project Updated";
    	}
        else{
            echo $sql;
        }
    }

	if($_POST['action']=="addlead"){
    	$employeename = $_POST['employeename'];
    	$employeetitle = $_POST['employeetitle'];
    	$manager = (($_POST['manager'] != NULL) ? ($manager = $_POST['manager']) : ($manager = 'NULL'));
    	
    	$worktype = $_POST['worktype'];
    	$insertlead = "INSERT INTO PD_Employee VALUES (null, '$employeename', '$employeetitle', $manager, '$worktype', 'Active')";
    	if($dbconnect->query($insertlead)){
        	echo "New Employee Added";
        }
    	else{
        	echo $insertlead;;
        }
    
    }

}

?>