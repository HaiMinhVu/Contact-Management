<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
?>

<form method="POST" id="sample_add_form" enctype="multipart/form-data">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Add New Sample</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='sample.php'">Back</button>   					
            	</div>
            </div>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Sample Name</td>
					<td><input type="text" name="sname" id="sname" class="form-control" required /></td>
				</tr>
            	<tr>
					<td>Description</td>
					<td><input type="text" name="sdescription" id="sdescription" class="form-control" /></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()" class="form-control" />
                    <img src="" height="200" alt="Image preview..."></td>
				</tr>
				<tr>
                    <td>Status</td>
                    <td><select name="status" id="status" class="form-control" required>
                        <option value="">Select Status</option>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
                </tr>
			</table>
			<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            <input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />
		</div>
	</div>
</div>
</form>

<?php
if (isset($_POST['Add'])) {
    $sname = $_POST['sname'];
    $sdescription = $_POST['sdescription'];
    
    $status = $_POST['status'];
    $modify_date = date("Y-m-d h:i");
    $modify_by = $_SESSION['acct_id'];

    //$image = $_FILES['uploadimage'];
    $imagename = $_FILES['uploadimage']['name'];
    $imagetmpname = $_FILES['uploadimage']['tmp_name'];
    $imagesize = $_FILES['uploadimage']['size'];
    $imageerror = $_FILES['uploadimage']['error'];

    $fileext = explode('.', $imagename);
    $ext = strtolower(end($fileext));
    $validext = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($ext, $validext)) {
        if ($imageerror === 0) {
            if ($imagesize < 100000) {
                $NewImageName = uniqid('',true).".".$ext;
                $destination = "images/".$NewImageName;
                move_uploaded_file($imagetmpname, $destination);

                $imagesql = "INSERT INTO Sample VALUES(null, '$sname', '$sdescription', '$NewImageName', $modify_by, '$status', '$modify_date', $modify_by)";
                $imageresult = $dbconnect->query($imagesql);

                if($imageresult){
                    echo "<div class='alert alert-warning'>New Sample Added</div>";
                }
            }
            else{
                echo "<div class='alert alert-warning'>File $imagename is too big</div>";
            }
        }
        else{
            echo "<div class='alert alert-warning'>Error uploading: $imageerror</div>";
        }
    }
    else{
        echo "<div class='alert alert-warning'>Only allow .jpg, .png, .gif</div>";
    }
}
?>

<script type="text/javascript">
    function previewImage() {
        var preview = document.querySelector('img');
        var file    = document.querySelector('#uploadimage').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function(){
            preview.src = reader.result;
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<?php
include ('footer.php');
?>