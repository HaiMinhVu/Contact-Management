<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$srid =$_GET['srid'];
$status; $oldname;
?>
	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
    	<div class="row">
			<h4>View Record Detail</h4> 
		</div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
        <div class="row" align="right">
<<<<<<< HEAD
			<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button>	
=======
			<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='samplerecord.php'">Back</button>	
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
        </div>
    </div>
	<div style="clear:both"></div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Request Record</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
					<a href="samplerecord_update.php?srid=<?php echo $srid ?>" class="btn btn-warning btn-xs">Edit</a>	
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
			$sql = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Sample s ON s.SID = sr.SID
								INNER JOIN PD_Entity e ON e.EID = sr.EID
								INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRModifyBy 
=======
			$sql = "SELECT * FROM SampleRecord sr INNER JOIN Sample s ON s.SID = sr.SID
								INNER JOIN Entity e ON e.EID = sr.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRModifyBy 
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                                WHERE SRID = $srid";
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=12%>Sample Name</td>
					<td width=63%><?php echo $row['SName'];?></td>
<<<<<<< HEAD
            		<td>Expected Sample</td>
				</tr>
				<tr>
					<td>Vendor</td>
            		<td><a href='vendor_detail.php?eid=<?php echo $row["EID"]?>'><?php echo $row['EName'];?></a></td>
=======
            		<td>Image</td>
				</tr>
				<tr>
					<td>Vendor</td>
            		<td><?php echo $row['EName'];?></td>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
            		<td width=25% rowspan="5"><?php echo "<img src='images/sample/". $row['SImages']."' height='200' width='200'>"; ?></td>
				</tr>
            	<tr>
					<td>Request Type</td>
            		<td><?php echo $row['Type'];?></td>
				</tr>
            	<tr>
					<td>Quantity</td>
            		<td><?php echo $row['Quantity'];?></td>
				</tr>
            	<tr>
					<td>Price/Unit</td>
            		<td><?php echo $row['PriceperUnit'];?></td>
				</tr>
            	<tr>
					<td>Date Requested</td>
            		<td><?php echo $row['DateRequested'];?></td>
				</tr>
            	<tr>
					<td>Payment</td>
            		<td><?php echo $row['PaymentTerms'];?></td>
				</tr>
            	<tr>
					<td>Warranty</td>
            		<td><?php echo $row['WarrantyTerms'];?></td>
				</tr>
            	<tr>
					<td>Shipping</td>
            		<td><?php echo $row['ShippingTerms'];?></td>
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
<<<<<<< HEAD

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Reviews</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<a href="samplereview_add.php?srid=<?php echo $srid?>" class="btn btn-success btn-xs">Add</a>	
                </div>
            </div>
            <div style="clear:both"></div>         
        </div>
		<div class="panel-body">
			<?php
            $recordquery = "SELECT * FROM PD_SampleReview sre 
									INNER JOIN PD_DB_Account sma ON sma.AcctID = sre.ReviewBy
									WHERE sre.SRID = $srid";
			$recordfetch = $dbconnect->query($recordquery);
			while($rcrow = $recordfetch->fetch_array()){
            ?>
			<table id="record_data" class="table table-bordered table-striped">
				<tr>
            		<td width=12%>Review By</td>
            		<td  width=63%><?php echo $rcrow['username'];?></td>
					
            		<td>Actual Sample</td>
				</tr>
				<tr>
					<td>Comments</td>
					<td><?php echo $rcrow['SReComments'];?></td>
            		<td width=25% rowspan="5"><?php echo "<img src='images/sample_review/". $rcrow['SReImages']."' height='200' width='200'>"; ?></td>
				</tr>
            	<tr>
					<td>Review On</td>
            		<td><?php echo $rcrow['ReviewDate'];?></td>
				</tr>
            	
			</table>
            <?php
            }
            ?>
		</div>
	</div>

=======

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Reviews</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<a href="samplereview_add.php?srid=<?php echo $srid?>" class="btn btn-success btn-xs">Add</a>	
                </div>
            </div>
            <div style="clear:both"></div>         
        </div>
		<div class="panel-body">
			<?php
            $recordquery = "SELECT * FROM `SampleReview` sre 
									INNER JOIN SMDBAccounts sma ON sma.AcctID = sre.ReviewBy
									WHERE sre.SRID = $srid";
			$recordfetch = $dbconnect->query($recordquery);
			while($rcrow = $recordfetch->fetch_array()){
            ?>
			<table id="record_data" class="table table-bordered table-striped">
				<tr>
					<td width=12%>Comments</td>
					<td width=63%><?php echo $rcrow['SReComments'];?></td>
            		<td>Image</td>
				</tr>
				<tr>
					<td>Review By</td>
            		<td><?php echo $rcrow['username'];?></td>
            		<td width=25% rowspan="5"><?php echo "<img src='images/sample_review/". $rcrow['SReImages']."' height='200' width='200'>"; ?></td>
				</tr>
            	<tr>
					<td>Review On</td>
            		<td><?php echo $rcrow['ReviewDate'];?></td>
				</tr>
            	
			</table>
            <?php
            }
            ?>
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