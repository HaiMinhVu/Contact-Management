<?php
function employee_option_list($dbconnect){
	$sql = "SELECT * FROM PD_Employee";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SMEmID'].'">'.$row['SMEmName'].'</option>';
    }
	return $output;
}

function entity_option_list($dbconnect){
	$sql = "SELECT * FROM PD_Entity WHERE EStatus = 'Active' ";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['EID'].'">'.$row['EName'].' - '.$row['EStatus'].'</option>';
    }
	return $output;
}

function contact_option_list($dbconnect){
	$sql = "SELECT * FROM PD_Entity_Contact_Person";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['ECID'].'">'.$row['ECName'].' - '.$row['ECEmail'].'</option>';
    }
	return $output;
}

function sample_option_list($dbconnect){
	$sql = "SELECT * FROM PD_Sample";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SID'].'">'.$row['SName'].'</option>';
    }
	return $output;
}

function samplerecord_option_list($dbconnect){
	$sql = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Sample s ON s.SID = sr.SID 
    										INNER JOIN PD_Entity e ON e.EID = sr.EID";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .= '<option value = "'.$row['SRID'].'">'.$row['SName'].' - '.$row['EName'].' - '.$row['Type'].'</option>';
    }
	return $output;
}

<<<<<<< HEAD
function count_total_project_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Project WHERE ProjectStatus = 'Active'");
	return mysqli_num_rows($result);
}
function count_total_project_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Project WHERE ProjectStatus = 'InActive'");
=======
function sample_option_list($dbconnect){
	$sql = "SELECT * FROM Sample";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['SID'].'">'.$row['SName'].'</option>';
    }
	return $output;
}

function samplerecord_option_list($dbconnect){
	$sql = "SELECT * FROM SampleRecord sr INNER JOIN Sample s ON s.SID = sr.SID 
    										INNER JOIN Entity e ON e.EID = sr.EID";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .= '<option value = "'.$row['SRID'].'">'.$row['SName'].' - '.$row['EName'].' - '.$row['Type'].'</option>';
    }
	return $output;
}

function count_total_project_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Project WHERE ProjectStatus = 'Active'");
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	return mysqli_num_rows($result);
}
function count_total_project_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Project WHERE ProjectStatus = 'InActive'");
	return mysqli_num_rows($result);
}


<<<<<<< HEAD

function count_total_entity_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Entity WHERE EStatus = 'Active'");
	return mysqli_num_rows($result);
}
function count_total_entity_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Entity WHERE EStatus = 'InActive'");
=======
function count_total_entity_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Entity WHERE EStatus = 'Active'");
	return mysqli_num_rows($result);
}
function count_total_entity_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Entity WHERE EStatus = 'InActive'");
	return mysqli_num_rows($result);
}

function count_total_sample_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Sample WHERE SStatus = 'Active'");
	return mysqli_num_rows($result);
}
function count_total_sample_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Sample WHERE SStatus = 'InActive'");
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	return mysqli_num_rows($result);
}

function count_total_sample_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Sample WHERE SStatus = 'Active'");
	return mysqli_num_rows($result);
}
function count_total_sample_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Sample WHERE SStatus = 'InActive'");
	return mysqli_num_rows($result);
}

function count_total_contact_active($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Entity_RelateTo_Contact WHERE ERCStatus = 'Active'");
	return mysqli_num_rows($result);
}

function count_total_contact_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM PD_Entity_RelateTo_Contact WHERE ERCStatus = 'InActive'");
	return mysqli_num_rows($result);
}

function count_total_employee($dbconnect){
	$result = $dbconnect->query("SELECT * FROM SMEmployees");
	return mysqli_num_rows($result);
}

// compress image return image name
function compress_image($source, $destination, $quality){
	$imagename = $source['name'];
	$imagetmpname = $source['tmp_name'];

	$fileext = explode('.',$imagename);
	$ext = strtolower(end($fileext));

	$newimagename = uniqid('',true).".".$ext;
    $destination .= $newimagename;
	move_uploaded_file($imagetmpname, $destination);

	list($width, $height) = getimagesize($destination);
	if(($ext == "jpg") ||( $ext == "jpeg")){
		$newfile = imagecreatefromjpeg($destination);
    }
	elseif($ext == "png"){
    	$newfile = imagecreatefrompng($destination);
    }

	if(($width > 3200) || ($height > 2400)){
		$newwidth = $width*0.125;
		$newheight = $height*0.125;
    }
	elseif(($width > 1600) || ($height > 1200)){
		$newwidth = $width*0.25;
		$newheight = $height*0.25;
    }
	elseif(($width > 800) || ($height > 600)){
    	$newwidth = $width*0.5;
		$newheight = $height*0.5;
    }
	else{
    	$newwidth = $width;
    	$newheight = $height;
    }
	
	$truecolor = imagecreatetruecolor($newwidth,$newheight);
	imagecopyresampled($truecolor, $newfile, 0,0,0,0, $newwidth, $newheight, $width, $height);
	imagejpeg($truecolor, $destination, $quality);
	
	return $newimagename;
}



?>