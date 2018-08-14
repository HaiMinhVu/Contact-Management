<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid = $_GET['sid'];

?>
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Sample Review</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<button type="button" name="add" id="add" class="btn btn-success btn-xs" onclick="window.location.href='samplereview_add.php'">Add</button> 
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button> 	
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<?php
			$sql = "SELECT * FROM PD_SampleReview sre INNER JOIN PD_SampleRecord sr ON sr.SRID = sre.SRID
								INNER JOIN PD_Sample s ON s.SID = sr.SID
                                INNER JOIN PD_Entity e ON e.EID = sr.EID
                                INNER JOIN PD_DB_Account sma ON sma.AcctID = sre.ReviewBy
                                WHERE s.SID = $sid";
			$reviewfetch = $dbconnect->query($sql);
			while($row = $reviewfetch->fetch_assoc()){
            	$sreid = $row['SReID'];
			?>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row">
                    <a href="samplereview_update.php?sreid=<?php echo $sreid ?>" class="btn btn-warning btn-xs">Edit</a> 	
                </div>
            </div>
			<table id="sample_review_data" class="table table-bordered table-striped">
				<tr>
					<td width=12%>Sample Name</td>
					<td width=63%><?php echo $row['SName']?></td>
            		<td width=25%>Image</td>
				</tr>
				<tr>
					<td>From Vendor</td>
            		<td><?php echo $row['EName'];?></td>
            		<td rowspan="4"><?php echo "<img src='images/sample_review/". $row['SReImages']."' height='250' width='250'>"; ?></td>
				</tr>
            	<tr>
            		<td>Comment</td>
            		<td><?php echo $row['SReComments'];?></td>
            	</tr>
            	<tr>
					<td>Last Modify By</td>
					<td><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td>Last Modify On</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['ReviewDate'])) ;?></td>
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