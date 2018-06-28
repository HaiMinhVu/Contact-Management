<?php
require('fpdf181/fpdf.php');
include('dbconnect.php');
if(isset($_GET['project_id']))
{
	$pdf = new FPDF('P', 'mm', 'A4');
	$pdf->AddPage();

	$projectid = $_GET['project_id'];

	/////  project load
	$projectquery = "
	SELECT * FROM Project p
	INNER JOIN SMEmployees sme ON sme.SMEmID = p.ProjectLead
	INNER JOIN SMDBAccounts sma ON sma.AcctID = p.EnterBy
    WHERE p.ProjectID = $projectid
	";
	$projectfetch = $dbconnect->query($projectquery);
	while($row = $projectfetch->fetch_assoc()){
    
		$pdf->SetFont('Arial','B', 14);
		$pdf->Cell(189	,10, 'Project '.$row['ProjectName'], 1, 1, 'C');

		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(189	,5, "", 0, 1);
		
    	$enterbyid = $row['EnterBy'];
    	$enterbyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $enterbyid");
    	while($enterrow = $enterbyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Enter By", 0, 0);
		$pdf->Cell(85	,5, $enterrow['username'], 0, 0);
        }
		$pdf->Cell(30	,5, "Created", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateCreated'], 0, 1, 'R');

		$pdf->Cell(30	,5, "Leader", 0, 0);
		$pdf->Cell(85	,5, $row['SMEmName'], 0, 0);
		$pdf->Cell(30	,5, "Start On", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['StartDate'], 0, 1, 'R');

		$pdf->Cell(30	,5, "Progress", 0, 0);
		$pdf->Cell(85	,5, $row['Progress'], 0, 0);
		$pdf->Cell(30	,5, "Est Finish", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstEndDate'], 0, 1, 'R');

		$pdf->Cell(30	,5, "Status", 0, 0);
		$pdf->Cell(85	,5, $row['ProjectStatus'], 0, 0);
		$pdf->Cell(30	,5, "Finish On", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EndDate'], 0, 1, 'R');

    	$modifybyid = $row['ModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Last Modify", 0, 0);
		$pdf->Cell(85	,5, $modifyrow['username'], 0, 0);
        }
		$pdf->Cell(30	,5, "Modify Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ModifyDate'], 0, 1, 'R');

		$pdf->Cell(189	,5, "Description", 0, 1);
	
		$pdf->Cell(30	,15, "" , 0, 0);
		$pdf->Cell(159	,15, $row['ProjectDescription'], 0, 1);
    }
	$pdf->Cell(189	,5, "", 0, 1); // add blank line between project and sample	
	$pdf->SetFont('Arial','B', 14);
	$pdf->Cell(189	,10, "Sample Related", 1, 1, 'C');
	$pdf->SetFont('Arial','', 12);	// reset font
	$pdf->Cell(189	,5, "", 0, 1);
	///// sample load
	$samplequery = "SELECT * FROM Project p 
    			INNER JOIN Project_Require_Sample prs ON prs.ProjectID = p.ProjectID
				INNER JOIN Sample s ON s.SID = prs.SID
                INNER JOIN SampleRecord sr ON sr.SID = s.SID
                WHERE p.ProjectID = $projectid";
	$samplefetch = $dbconnect->query($samplequery);
	//echo $samplequery;
	
	$eidarray = array();
	
	while($row = $samplefetch->fetch_array()){
		$pdf->Cell(30	,5, "Sample", 0, 0);
		$pdf->Cell(85	,5, $row['SName'], 0, 0);
		$pdf->Cell(30	,5, "Date Requested", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateRequested'], 0, 1, 'R');
		
    	$pdf->Cell(30	,5, "Type", 0, 0);
		$pdf->Cell(85	,5, $row['Type'], 0, 0);
		$pdf->Cell(30	,5, "Est Deliver", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstDeliver'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Quantity", 0, 0);
		$pdf->Cell(85	,5, $row['Quantity'], 0, 0);
		$pdf->Cell(30	,5, "Arrival Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ArrivalDate'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Price/Unit", 0, 0);
		$pdf->Cell(85	,5, $row['PriceperUnit'], 0, 0);
		$pdf->Cell(30	,5, "Payment Terms", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['PaymentTerms'], 0, 1, 'R');
    
    	$eid = $row['EID'];
    	if(!in_array($eid, $eidarray, true)){
        	array_push($eidarray, $eid);
        }
    	
    	$enamefetch = $dbconnect->query("SELECT EName FROM Entity WHERE EID = $eid");
    	while($enamerow = $enamefetch->fetch_array()){
    	$pdf->Cell(30	,5, "From Vender", 0, 0);
		$pdf->Cell(85	,5, $enamerow['EName'], 0, 0);
		$pdf->Cell(30	,5, "Warranty", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['WarrantyTerms'], 0, 1, 'R');
        }
    
    	$pdf->Cell(30	,5, "", 0, 0);
		$pdf->Cell(85	,5, "", 0, 0);
		$pdf->Cell(30	,5, "Shipping", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ShippingTerms'], 0, 1, 'R');
    	
    	$pdf->Cell(189	,5, "", 0, 1);
    	$count++;
    }

	$pdf->Cell(189	,5, "", 0, 1); // add blank line between sample and vender
	$pdf->SetFont('Arial','B', 14);
	$pdf->Cell(189	,10, "Vender Related", 1, 1, 'C');
	$pdf->SetFont('Arial','B', 12);	// reset font
	
	$pdf->Cell(95	,5, "Vender Info", 1, 0, 'C');
	$pdf->Cell(94	,5, "Contact Info", 1, 1, 'C');

	$pdf->Cell(189	,5, "", 0, 1);
	$pdf->SetFont('Arial','', 12);
	foreach($eidarray as $eid){
    	$contactsql = "SELECT * FROM Entity e INNER JOIN Entity_RelateTo_Contact erc ON erc.EID = e.EID
						INNER JOIN Entity_Contact ec ON ec.ECID = erc.ECID
                        WHERE e.EID = $eid AND erc.ERCStatus = 'Active'";
    
    	//echo $eid;
    	$contactfetch = $dbconnect->query($contactsql);
    	while($row = $contactfetch->fetch_array()){
        	$pdf->Cell(30	,5, "Status", 0, 0);
			$pdf->Cell(80	,5, $row['EStatus'], 0, 0);
			$pdf->Cell(30	,5, "Status", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ERCStatus'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "Name", 0, 0);
			$pdf->Cell(80	,5, $row['EName'], 0, 0);
			$pdf->Cell(30	,5, "Name", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECName'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "Registered As", 0, 0);
			$pdf->Cell(80	,5, $row['ERegisteredName'], 0, 0);
			$pdf->Cell(30	,5, "Phone", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECPhone'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "Owner", 0, 0);
			$pdf->Cell(80	,5, $row['Owner'], 0, 0);
			$pdf->Cell(30	,5, "Email", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECEmail'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "Supplier", 0, 0);
			$pdf->Cell(80	,5, $row['Supplier'], 0, 0);
			$pdf->Cell(30	,5, "Fax", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECFax'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "OEM Customer", 0, 0);
			$pdf->Cell(80	,5, $row['OEMCustomer'], 0, 0);
			$pdf->Cell(30	,5, "Address 1", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECAddress1'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "# of Worker", 0, 0);
			$pdf->Cell(80	,5, $row['NumberofWorker'], 0, 0);
			$pdf->Cell(30	,5, "Address 2", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECAddress2'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "Annual Sale", 0, 0);
			$pdf->Cell(80	,5, $row['AnnualSales'], 0, 0);
			$pdf->Cell(30	,5, "City", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECCity'], 0, 1, 'R');
        	
        	$pdf->Cell(30	,5, "Manufactured", 0, 0);
			$pdf->Cell(80	,5, $row['ProductManufactured'], 0, 0);
			$pdf->Cell(30	,5, "State", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECState'], 0, 1, 'R');	
        
        	$pdf->Cell(30	,5, "", 0, 0);
			$pdf->Cell(80	,5, "", 0, 0);
			$pdf->Cell(30	,5, "Zip Code", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECZip'], 0, 1, 'R');
        
        	$pdf->Cell(30	,5, "", 0, 0);
			$pdf->Cell(80	,5, "", 0, 0);
			$pdf->Cell(30	,5, "Country", 0, 0, 'R');
			$pdf->Cell(49	,5, $row['ECCountry'], 0, 1, 'R');

        	$pdf->Cell(189	,5, "", 0, 1);
        }
    }


	$pdf->Output();
}

?>