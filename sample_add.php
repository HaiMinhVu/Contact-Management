<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<span id="alert_action"></span>
			<div class="panel panel-default">
				<div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title"><font color="#2775F5">Add New Sample</font></h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
<<<<<<< HEAD
                            <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button>	
=======
                            <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='sample.php'">Back</button>	
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
				<div class="panel-body">
				<form method="POST" id="sample_add_form" enctype="multipart/form-data">
					<table id="add_sample" class="table table-bordered table-striped">
						<tr>
<<<<<<< HEAD
							<td width=14%>Sample Name</td>
=======
							<td width=20%>Sample Name</td>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
							<td><input type="text" name="sname" id="sname" class="form-control" required /></td>
						</tr>
            			<tr>
							<td>Image</td>
							<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"><br>
							<img id="previewim" src="" height="200" alt="Image preview..."></td>
						</tr>
						<tr>
<<<<<<< HEAD
							<td>Location</td>
							<td><input type="text" name="slocation" id="slocation" class="form-control" placeholder="place to store sample" /></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><textarea rows="5" name="sdescription" id="sdescription" class="form-control" ></textarea></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><select name="status" id="status" class="form-control" required>
=======
							<td>Status</td>
							<td><select name="status" id="status" class="form-control">
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                    			<option value="">Select Status</option>
                    			<option value="Active" selected>Active</option>
                        		<option value="InActive">InActive</option>
                    		</select></td>
						</tr>
<<<<<<< HEAD
					</table>
					<div style="text-align:center">
						<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            			<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />	
					</div>
				</form>
				</div>
			</div>
=======
						<tr>
							<td>Description</td>
							<td><textarea rows="5" name="sdescription" id="sdescription" class="form-control" ></textarea></td>
						</tr>
					</table>
					<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            		<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />	
				</form>
				</div>
			</div>

<?php
if(isset($_POST['Add'])) {
	$sname = $_POST['sname'];
	$sdescription = $_POST['sdescription'];
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
            		$imagesql = "INSERT INTO Sample VALUES(null, '$sname', '$sdescription', '$view', $modify_by, '$status', '$modify_date', $modify_by)";
            		$imageresult = $dbconnect->query($imagesql);
            		if($imageresult){
                		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">New Sample Added</div>';
       			 </script>";
                	}
            	}
        		else{
            		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">File is too big</div>';
       			 </script>";
            	}
        	}
    		else{
        		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Error uploading image. Error Code: ".$imageerror."</div>';
       			 </script>";
        	}
    	}
		else{
    		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Only allow .jpg .png files</div>';
       			 </script>";
    	}
    }
	else{
    	$imagesql = "INSERT INTO Sample VALUES(null, '$sname', '$sdescription', null, $modify_by, '$status', '$modify_date', $modify_by)";
        $imageresult = $dbconnect->query($imagesql);
        if($imageresult){
            echo '<div class="alert alert-info">New Sample Added</div>';
        }
    }
}
?>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

<script type="text/javascript">
function previewImage() {
  var preview = document.querySelector('#previewim');
  var file    = document.querySelector('#uploadimage').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}
</script>
<script>
$(document).ready(function(){

	$('#sample_add_form').submit(function(event){
        event.preventDefault();
        var data = new FormData(this);
    	data.append("action", "add");
        $.ajax({
           	type:"post",
           	url:"sample_action.php",
           	data:data,
           	contentType: false,
        	cache: false,
   			processData:false,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
                window.setTimeout(function(){location.reload()},2000)
           	}
        });
    });
});
</script>

<?php
include ('footer.php');
?>