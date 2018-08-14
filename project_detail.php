<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =$_GET['project_id'];
$brandid;$deptid; $progress; $status; $empid;
$eidarray = array();
?>
    
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
        <div class="row">
            <h4>View Project Detail</h4> 
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
                    <h3 class="panel-title">Project Info</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <?php
                    if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
                    {
                    ?>
                    <a href="project_update.php?project_id=<?php echo $projectid ?>" class="btn btn-warning btn-xs">Edit</a>    
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="panel-body">
            <?php
            $projectsql = "SELECT * FROM PD_Project p INNER JOIN PD_DB_Account sma ON sma.AcctID = p.EnterBy
                        INNER JOIN PD_Employee sme ON sme.SMEmID = p.ProjectLead
                        WHERE ProjectID = $projectid";
            $projectfetch = $dbconnect->query($projectsql);
            while($row = $projectfetch->fetch_assoc()){
            $status = $row['ProjectStatus'];
            $empid = $row['ProjectLead'];
            $modifybyid = $row['ModifyBy'];
            ?>
            <table id="project_data" class="table table-bordered table-striped">
                <tr>
                    <td width=10%>Project Name</td>
                    <td><?php echo $row['ProjectName'];?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $row['ProjectDescription'];?></td>
                    
                </tr>
                <tr>
                    <td>Date Created</td>
                    <td><?php echo date('Y-m-d', strtotime($row['DateCreated'])) ;?></td>
                </tr>
                <tr>
                    <td>Created By</td>
                    <td><?php echo $row['username'] ;?></td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td><?php echo date('Y-m-d', strtotime($row['StartDate'])) ;?></td>
                </tr>
                <tr>
                    <td>Project Lead</td>
                    <td><?php echo $row['SMEmName']?></td>
                </tr>
                <tr>
                    <td>Estimate End Date</td>
                    <td><?php echo date('Y-m-d', strtotime($row['EstEndDate'])) ;?></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td><?php echo date('Y-m-d', strtotime($row['EndDate'])) ;?></td>
                </tr>
                <tr>
                    <td>Progress</td>
                    <td><?php echo $row['Progress']?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?php echo $row['ProjectStatus']?></td>
                </tr>
                <tr>
                    <td>Modify Date</td>
                    <td><?php echo date('Y-m-d H:i', strtotime($row['ModifyDate'])) ;?></td>
                </tr>
                <tr>
                    <td>Modify By</td>
                    <?php
                    $modifyidsql = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
                    while($modifyidrow = $modifyidsql->fetch_assoc()){
                    ?>
                    <td><?php echo $modifyidrow['username'] ;?></td>
                    <?php
                    }
                    ?>
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
                    <h3 class="panel-title">Requested Samples</h3>
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
            $samplequery = "SELECT * FROM PD_Project p 
                INNER JOIN PD_Project_Require_Sample prs ON prs.ProjectID = p.ProjectID
                INNER JOIN PD_Sample s ON s.SID = prs.SID
                INNER JOIN PD_SampleRecord sr ON sr.SID = s.SID
                INNER JOIN PD_Entity e ON e.EID = sr.EID
                WHERE p.ProjectID = $projectid
                ORDER BY s.SName, e.EName, SRID";
            $samplefetch = $dbconnect->query($samplequery);
            while($srow = $samplefetch->fetch_array()){
                $eid = $srow['EID'];
                if(!in_array($eid, $eidarray, true)){
                    array_push($eidarray, $eid);
                }
            ?>
            <a data-toggle="collapse" href="#samplerequestcollapse<?php echo $srow['SRID']; ?>" aria-expanded="false" aria-controls="collapseExample">
            <table  class="table ">
                <tr>
                    <td width=25%>Request ID: <?php echo $srow['SRID']; ?></td>
                    <td width=25%>Sample: <?php echo $srow['SName']; ?></td>
                    <td width=25%>From Vendor: <?php echo $srow['EName']; ?></td>
                    <td width=25%>Type: <?php echo $srow['Type'];?></td>
                </tr>
            </table>
            </a>
            <div class="collapse" id="samplerequestcollapse<?php echo $srow['SRID']; ?>">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                    <div class="row">
                        <h5>Sample Info</h5>
                        
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="row" align="right">
                        <h5>Vendor Info</h5> 
                    </div>
                </div>
                <table id="sample_view" class="table table-bordered table-striped">
                    <tr>
                        <td width=10%>Sample</td>
                        <td width=40%><a href="sample_detail.php?sid=<?php echo $srow['SID']; ?>"><?php echo $srow['SName'];?></a> </td>
                        <td width=10%>Vendor</td>
                        <td width=40%><a href="vendor_detail.php?eid=<?php echo $srow['EID']; ?>"><?php echo $srow['EName'];?></a></td>
                    </tr>
                    <tr>
                        <td width=10%>Type</td>
                        <td width=40%><?php echo $srow['Type'];?></td>
                        <td width=10%>Owner</td>
                        <td width=40%><?php echo $srow['Owner'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Quantity</td>
                        <td width=40%><?php echo $srow['Quantity'];?></td>
                        <td width=10%>Supplier</td>
                        <td width=40%><?php echo $srow['Supplier'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Price/Unit</td>
                        <td width=40%><?php echo $srow['PriceperUnit'];?></td>
                        <td width=10%>Manufactured</td>
                        <td width=40%><?php echo $srow['ProductManufactured'];?></td>
                    </tr>
                    <tr>
                        <td width=10%></td>
                        <td width=40%></td>
                        <td width=10%>Annual Sale</td>
                        <td width=40%><?php echo $srow['AnnualSales'];?></td>
                    </tr>
                </table>
            </div>
            <?php
            }
            ?>  
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                <div class="row">
                    <h3 class="panel-title">Vendor Representative Contacts</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <a href="vendorcontact_add.php" class="btn btn-success btn-xs">Add</a>  
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="panel-body">
            <?php
            foreach($eidarray as $eid){
            $contactsql = "SELECT * FROM PD_Entity e INNER JOIN PD_Entity_RelateTo_Contact erc ON erc.EID = e.EID
                        INNER JOIN PD_Entity_Contact_Person ec ON ec.ECPID = erc.ECID
                        WHERE e.EID = $eid AND erc.ERCStatus = 'Active'";

            $contactfetch = $dbconnect->query($contactsql);
            while($crow = $contactfetch->fetch_array()){
            ?>
            <a data-toggle="collapse" href="#contactcollapse<?php echo $crow['ECPID']; ?>" aria-expanded="false" aria-controls="collapseExample">
            <table  class="table ">
                <tr>
                    <td width=25%>Vendor: <?php echo $crow['EName']; ?></td>
                    <td width=25%>Title: <?php echo $crow['ERCTitle']; ?></td>
                </tr>
            </table>
            </a>
            <div class="collapse" id="contactcollapse<?php echo $crow['ECPID']; ?>">    
                <table id="contact_view" class="table table-bordered table-striped">
                    <tr>
                        <td width=10%>Name</td>
                        <td width=40%><?php echo $crow['ECName'];?></td>
                        <td width=10%>Title</td>
                        <td width=40%><?php echo $crow['ERCTitle'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Email</td>
                        <td width=40%><?php echo $crow['ECEmail'];?></td>
                        <td width=10%>Address 1</td>
                        <td width=40%><?php echo $crow['ECAddress1'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Phone</td>
                        <td width=40%><?php echo $crow['ECPhone'];?></td>
                        <td width=10%>Address 2</td>
                        <td width=40%><?php echo $crow['ECAddress2'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Fax</td>
                        <td width=40%><?php echo $crow['ECFax'];?></td>
                        <td width=10%>City</td>
                        <td width=40%><?php echo $crow['ECCity'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Website</td>
                        <td width=40%><?php echo $crow['ECWebsite'];?></td>
                        <td width=10%>State-Zip</td>
                        <td width=40%><?php echo $crow['ECState']."-".$crow['ECZip'];?></td>
                    </tr>
                    <tr>
                        <td width=10%>Status</td>
                        <td width=40%><?php echo $crow['ERCStatus'];?></td>
                        <td width=10%>Country</td>
                        <td width=40%><?php echo $crow['ECCountry'];?></td>
                    </tr>
                </table>
            </div>
            <?php
            }
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
