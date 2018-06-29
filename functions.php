<?php
// list all brands for option selected
function brand_option_list($dbconnect){
	$sql = "SELECT * FROM SMBrands WHERE BrandStatus='Active'";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['BrandID'].'">'.$row['BrandName'].'</option>';
    }
	return $output;
}

function department_option_list($dbconnect){
	$sql = "SELECT * FROM SMDepartments";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SMDeptID'].'">'.$row['SMDeptName'].'</option>';
    }
	return $output;
}

function employee_option_list($dbconnect){
	$sql = "SELECT * FROM SMEmployees";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SMEmID'].'">'.$row['SMEmName'].'</option>';
    }
	return $output;
}

function entity_option_list($dbconnect){
	$sql = "SELECT * FROM Entity WHERE EStatus = 'Active'";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['EID'].'">'.$row['EName'].'</option>';
    }
	return $output;
}

function contact_option_list($dbconnect){
	$sql = "SELECT * FROM Entity_Contact WHERE ECStatus = 'Active'";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['ECID'].'">'.$row['ECName'].' - '.$row['ECEmail'].'</option>';
    }
	return $output;
}

function sample_option_list($dbconnect){
	$sql = "SELECT * FROM Sample WHERE SStatus = 'Active'";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SID'].'">'.$row['SName'].'</option>';
    }
	return $output;
}

function count_total_project($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Project WHERE ProjectStatus = 'Active'");
	return mysqli_num_rows($result);
}

function count_total_entity($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Entity WHERE EStatus = 'Active'");
	return mysqli_num_rows($result);
}

function count_total_sample($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Sample");
	return mysqli_num_rows($result);
}

function count_total_brand($dbconnect){
	$result = $dbconnect->query("SELECT * FROM SMBrands");
	$count = mysqli_num_rows($result);
	return ($count-1);
}

function count_total_employee($dbconnect){
	$result = $dbconnect->query("SELECT * FROM SMEmployees");
	return mysqli_num_rows($result);
}

function count_total_product($dbconnect){
	$result = $dbconnect->query("SELECT * FROM SMProducts");
	return mysqli_num_rows($result);
}

function count_total_department($dbconnect){
	$result = $dbconnect->query("SELECT * FROM SMDepartments");
	return mysqli_num_rows($result);
}
?>