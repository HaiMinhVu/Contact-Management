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
			<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button>	
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
			$sql = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Sample s ON s.SID = sr.SID
								INNER JOIN PD_Entity e ON e.EID = sr.EID
								INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRModifyBy 
                                WHERE SRID = $srid";
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=12%>Sample Name</td>
					<td width=63%><?php echo $row['SName'];?></td>
            		<td>Expected Sample</td>
				</tr>
				<tr>
					<td>Vendor</td>
            		<td><a href='vendor_detail.php?eid=<?php echo $row["EID"]?>'><?php echo $row['EName'];?></a></td>
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

<?php
include ('footer.php');
?>