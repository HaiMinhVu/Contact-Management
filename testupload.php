<?php
if(isset($_POST['submit'])){
	$file = $_FILES['fileToUpload'];
	//print_r($file);
	$fileName = $_FILES['fileToUpload']['name'];
	$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
	$fileSize = $_FILES['fileToUpload']['size'];
	$fileError = $_FILES['fileToUpload']['error'];
	$fileType = $_FILES['fileToUpload']['type'];

	//print_r($fileName);

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');
	
	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			$newname = uniqid('',true).".".$fileActualExt;
			$destination = 'images/'.$newname;
			move_uploaded_file($fileTmpName, $destination);
			echo "uploaded";
		}
		else{
			echo "error uploading";
		}
	}
	else{
		echo "wrong type";
	}
}


?>