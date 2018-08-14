<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$eid =$_GET['eid'];
$status; $epid;
?>

	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
    	<div class="row">
			<h4>View Vendor Detail</h4> 
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
                	<h3 class="panel-title">Vendor Info</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
					<?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
                    <a href="vendor_update.php?eid=<?php echo $eid ?>" class="btn btn-warning btn-xs">Edit</a> 	
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<?php
            $entitysql = "SELECT * FROM PD_Entity e INNER JOIN PD_DB_Account sma ON sma.AcctID = e.EEnterBy WHERE e.EID = $eid";
			$entityfetch = $dbconnect->query($entitysql);
			while($row = $entityfetch->fetch_array()){
            	$status = $row['EStatus'];
            	$epid = $row['EPID'];
            ?>
			<table id="samplerecord_data" class="table table-bordered table-striped">
            	General Info
				<tr>
					<td width=10%>Vendor Name</td>
					<td width=40%><?php echo $row['EName'];?></td>
            		<td width=10%>Status</td>
					<td width=40%><?php echo $row['EStatus'];?></td>
				</tr>
				<tr>
					<td width=10%>Register As</td>
					<td width=40%><?php echo $row['ERegisteredName'];?></td>
            		<td width=10%>Supplier</td>
            		<td><?php echo $row['Supplier'];?></td>
				</tr>
            	<tr>
					<td>Owner</td>
					<td><?php echo $row['Owner'];?></td>
            		<td>Products Manufactured</td>
            		<td><?php echo $row['ProductManufactured'];?></td>
				</tr>
            	<tr>
					<td width=10%>Last Modify On</td>
					<td width=40%><?php echo date('Y-m-d H:i', strtotime($row['EModifyDate'])) ;?></td>
            		<td width=10%>OEM Customer</td>
            		<td><?php echo $row['OEMCustomer'];?></td>
				</tr>
            	<tr>
            		<?php
					$modifybyid = $row['EModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td width=10%>Last Modify By</td>
					<td width=40%><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                    <td width=10%># of Employees</td>
            		<td><?php echo $row['NumberofWorker'];?></td>
				</tr>
            	<tr>
            		<td width=10%>Enter By</td>
					<td width=40%><?php echo $row['username'];?></td>
                    <td width=10%>Annual Sales</td>
            		<td><?php echo $row['AnnualSales'];?></td>
				</tr>   
			</table>
            <?php
            }
            ?>
            
            Emails
            <?php
            $emailcontactsql = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "email" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$emailcontactresult = $dbconnect->query($emailcontactsql);
			while($emailrow = $emailcontactresult->fetch_assoc()){
            ?>
            <table class="table table-bordered table-striped">
            	<tr>
					<td width=10%>SubCategory</td>
					<td width=40%><?php echo $emailrow['EASubCategory'];?></td>
            		<td width=10%>Email</td>
					<td width=40%><?php echo $emailrow['EAString'];?></td>
				</tr>
            </table>
            <?php
			}
            ?>
            
            Phones
            <?php
            $phonecontactsql = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "phone" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$phonecontactresult = $dbconnect->query($phonecontactsql);
			while($phonerow = $phonecontactresult->fetch_assoc()){
            ?>
            <table class="table table-bordered table-striped">
            	<tr>
					<td width=10%>SubCategory</td>
					<td width=40%><?php echo $phonerow['EASubCategory'];?></td>
            		<td width=10%>Email</td>
					<td width=40%><?php echo $phonerow['EAString'];?></td>
				</tr>
            </table>
            <?php
			}
            ?>
  
            Addresses
            <?php
            $addresscontactsql = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "address" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$addresscontactresult = $dbconnect->query($addresscontactsql);
			while($addressrow = $addresscontactresult->fetch_assoc()){
            	$jsonaddress = json_decode($addressrow['EAString']);
            ?>
            <table class="table table-bordered table-striped">
            	<tr>
					<td width=10%>Sub Category</td>
                    <td width=40%><?php echo $addressrow['EASubCategory'];?></td>
					<td width=10%>City</td>
            		<td width=40%><?php echo $jsonaddress->city; ?></td>
				</tr>
				<tr>
					<td>Address 1</td>
					<td><?php echo $jsonaddress->address1 ;?></td>
					<td>State</td>
            		<td><?php echo $jsonaddress->state; ?></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><?php echo $jsonaddress->address2; ?></td>
					<td>Country</td>
            		<td><?php echo $jsonaddress->country; ?></td>
				</tr>
				<tr>
					<td>PO Box</td>
					<td><?php echo $jsonaddress->pobox; ?></td>
					<td>Zip Code</td>
					<td><?php echo $jsonaddress->zip; ?></td>
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
                	<h3 class="panel-title">Representative Contacts</h3>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
            <?php
    		$contactsql = "SELECT * FROM PD_Entity e INNER JOIN PD_Entity_RelateTo_Contact erc ON erc.EID = e.EID
													INNER JOIN PD_Entity_Contact_Person ec ON ec.ECPID = erc.ECID
                        							WHERE e.EID = $eid ORDER BY erc.Priority";

    		$contactfetch = $dbconnect->query($contactsql);
    		while($crow = $contactfetch->fetch_array()){
			?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h5>Title: <?php echo $crow['ERCTitle'];?>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
                    <a href="vendorcontact_update.php?ecid=<?php echo $crow['ECID']; ?>" class="btn btn-warning btn-xs">Edit</a> 	
                    <?php
                    }
                    ?>
                </div>
            </div>
			<table id="contact_view" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Name</td>
					<td width=40%><?php echo $crow['ECName'];?></td>
            		<td width=10%>Address 1</td>
            		<td width=40%><?php echo $crow['ECAddress1'];?></td>
				</tr>
            	<tr>
					<td width=10%>Email</td>
					<td width=40%><?php echo $crow['ECEmail'];?></td>
            		<td width=10%>Address 2</td>
            		<td width=40%><?php echo $crow['ECAddress2'];?></td>
				</tr>
            	<tr>
					<td width=10%>Phone</td>
					<td width=40%><?php echo $crow['ECPhone'];?></td>
            		<td width=10%>City</td>
            		<td width=40%><?php echo $crow['ECCity'];?></td>
				</tr>
            	<tr>
					<td width=10%>Fax</td>
					<td width=40%><?php echo $crow['ECFax'];?></td>
            		<td width=10%>State-Zip</td>
            		<td width=40%><?php echo $crow['ECState']."-".$crow['ECZip'];?></td>
				</tr>
            	<tr>
					<td width=10%>Website</td>
					<td width=40%><?php echo $crow['ECWebsite'];?></td>
            		<td width=10%>Country</td>
            		<td width=40%><?php echo $crow['ECCountry'];?></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><?php echo $crow['ECStatus'];?></td>
                    <td width=10%>Priority</td>
					<td width=40%><?php echo $crow['Priority'];?></td>
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