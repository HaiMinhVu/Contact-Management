<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$status; $oldname;

?>
<span id="alert_action"></span>
<form method="POST" id="sample_update_form" enctype="multipart/form-data">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Sample Update</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='sample.php'">Back</button>   					
            	</div>
            </div>
			<?php
			$sql = "SELECT * FROM Sample JOIN SMDBAccounts ON SEnterBy = AcctID WHERE SID = $sid";
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
           		$status = $row['SStatus'];
            	$oldname = $row['SImages'];
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Sample Name</td>
					<td width=60%><input type="text" name="sname" id="sname" value="<?php echo $row['SName'];?>" class="form-control"/></td>
            		<td width=30%>Image</td>
					
				</tr>
				<tr>
					<td >Description</td>
            		<td><textarea rows="4" name="sdescription" id="sdescription" class="form-control" ><?php echo $row['SDescription'];?></textarea></td>
            		<td rowspan="5"><?php echo "<img src='images/". $row['SImages']."' height='250' width='300'>"; ?></td>
				</tr>
            	<tr>
					<td>Replace Image</td>
					<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"></td>
				</tr>
            	<tr>
					<td>Status</td>
            		<td><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Enter By</td>
					<td ><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td >Modify Date</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['SModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
			<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            <input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
		</div>
	</div>
</div>
</form>

<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Records Related</h3>
            	</div>
            </div>
			<?php
            $recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
			$recordfetch = $dbconnect->query($recordquery);
			while($rcrow = $recordfetch->fetch_array()){
            ?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h4>Request From: <?php echo $rcrow['EName']?></h4>
            	</div>
            </div>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Type</td>
					<td width=40%><?php echo $rcrow['Type']?></td>
            		<td width=10%>Requested On</td>
            		<td><?php echo $rcrow['DateRequested']?></td>
				</tr>
				<tr>
					<td width=10%>Requested By</td>
					<td width=40%><?php echo $rcrow['username'] ;?></td>
            		<td width=10%>Est Deliver</td>
            		<td><?php echo $rcrow['EstDeliver']?></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><?php echo $rcrow['Quantity'] ;?></td>
            		<td width=10%>Payment Term</td>
            		<td><?php echo $rcrow['PaymentTerms']?></td>
				</tr>
            	<tr>
					<td width=10%>Price/Unit</td>
					<td width=40%><?php echo $rcrow['PriceperUnit'] ;?></td>
            		<td width=10%>Warranty Term</td>
            		<td><?php echo $rcrow['WarrantyTerms']?></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><?php echo $rcrow['SRStatus'] ;?></td>
            		<td width=10%>Shipping Term</td>
            		<td><?php echo $rcrow['ShippingTerms']?></td>
				</tr>
			</table>
            <?php
            }
            ?>
		</div>
	</div>
</div>

        
<?php
if(isset($_POST['Save'])) {
	$sname = $_POST['sname'];
	$sdescription = $_POST['sdescription'];
	$status = $_POST['status'];
	$modify_date = date("Y-m-d h:i");
	$modify_by = $_SESSION['acct_id'];

	$image = $_FILES['uploadimage'];
	$imagename = $_FILES['uploadimage']['name'];
	$imagesize = $_FILES['uploadimage']['size'];
	$imageerror = $_FILES['uploadimage']['error'];
	$destination = "images/";

	$fileext = explode('.',$imagename);
	$ext = strtolower(end($fileext));
	$validext = array('jpg', 'jpeg', 'png');

	if($imagename != ""){
        unlink($destination.$oldname);
        if(in_array($ext,$validext)){
        	if($imageerror === 0){
            	if($imagesize < 5000000){
                	$view = compress_image($image, $destination, 100);

                	$sql = "UPDATE Sample SET SName = '$sname', SDescription = '$sdescription', SImages = '$view', SModifyDate = '$modify_date', SModifyBy = $modify_by, SStatus = '$status' WHERE SID = $sid";
                	$imageresult = $dbconnect->query($sql);
                	if($imageresult){
                    	echo "<script type='text/javascript'>
                	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Sample Updated</div>';
           			 </script>";
                    	echo "<meta http-equiv='refresh' content='1'>";
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
    	$sql = "UPDATE Sample SET SName = '$sname', SDescription = '$sdescription', SModifyDate = '$modify_date', SModifyBy = $modify_by, SStatus = '$status' WHERE SID = $sid";
        $imageresult = $dbconnect->query($sql);
    	if($imageresult){
        	echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Sample Updated</div>';
       			 </script>";
            echo "<meta http-equiv='refresh' content='2'>";
        }
    	else{
        	echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Failed to Update</div>';
       			 </script>";
        }
    }
}
?>

<script type="text/javascript">
function previewImage() {
  var preview = document.querySelector('img');
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
	$('#status').val("<?php echo $status?>");
});
</script>

<?php
include ('footer.php');
?>