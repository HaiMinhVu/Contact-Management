<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$status; $oldname;
?>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Sample Update</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='sample.php'">Back</button> 	
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<form method="POST" id="sample_update_form" enctype="multipart/form-data">
			<?php
<<<<<<< HEAD
			$sql = "SELECT * FROM PD_Sample JOIN PD_DB_Account ON SModifyBy = AcctID WHERE SID = $sid";
=======
			$sql = "SELECT * FROM Sample JOIN SMDBAccounts ON SModifyBy = AcctID WHERE SID = $sid";
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
           		$status = $row['SStatus'];
            	$oldname = $row['SImages'];
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Sample Name</td>
					<td width=60%><input type="text" name="sname" id="sname" value="<?php echo $row['SName'];?>" class="form-control" required/></td>
            		<td width=30%>Image</td>
					
				</tr>
				<tr>
					<td >Description</td>
            		<td><textarea rows="4" name="sdescription" id="sdescription" class="form-control" ><?php echo $row['SDescription'];?></textarea></td>
            		<td rowspan="5"><?php echo "<img id='previewim' src='images/sample/". $row['SImages']."' height='300' width='300'>"; ?></td>
				</tr>
            	<tr>
					<td>Replace Image</td>
					<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"></td>
				</tr>
            	<tr>
					<td width=10%>Location</td>
					<td width=60%><input type="text" name="slocation" id="slocation" value="<?php echo $row['SLocation'];?>" class="form-control"/></td>
            	</tr>
            	<tr>
					<td>Status</td>
            		<td><select name="status" id="status" class="form-control" required>
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Last Modify By</td>
					<td ><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td >Last Modify On</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['SModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
<<<<<<< HEAD
            <div style="text-align:center">
				<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
            </div>
            </form>
		</div>
	</div>
=======
				<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
            </form>
		</div>
	</div>
	<!--
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Records Related</font></h3>
                </div>
            </div>
            <div style="clear:both"></div>         
        </div>
		<div class="panel-body">
			<?php
            $recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
			$recordfetch = $dbconnect->query($recordquery);
			while($rcrow = $recordfetch->fetch_array()){
            ?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h5>Request From: <?php echo $rcrow['EName']?></h5>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <a href="samplerecord_update.php?srid=<?php echo $rcrow["SRID"]; ?>" class="btn btn-warning btn-xs">EDIT</a>
                </div>
            </div>
            <div style="clear:both"></div>
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
	-->
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
	$destination = "images/sample/";

	$fileext = explode('.',$imagename);
	$ext = strtolower(end($fileext));
	$validext = array('jpg', 'jpeg', 'png');

	if($imagename != ""){
    	unlink($destination.$oldname);	// delete old image when uploading new one
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
	$('#status').val("<?php echo $status?>");

	$('#sample_update_form').submit(function(event){
        event.preventDefault();
    	var sid = "<?php echo $sid ;?>";
    	var oldname = "<?php echo $oldname ;?>";
        var data = new FormData(this);
    	data.append("action", "update");
    	data.append("sid", sid);
    	data.append("oldname", oldname);
    	
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