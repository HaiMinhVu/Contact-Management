<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$samplename;
$srid;
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
    
<!---------------- General Sample Info ----------------->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                <div class="row">
                    <h3 class="panel-title">Sample Info</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
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
            	$samplename = $row['SName'];
            ?>
            <table id="sample_data" class="table table-bordered table-striped">
                <tr>
                    <td width=10%>Sample Name</td>
                    <td width=65%><?php echo $row['SName'];?></td>
                    <td width=25%>Expected Sample</td>
                </tr>
                <tr>
                    <td >Description</td>
                    <td><?php echo $row['SDescription'];?></td>
                    <td rowspan="5"><?php echo "<img src='images/sample/". $row['SImages']."' height='200' width='200'>"; ?></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><?php echo $row['SLocation'];?></td>
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

<!---------------- Show all request record for this sample ----------------->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                <div class="row">
                    <h3 class="panel-title"><?php echo $samplename?> Requested Records</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <a href="samplerecord_add.php" class="btn btn-success btn-xs">Add</a>  
                </div>
            </div>
            <div style="clear:both"></div>         
        </div>
        <div class="panel-body">
            <?php
            $recordquery = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_Entity e ON sr.EID = e.EID
                                                            INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRRequestBy 
                                                            WHERE SID = $sid
                                                            ORDER BY EName";
            $recordfetch = $dbconnect->query($recordquery);
            while($rcrow = $recordfetch->fetch_array()){
            
            ?>
            <a data-toggle="collapse" href="#recordcollapse<?php echo $rcrow['SRID']; ?>" aria-expanded="false" aria-controls="collapseExample">
            <table  class="table ">
                <tr>
                    <td width=25%>Request From: <?php echo $rcrow['EName']; ?></td>
                    <td width=25%>Type: <?php echo $rcrow['Type']; ?></td>
                </tr>
            </table>
            </a>
            <div class="collapse" id="recordcollapse<?php echo $rcrow['SRID']; ?>">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                	<div class="row">
                        <?php
                        if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
                        {
                        ?>
                        <a href="samplerecord_detail.php?srid=<?php echo $rcrow['SRID']; ?>" class="btn btn-info btn-xs">View</a>
                        <a href="samplerecord_update.php?srid=<?php echo $rcrow['SRID']; ?>" class="btn btn-warning btn-xs">Edit</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <table id="record_data" class="table table-bordered table-striped">
                    <tr>
                        <td width=10%>Requested By</td>
                        <td width=40%><?php echo $rcrow['username'] ;?></td>
                        <td width=10%>Requested On</td>
                        <td><?php echo $rcrow['DateRequested']?></td>
                    </tr>
                    <tr>
                        <td width=10%>Quantity</td>
                        <td width=40%><?php echo $rcrow['Quantity'] ;?></td>
                        <td width=10%>Est Deliver</td>
                        <td><?php echo $rcrow['EstDeliver']?></td>
                    </tr>
                    <tr>
                        <td width=10%>Price/Unit</td>
                        <td width=40%><?php echo $rcrow['PriceperUnit'] ;?></td>
                        <td width=10%>Payment Term</td>
                        <td><?php echo $rcrow['PaymentTerms']?></td>
                    </tr>
                    <tr>
                        <td width=10%>Used</td>
                        <td width=40%><?php echo $rcrow['Used'] ;?></td>
                        <td width=10%>Warranty Term</td>
                        <td><?php echo $rcrow['WarrantyTerms']?></td>
                    </tr>
                    <tr>
                        <td width=10%>Available</td>
                        <td width=40%><?php echo $rcrow['Available'] ;?></td>
                        <td width=10%>Shipping Term</td>
                        <td><?php echo $rcrow['ShippingTerms']?></td>
                    </tr>
                    <tr>
                        <td width=10%>Status</td>
                        <td width=40%><?php echo $rcrow['SRStatus'] ;?></td>
                    </tr>
                </table>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
            
<!---------------- All reviews for this sample ----------------->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                <div class="row">
                    <h3 class="panel-title">Reviews for <?php echo $samplename?></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <button type="button" name="add" id="add" class="btn btn-success btn-xs" onclick="window.location.href='samplereview_add.php'">Add</button> 
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="panel-body">
            <?php
            $reviewsql = "SELECT * FROM PD_SampleReview sre INNER JOIN PD_SampleRecord sr ON sr.SRID = sre.SRID
                                INNER JOIN PD_Sample s ON s.SID = sr.SID
                                INNER JOIN PD_Entity e ON e.EID = sr.EID
                                INNER JOIN PD_DB_Account sma ON sma.AcctID = sre.ReviewBy
                                WHERE s.SID = $sid
                                ORDER BY EName";
            $reviewfetch = $dbconnect->query($reviewsql);
            while($rvrow = $reviewfetch->fetch_assoc()){
                $sreid = $rvrow['SReID'];
            ?>
            <a data-toggle="collapse" href="#reviewcollapse<?php echo $rvrow['SReID']; ?>" aria-expanded="false" aria-controls="collapseExample">
            <table  class="table ">
                <tr>
                    <td width=25%>Review ID: <?php echo $rvrow['SReID']; ?></td>
                    <td width=25%>For Vendor: <?php echo $rvrow['EName']; ?></td>
                </tr>
            </table>
            </a>
            <div class="collapse" id="reviewcollapse<?php echo $rvrow['SReID']; ?>">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="row">
                        <a href="samplereview_update.php?sreid=<?php echo $sreid ?>" class="btn btn-warning btn-xs">Edit</a>    
                    </div>
                </div>
                <table id="sample_review_data" class="table table-bordered table-striped">
                    <tr>
                        <td width=12%>Sample Name</td>
                        <td width=63%><?php echo $rvrow['SName']?></td>
                        <td width=25%>Actual Sample</td>
                    </tr>
                    <tr>
                        <td>From Vendor</td>
                        <td><?php echo $rvrow['EName'];?></td>
                        <td rowspan="4"><?php echo "<img src='images/sample_review/". $rvrow['SReImages']."' height='150' width='200'>"; ?></td>
                    </tr>
                    <tr>
                        <td>Comment</td>
                        <td><?php echo $rvrow['SReComments'];?></td>
                    </tr>
                    <tr>
                        <td>Last Modify By</td>
                        <td><?php echo $rvrow['username'] ;?></td>
                    </tr>
                    <tr>
                        <td>Last Modify On</td>
                        <td><?php echo date('Y-m-d H:i', strtotime($rvrow['ReviewDate'])) ;?></td>
                    </tr>
                </table>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;
for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        } 
    });
}
</script>
<?php
include ('footer.php');
?>