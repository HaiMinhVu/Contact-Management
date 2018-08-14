<?php
include('dbconnect.php');
include('functions.php');

if(isset($_POST['btn_action']))
{
    if($_POST['btn_action'] == 'delete')
    {   
        $status = "Active";
        if($_POST['status'] == "Active"){
            $status = "InActive";
        }   
        $modify_date = date("Y-m-d H:i");
        $modify_by = $_SESSION['acct_id'];
        $sid = $_POST['sid'];
        $query = "UPDATE PD_Sample SET SStatus = '$status', SModifyDate = '$modify_date', SModifyBy = $modify_by WHERE SID = $sid";
        if($dbconnect->query($query) == TRUE){
            echo 'Sample '.$_POST['sid'].'  Set to '.$status;
        }
        else{
            echo "Failed to Delete";
        }   
    }
}
else{
    if($_POST['action'] == "add") {
        $sname = $_POST['sname'];
        $sdescription = $_POST['sdescription'];
        $slocation = $_POST['slocation'];
        $status = $_POST['status'];
        $modify_date = date("Y-m-d h:i");
        $modify_by = $_SESSION['acct_id'];

        $imagename = $_FILES['uploadimage']['name'];
        $imagesize = $_FILES['uploadimage']['size'];
        $imageerror = $_FILES['uploadimage']['error'];
        
        $image = $_FILES['uploadimage'];
        $destination = "images/sample/";

        $fileext = explode('.',$imagename);
        $ext = strtolower(end($fileext));
        $validext = array('jpg', 'jpeg', 'png');

        if($imagename != ""){
            if(in_array($ext,$validext)){
                if($imageerror === 0){
                    if($imagesize < 5000000){
                        $view = compress_image($image, $destination, 100);
                        $imagesql = "INSERT INTO PD_Sample VALUES(null, '$sname', '$sdescription', '$view', '$slocation', $modify_by, '$status', '$modify_date', $modify_by)";
                        $imageresult = $dbconnect->query($imagesql);
                        if($imageresult){
                            echo "New Sample Added";
                        }
                    }
                    else{
                        echo "File is too big";
                    }
                }
                else{
                    echo "Error uploading image. Error Code: ".$imageerror;
                }
            }
            else{
                echo "Only allow .jpg .png files</div>";
            }
        }
        else{
            $imagesql = "INSERT INTO PD_Sample VALUES(null, '$sname', '$sdescription', null, '$slocation', $modify_by, '$status', '$modify_date', $modify_by)";
            $imageresult = $dbconnect->query($imagesql);
            if($imageresult){
                echo "New Sample Added";
            }
        }
    }
    if($_POST['action'] == "update") {
    	$sid = $_POST['sid'];
    	$oldname = $_POST['oldname'];
        $sname = $_POST['sname'];
        $sdescription = $_POST['sdescription'];
    	$slocation = $_POST['slocation'];
        $status = $_POST['status'];
        $modify_date = date("Y-m-d h:i");
        $modify_by = $_SESSION['acct_id'];

        $image = $_FILES['uploadimage'];
        $imagename = $_FILES['uploadimage']['name'];
        $imagesize = $_FILES['uploadimage']['size'];
        $imageerror = $_FILES['uploadimage']['error'];
        $destination = "images/sample/";
		
        $fileext = explode('.',$imagename);
        $ext = strtolower(end($fileext));
        $validext = array('jpg', 'jpeg', 'png');

        if($imagename != ""){
            unlink($destination.$oldname);  // delete old image when uploading new one
            if(in_array($ext,$validext)){
                if($imageerror === 0){
                    if($imagesize < 5000000){
                        $view = compress_image($image, $destination, 100);
                        $sql = "UPDATE PD_Sample SET SName = '$sname', SLocation = '$slocation', SDescription = '$sdescription', SImages = '$view', SModifyDate = '$modify_date', SModifyBy = $modify_by, SStatus = '$status' WHERE SID = $sid";
                        $imageresult = $dbconnect->query($sql);
                        if($imageresult){
                            echo "Sample Updated";
                        }
                    	else{
                        	echo "Failed to Update". $sql;
                        }
                    }
                    else{
                            echo "File is too big";
                    }
                }
                else{
                    echo "Error uploading image. Error Code: ".$imageerror;
                }
            }
            else{
                echo "Only allow .jpg .png files";
            }
        }
        else{
            $sql = "UPDATE PD_Sample SET SName = '$sname', SLocation = '$slocation', SDescription = '$sdescription', SModifyDate = '$modify_date', SModifyBy = $modify_by, SStatus = '$status' WHERE SID = $sid";
            $imageresult = $dbconnect->query($sql);
            if($imageresult){
                echo "Sample Updated";
            }
            else{
                echo "Failed to Update".$sql;
            }
        }
    }
}

?>