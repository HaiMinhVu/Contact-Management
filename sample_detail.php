<?php
require('fpdf181/fpdf.php');
include('dbconnect.php');

if(isset($_GET['sid'])){
	$pdf = new FPDF('P', 'mm', 'A4');
	$pdf->AddPage();

	$sid = $_GET['sid'];

	/////  project load
	$samplequery = "
	SELECT * FROM Sample s INNER JOIN SMDBAccounts sma ON sma.AcctID = s.SEnterBy
    						WHERE s.SID = $sid
	";
	$samplefetch = $dbconnect->query($samplequery);

	$pdf->SetFont('Times','B', 14);
    $pdf->SetTextColor(0,0,255);
	while($row = $samplefetch->fetch_array()){

		$pdf->Cell(189	,10, 'Sample '.$row['SName'], 1, 1, 'C');
		
		$pdf->SetFont('Times', '', 11);
    	$pdf->SetTextColor(0,0,0);

		$pdf->Cell(30	,5, "Status", 'L', 0);
    	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(85	,5, $row['SStatus'], 0, 0);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(74	,5, "Image", 'R', 1, 'C');
		

		$pdf->Cell(30	,5, "Enter By", 'L', 0);
		$pdf->Cell(85	,5, $row['username'], 0, 0);
		$pdf->Cell(74	,5, "", 'R', 1, 'C');

    	
		$pdf->Cell(30	,5, "Last Modify", 'L', 0);
		$pdf->Cell(85	,5, $row['SModifyDate'], 0, 0);
		$pdf->Cell(74	,5, "", 'R', 1);
    
		$modifybyid = $row['SModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Modify By", 'L', 0);
		$pdf->Cell(85	,5, $modifyrow['username'], 0, 0);
        $pdf->Cell(74	,5, "", 'R', 1);
    	}

		$pdf->Cell(30	,5, "Description", 'L', 0);
		$pdf->Cell(85	,5, $row['SDescription'], '', 0);
    	$pdf->Cell(74	,5, "", 'R', 1);
    
    	$pdf->Cell(189	,5, "", 'LBR', 1, 'C');
		
    }
	
	$recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
	$recordfetch = $dbconnect->query($recordquery);
	$countrecord = mysqli_num_rows($recordfetch);

	$pdf->Ln(); // add blank line between project and sample	
	$pdf->SetFont('Times','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".$countrecord." Records Related", 1, 1, 'C');
	$pdf->SetFont('Times','', 11);	// reset font
 	$pdf->SetTextColor(0,0,0);

	$eidarray = array();
	while($row = $recordfetch->fetch_array()){
    	$eid = $row['EID'];
    	if(!in_array($eid, $eidarray, true)){
        	array_push($eidarray, $eid);
        }
    
    	$pdf->Cell(30	,5, "Status",'L', 0);
    	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(85	,5, $row['SRStatus'], 0, 0);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(30	,5, "Date Request", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateRequested'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Type", 'L', 0);
		$pdf->Cell(85	,5, $row['Type'], 0, 0);
		$pdf->Cell(30	,5, "Estimate Deliver", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstDeliver'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Request By", 'L', 0);
		$pdf->Cell(85	,5, $row['username'], 0, 0);
		$pdf->Cell(30	,5, "Arrival Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ArrivalDate'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Request From", 'L', 0);
		$pdf->Cell(85	,5, $row['EName'], 0, 0);
		$pdf->Cell(30	,5, "Payment", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['PaymentTerms'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Quantity", 'L', 0);
		$pdf->Cell(85	,5, $row['Quantity'], 0, 0);
		$pdf->Cell(30	,5, "Warranty", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['WarrantyTerms'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Price/Unit", 'L', 0);
		$pdf->Cell(85	,5, $row['PriceperUnit'], 0, 0);
		$pdf->Cell(30	,5, "Shipping", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ShippingTerms'], 'R', 1, 'R');
    
    	$pdf->Cell(30	,5, "Last Modify", 'L', 0);
		$pdf->Cell(85	,5, $row['SRModifyDate'], 0, 0);
    	$pdf->Cell(74	,5, "", 'R', 1);
		
    	$modifybyid = $row['SRModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
    	$pdf->Cell(30	,5, "Modify By", 'L', 0);
		$pdf->Cell(85	,5, $modifyrow['username'], '', 0);
        $pdf->Cell(74	,5, "", 'R', 1);
        }
    
    	$pdf->Cell(189	,5, "", 'LBR', 1, 'C');
    }

	$pdf->Ln(); // add blank line between sample and vender
	$pdf->SetFont('Times','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".count($eidarray)." Vender Related", 1, 1, 'C');
	$pdf->SetFont('Times','B', 12);	// reset font
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(95	,5, "Vender Info", 1, 0, 'C');
	$pdf->Cell(94	,5, "Contact Info", 1, 1, 'C');
	
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