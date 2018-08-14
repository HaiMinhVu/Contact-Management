<?php
include('dbconnect.php');
include('functions.php');

if($_POST['action'] == "add") {
	$srid = $_POST['srid'];
	$srecomment = $_POST['srecomment'];
	$modify_date = date("Y-m-d h:i");
	$modify_by = $_SESSION['acct_id'];

	$image = $_FILES['uploadimage'];
	$imagename = $_FILES['uploadimage']['name'];
	$imagesize = $_FILES['uploadimage']['size'];
	$imageerror = $_FILES['uploadimage']['error'];
	$destination = "images/sample_review/";

	$fileext = explode('.',$imagename);
	$ext = strtolower(end($fileext));
	$validext = array('jpg', 'jpeg', 'png');

	if($imagename != ""){
		if(in_array($ext,$validext)){
    		if($imageerror == 0){
        		if($imagesize < 5000000){
            		$returnimage = compress_image($image, $destination, 100);
            		$imagesql = "INSERT INTO PD_SampleReview VALUES(null, $srid, '$returnimage', '$srecomment', $modify_by, '$modify_date')";
            		$imageresult = $dbconnect->query($imagesql);
            		if($imageresult){
                		echo "New Review Added";
                	}
            	}
        		else{
            		echo "File is too big";
            	}
        	}
    		else{
        		echo "Error: ".$imageerror;
        	}
    	}
		else{
    		echo "Only allow .jpg .png files";
    	}
    }
	else{
    	$imagesql = "INSERT INTO PD_SampleReview VALUES(null, $srid, null, '$srecomment', $modify_by, '$modify_date')";
        $imageresult = $dbconnect->query($imagesql);
        if($imageresult){
            echo "New Review Added";
        }
    	else{
        	echo "Failed to Add";
        }
    }
}

if($_POST['action'] == "save") {
	$oldname = $_POST['oldname'];
	$sreid = $_POST['sreid'];
	$srid = $_POST['srid'];
	$srecomment = $_POST['srecomment'];
	$modify_date = date("Y-m-d h:i");
	$modify_by = $_SESSION['acct_id'];

	$image = $_FILES['uploadimage'];
	$imagename = $_FILES['uploadimage']['name'];
	$imagesize = $_FILES['uploadimage']['size'];
	$imageerror = $_FILES['uploadimage']['error'];
	$destination = "images/sample_review/";
	
	$fileext = explode('.',$imagename);
	$ext = strtolower(end($fileext));
	$validext = array('jpg', 'jpeg', 'png');
	
	if($imagename != ""){
    	unlink($destination.$oldname);	// delete old image when uploading new one
		if(in_array($ext,$validext)){
    		if($imageerror === 0){
        		if($imagesize < 5000000){
            		$view = compress_image($image, $destination, 100);
            		$sql = "UPDATE PD_SampleReview SET SRID = $srid, SReComments = '$srecomment', SReImages = '$view', ReviewDate = '$modify_date', ReviewBy = $modify_by WHERE SReID = $sreid";
            		$imageresult = $dbconnect->query($sql);
            		if($imageresult){
                		echo "Review Updated";
               		}
                	else{
                    	echo "Update Failed";
                    }
            	}
        		else{
            		echo "File is too big";
            	}
        	}
    		else{
        		echo "Image Error: ".$imageerror;
        	}
    	}
		else{
    		echo "Only allow .jpg .png files";
    	}
    }
	else{
    	$sql = "UPDATE PD_SampleReview SET SRID = $srid, SReComments = '$srecomment', ReviewDate = '$modify_date', ReviewBy = $modify_by WHERE SReID = $sreid";
        $imageresult = $dbconnect->query($sql);
    	if($imageresult){
        	echo "Sample Updated";
        }
    	else{
        	echo "Update Failed";
        }
    }
}

?>