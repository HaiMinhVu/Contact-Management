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
			<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button>	
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
			$sql = "SELECT * FROM PD_Sample JOIN PD_DB_Account ON SModifyBy = AcctID WHERE SID = $sid";
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
            $recordquery = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Entity e ON sr.EID = e.EID
															INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRRequestBy 
                                                            WHERE SID = $sid";
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

<?php
include ('footer.php');
?>