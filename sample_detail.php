<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$status; $oldname;
?>
	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
    	<div class="row">
			<h4>View Sample Detail</h4> 
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
	
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Sample</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<a href="sample_review.php?sid=<?php echo $sid ?>" class="btn btn-info btn-xs">Review</a>
					<?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
					<a href="sample_update.php?sid=<?php echo $sid ?>" class="btn btn-warning btn-xs">Edit</a>	
                    <?php
                    }
					?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<?php
<<<<<<< HEAD
			$sql = "SELECT * FROM PD_Sample JOIN PD_DB_Account ON SModifyBy = AcctID WHERE SID = $sid";
=======
			$sql = "SELECT * FROM Sample JOIN SMDBAccounts ON SModifyBy = AcctID WHERE SID = $sid";
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Sample Name</td>
					<td width=65%><?php echo $row['SName'];?></td>
            		<td >Image</td>
				</tr>
				<tr>
					<td >Description</td>
            		<td><?php echo $row['SDescription'];?></td>
            		<td width=25% rowspan="4"><?php echo "<img src='images/sample/". $row['SImages']."' height='200' width='200'>"; ?></td>
				</tr>
            	<tr>
					<td>Status</td>
            		<td><?php echo $row['SStatus'];?></td>
				</tr>
            	<tr>
					<td>Last Modify By</td>
					<td><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td>Last Modify On</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['SModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Request Records</font></h3>
                </div>
            </div>
            <div style="clear:both"></div>         
        </div>
		<div class="panel-body">
			<?php
<<<<<<< HEAD
            $recordquery = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Entity e ON sr.EID = e.EID
															INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRRequestBy 
                                                            WHERE SID = $sid";
=======
            $recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
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
                    <?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
                    <a href="samplerecord_detail.php?srid=<?php echo $rcrow["SRID"]; ?>" class="btn btn-info btn-xs">View</a>
                    <a href="samplerecord_update.php?srid=<?php echo $rcrow["SRID"]; ?>" class="btn btn-warning btn-xs">Edit</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div style="clear:both"></div>
			<table id="record_data" class="table table-bordered table-striped">
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
<<<<<<< HEAD

=======

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

>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
<?php
include ('footer.php');
?>