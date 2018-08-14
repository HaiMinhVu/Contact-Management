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

	$pdf->SetFont('Times','B', 14);
    $pdf->SetTextColor(0,0,255);
	while($row = $projectfetch->fetch_assoc()){
    
		
		$pdf->Cell(189	,10, 'Project '.$row['ProjectName'], 1, 1, 'C');
		
		$pdf->SetFont('Times', '', 11);
    	$pdf->SetTextColor(0,0,0);
		
    	$enterbyid = $row['EnterBy'];
    	$enterbyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $enterbyid");
    	while($enterrow = $enterbyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Enter By", 'L', 0);
		$pdf->Cell(85	,5, $enterrow['username'], 0, 0);
        }
		$pdf->Cell(30	,5, "Created", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateCreated'], 'R', 1, 'R');

		$pdf->Cell(30	,5, "Leader", 'L', 0);
		$pdf->Cell(85	,5, $row['SMEmName'], 0, 0);
		$pdf->Cell(30	,5, "Start On", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['StartDate'], 'R', 1, 'R');

		$pdf->Cell(30	,5, "Progress", 'L', 0);
		$pdf->Cell(85	,5, $row['Progress'], 0, 0);
		$pdf->Cell(30	,5, "Est Finish", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstEndDate'], 'R', 1, 'R');

		$pdf->Cell(30	,5, "Status", 'L', 0);
    	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(85	,5, $row['ProjectStatus'], 0, 0);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(30	,5, "Finish On", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EndDate'], 'R', 1, 'R');

    	$modifybyid = $row['ModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Last Modify", 'L', 0);
		$pdf->Cell(85	,5, $modifyrow['username'], 0, 0);
        }
		$pdf->Cell(30	,5, "Modify Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ModifyDate'], 'R', 1, 'R');

		$pdf->Cell(189	,5, "Description", 'LR', 1);
	
		$pdf->Cell(30	,15, "" , 'LB', 0);
		$pdf->Cell(159	,15, $row['ProjectDescription'], 'BR', 1);
    }
	
	///// sample load
	$samplequery = "SELECT * FROM Project p 
    			INNER JOIN Project_Require_Sample prs ON prs.ProjectID = p.ProjectID
				INNER JOIN Sample s ON s.SID = prs.SID
                INNER JOIN SampleRecord sr ON sr.SID = s.SID
                WHERE p.ProjectID = $projectid";
	$samplefetch = $dbconnect->query($samplequery);
	$countsample = mysqli_num_rows($samplefetch);
	//echo $samplequery;
	
	$pdf->Ln();	
	$pdf->SetFont('Times','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".$countsample." Sample Related", 1, 1, 'C');
	$pdf->SetFont('Times','', 11);	// reset font
 	$pdf->SetTextColor(0,0,0);

	$eidarray = array();
	
	while($row = $samplefetch->fetch_array()){
		$pdf->Cell(30	,5, "Sample", 'L', 0);
		$pdf->Cell(85	,5, $row['SName'], 0, 0);
		$pdf->Cell(30	,5, "Date Requested", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateRequested'], 'R', 1, 'R');
		
    	$pdf->Cell(30	,5, "Type", 'L', 0);
		$pdf->Cell(85	,5, $row['Type'], 0, 0);
		$pdf->Cell(30	,5, "Est Deliver", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstDeliver'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Quantity", 'L', 0);
		$pdf->Cell(85	,5, $row['Quantity'], 0, 0);
		$pdf->Cell(30	,5, "Arrival Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ArrivalDate'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Price/Unit", 'L', 0);
		$pdf->Cell(85	,5, $row['PriceperUnit'], 0, 0);
		$pdf->Cell(30	,5, "Payment Terms", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['PaymentTerms'], 'R', 1, 'R');
    
    	$eid = $row['EID'];
    	if(!in_array($eid, $eidarray, true)){
        	array_push($eidarray, $eid);
        }
    	
    	$enamefetch = $dbconnect->query("SELECT EName FROM Entity WHERE EID = $eid");
    	while($enamerow = $enamefetch->fetch_array()){
    	$pdf->Cell(30	,5, "From Vender", 'L', 0);
		$pdf->Cell(85	,5, $enamerow['EName'], 0, 0);
		$pdf->Cell(30	,5, "Warranty", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['WarrantyTerms'], 'R', 1, 'R');
        }
    
    	$pdf->Cell(115	,5, "", 'LB', 0);
		$pdf->Cell(30	,5, "Shipping", 'B', 0, 'R');
		$pdf->Cell(44	,5, $row['ShippingTerms'], 'BR', 1, 'R');
    	
    }
	
	$pdf->Ln();
	$pdf->SetFont('Times','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".count($eidarray)." Vender Related", 1, 1, 'C');
	$pdf->SetFont('Times','B', 12);	// reset font
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(95	,7, "Vender Info", 1, 0, 'C');
	$pdf->Cell(94	,7, "Contact Info", 1, 1, 'C');

	$pdf->SetFont('Times','', 11);
	foreach($eidarray as $eid){
    	$contactsql = "SELECT * FROM Entity e INNER JOIN Entity_RelateTo_Contact erc ON erc.EID = e.EID
						INNER JOIN Entity_Contact ec ON ec.ECID = erc.ECID
                        WHERE e.EID = $eid";

    	$contactfetch = $dbconnect->query($contactsql);
    	while($row = $contactfetch->fetch_array()){
        	$pdf->Cell(30	,5, "Status", 'L', 0);
        	$pdf->SetTextColor(255,0,0);
			$pdf->Cell(65	,5, $row['EStatus'], 'R', 0);
        	$pdf->SetTextColor(0,0,0);
			$pdf->Cell(30	,5, "Status", 0, 0);
        	$pdf->SetTextColor(255,0,0);
			$pdf->Cell(64	,5, $row['ERCStatus'], 'R', 1);
        	$pdf->SetTextColor(0,0,0);
        
        	$pdf->Cell(30	,5, "Name", 'L', 0);
			$pdf->Cell(65	,5, $row['EName'], 'R', 0);
			$pdf->Cell(30	,5, "Name", 0, 0);
			$pdf->Cell(64	,5, $row['ECName'], 'R', 1);
        
        	$pdf->Cell(30	,5, "Registered As", 'L', 0);
			$pdf->Cell(65	,5, $row['ERegisteredName'], 'R', 0);
			$pdf->Cell(30	,5, "Phone", 0, 0);
			$pdf->Cell(64	,5, $row['ECPhone'], 'R', 1);
        
        	$pdf->Cell(30	,5, "Owner", 'L', 0);
			$pdf->Cell(65	,5, $row['Owner'], 'R', 0);
			$pdf->Cell(30	,5, "Email", 0, 0);
			$pdf->Cell(64	,5, $row['ECEmail'], 'R', 1);
        
        	$pdf->Cell(30	,5, "Supplier", 'L', 0);
			$pdf->Cell(65	,5, $row['Supplier'], 'R', 0);
			$pdf->Cell(30	,5, "Fax", 0, 0);
			$pdf->Cell(64	,5, $row['ECFax'], 'R', 1);
        
        	$pdf->Cell(30	,5, "OEM Customer", 'L', 0);
			$pdf->Cell(65	,5, $row['OEMCustomer'], 'R', 0);
			$pdf->Cell(30	,5, "Address 1", 0, 0);
			$pdf->Cell(64	,5, $row['ECAddress1'], 'R', 1);
        
        	$pdf->Cell(30	,5, "# of Worker", 'L', 0);
			$pdf->Cell(65	,5, $row['NumberofWorker'], 'R', 0);
			$pdf->Cell(30	,5, "Address 2", 0, 0);
			$pdf->Cell(64	,5, $row['ECAddress2'], 'R', 1);
        
        	$pdf->Cell(30	,5, "Annual Sale", 'L', 0);
			$pdf->Cell(65	,5, $row['AnnualSales'], 'R', 0);
			$pdf->Cell(30	,5, "City", 0, 0);
			$pdf->Cell(64	,5, $row['ECCity'], 'R', 1);
        	
        	$pdf->Cell(30	,5, "Manufactured", 'L', 0);
			$pdf->Cell(65	,5, $row['ProductManufactured'], 'R', 0);
			$pdf->Cell(30	,5, "State", 0, 0);
			$pdf->Cell(64	,5, $row['ECState'], 'R', 1);	
        
        	$pdf->Cell(30	,5, "", 'L', 0);
			$pdf->Cell(65	,5, "", 'R', 0);
			$pdf->Cell(30	,5, "Zip Code", 0, 0);
			$pdf->Cell(64	,5, $row['ECZip'], 'R', 1);
        
        	$pdf->Cell(30	,5, "", 'L', 0);
			$pdf->Cell(65	,5, "", 'R', 0);
			$pdf->Cell(30	,5, "Country", '', 0);
			$pdf->Cell(64	,5, $row['ECCountry'], 'R', 1);
        
        	$pdf->Cell(30	,5, "", 'L', 0);
			$pdf->Cell(65	,5, "", 'R', 0);
			$pdf->Cell(30	,5, "Title", '', 0);
			$pdf->Cell(64	,5, $row['ERCTitle'], 'R', 1);
        
        	$pdf->Cell(189	,5, "", 'LBR', 1, 'C');

        }
    }


	$pdf->Output();
}

?>