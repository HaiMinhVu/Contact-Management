<?php
// list all brands for option selected
function brand_option_list($dbconnect){
	$sql = "SELECT * FROM SMBrands";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['BrandID'].'">'.$row['BrandName'].' - '.$row['BrandStatus'].'</option>';
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
    	$output .='<option value = "'.$row['SMEmID'].'">'.$row['SMEmName'].' - '.$row['WorkStatus'].'</option>';
    }
	return $output;
}

function entity_option_list($dbconnect){
	$sql = "SELECT * FROM Entity";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['EID'].'">'.$row['EName'].'  - '.$row['EStatus'].'</option>';
    }
	return $output;
}

function contact_option_list($dbconnect){
	$sql = "SELECT * FROM Entity_Contact";
	$result = $dbconnect->query($sql);
	$output = '';
	foreach ($result as $row){
    	$output .='<option value = "'.$row['ECID'].'">'.$row['ECName'].' - '.$row['ECEmail'].'</option>';
    }
	return $output;
}

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
	return mysqli_num_rows($result);
}
function count_total_project_inactive($dbconnect){
	$result = $dbconnect->query("SELECT * FROM Project WHERE ProjectStatus = 'InActive'");
	return mysqli_num_rows($result);
}


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