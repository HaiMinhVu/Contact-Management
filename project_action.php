<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action'])){
	/* dynamic load brand for add new items
	 * if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($connect, $_POST['category_id']);
	}*/

	//// add new item
	if($_POST['btn_action'] == 'Add'){	
    	// get information from the Add form;
    	$project_name = $_POST['project_name'];
    	$project_description = $_POST['project_description'];
    	$brand_id = $_POST['brand_id'];
    	$dept_id = $_POST['dept_id'];
    	$date_created = date("Y-m-d");
    	$start_date = $_POST['startdate'];
    	$est_end_date = $_POST['estcompletedate'];
    	$end_date = (($_POST['completedate'] != '') ? ($end_date = $_POST['completedate']) : ($end_date = "1969-12-31"));
    	$enter_by = $_SESSION['acct_id'];
    	$project_lead = $_POST['project_lead'];
    	$modify_date = date("Y-m-d h:i");
    	$modify_by = $_SESSION['acct_id'];
    	$project_progress = $_POST['progress'];
    	$project_status = "Active";
        $query = "INSERT INTO Project (ProjectName, ProjectDescription, BrandBelongTo, DeptBelongTo, DateCreated, StartDate, EstEndDate, EndDate, Progress, ProjectStatus, EnterBy, ProjectLead, ModifyDate, ModifyBy) VALUES ('$project_name', '$project_description', $brand_id, $dept_id, '$date_created', '$start_date', '$est_end_date', '$end_date', '$project_progress', '$project_status', $enter_by, $project_lead, '$modify_date', $modify_by)";
        
		if($dbconnect->query($query) === TRUE){
			echo 'New Project Added';
		}
    	else{
        	echo 'Failed to Add'.$query;
        }
	}

	//// load single item into update form
	if($_POST['btn_action'] == 'fetch_single'){
    	$projectid = $_POST['project_id'];
		$query = "SELECT * FROM Project WHERE ProjectID = $projectid";
		$result = $dbconnect->query($query);
    	while($row = $result->fetch_assoc()){
        	// retrieve data from database and load into edit form
			$output['project_name'] = $row['ProjectName'];
        	$output['project_description'] = $row['ProjectDescription'];
			$output['brand_id'] = $row['BrandBelongTo'];
			$output['dept_id'] = $row['DeptBelongTo'];
			$output['created_date'] = date('Y-m-d', strtotime($row['DateCreated']));
			$output['start_date'] =  date('Y-m-d', strtotime($row['StartDate']));
			$output['est_end_date'] =  date('Y-m-d', strtotime($row['EstEndDate']));
			$output['end_date'] = date('Y-m-d', strtotime($row['EndDate']));
        	$output['project_lead'] = $row['ProjectLead'];
			$output['progress'] = $row['Progress'];
        	$output['status'] = $row['ProjectStatus'];
		}
		echo json_encode($output);
	}

	//// submit update/edit item information
	if($_POST['btn_action'] == 'Edit'){
    	$projectid = $_POST['project_id'];
    	$projectname = $_POST['project_name'];
        $projectdescription = $_POST['project_description'];
    	$brandid = $_POST['brand_id'];
    	$deptid = $_POST['dept_id'];
    	$date_created = $_POST['datecreated'];
    	$start_date = $_POST['startdate'];
    	$est_end_date = $_POST['estcompletedate'];
    	$end_date = $_POST['completedate'];
    	$project_lead = $_POST['project_lead'];
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	$project_progress = $_POST['progress'];

		$query = "UPDATE Project SET ProjectName = '$projectname', ProjectDescription = '$projectdescription', BrandBelongTo = '$brandid', DeptBelongTo = '$deptid', DateCreated = '$date_created', StartDate = '$start_date', EstEndDate = '$est_end_date', EndDate = '$end_date', Progress = '$project_progress', ProjectLead = $project_lead, ModifyDate = '$modify_date', ModifyBy = $modify_by 
            WHERE ProjectID = $projectid";
        
		if($dbconnect->query($query) === TRUE){
			echo 'Project '.$projectname.' Updated';
		}
    	else{
        	echo "Failed to Update";
        }
	}

	/// delete an item
	if($_POST['btn_action'] == 'delete'){	
    	$modify_date = date("Y-m-d H:i");
    	$modify_by = $_SESSION['acct_id'];
    	$project_id = $_POST['project_id'];
    	$status = "Active";
    	if($_POST['status'] == "Active"){
        	$status = "InActive";
        }	
		$query = "UPDATE Project SET ProjectStatus = '$status', ModifyDate = '$modify_date', ModifyBy = $modify_by WHERE ProjectID = $project_id";
		if($dbconnect->query($query) == TRUE){
			echo 'Project '.$project_id.'  Set to '.$status;
		}
    	else{
        	echo "Failed to Delete";
        }
	}
}
?>