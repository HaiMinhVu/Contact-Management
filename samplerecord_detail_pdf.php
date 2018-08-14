<?php
require('fpdf181/fpdf.php');
include('dbconnect.php');

if(isset($_GET['srid'])){
	$pdf = new FPDF('P', 'mm', 'A4');
	$pdf->AddPage();

	$srid = $_GET['srid'];
	echo $srid;

	

	/*
	/////  project load
	$samplequery = "
	SELECT * FROM Sample s INNER JOIN SMDBAccounts sma ON sma.AcctID = s.SEnterBy
    						WHERE s.SID = $sid
	";
	$samplefetch = $dbconnect->query($samplequery);

	$pdf->SetFont('Arial','B', 14);
    $pdf->SetTextColor(0,0,255);
	while($row = $samplefetch->fetch_array()){

		$pdf->Cell(189	,10, 'Sample '.$row['SName'], 1, 1, 'C');
		
		$pdf->SetFont('Arial', '', 12);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(189	,5, "", 0, 1);
		
		$pdf->Cell(30	,5, "Status", 0, 0);
    	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(85	,5, $row['SStatus'], 0, 0);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(74	,5, "Image", 0, 1, 'C');
		

		$pdf->Cell(30	,5, "Enter By", 0, 0);
		$pdf->Cell(85	,5, $row['username'], 0, 0);
		$pdf->Cell(74	,5, "", 0, 1, 'C');

    	
		$pdf->Cell(30	,5, "Last Modify", 0, 0);
		$pdf->Cell(85	,5, $row['SModifyDate'], 0, 1);
		
		$modifybyid = $row['SModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
		$pdf->Cell(30	,5, "Modify By", 0, 0);
		$pdf->Cell(85	,5, $modifyrow['username'], 0, 1);
    	}

		$pdf->Cell(30	,5, "Description", 0, 0);
		$pdf->Cell(85	,10, $row['SDescription'], 0, 1);
		
    }

	$recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
	$recordfetch = $dbconnect->query($recordquery);
	$countrecord = mysqli_num_rows($recordfetch);

	$pdf->Cell(189	,5, "", 0, 1); // add blank line between project and sample	
	$pdf->SetFont('Arial','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".$countrecord." Records Related", 1, 1, 'C');
	$pdf->SetFont('Arial','', 12);	// reset font
 	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(189	,5, "", 0, 1);
	
	$eidarray = array();
	while($row = $recordfetch->fetch_array()){
    	$eid = $row['EID'];
    	if(!in_array($eid, $eidarray, true)){
        	array_push($eidarray, $eid);
        }
    
    	$pdf->Cell(30	,5, "Status", 0, 0);
    	$pdf->SetTextColor(255,0,0);
		$pdf->Cell(85	,5, $row['SRStatus'], 0, 0);
    	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(30	,5, "Date Request", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['DateRequested'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Type", 0, 0);
		$pdf->Cell(85	,5, $row['Type'], 0, 0);
		$pdf->Cell(30	,5, "Estimate Deliver", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['EstDeliver'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Request By", 0, 0);
		$pdf->Cell(85	,5, $row['username'], 0, 0);
		$pdf->Cell(30	,5, "Arrival Date", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ArrivalDate'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Request From", 0, 0);
		$pdf->Cell(85	,5, $row['EName'], 0, 0);
		$pdf->Cell(30	,5, "Payment", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['PaymentTerms'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Quantity", 0, 0);
		$pdf->Cell(85	,5, $row['Quantity'], 0, 0);
		$pdf->Cell(30	,5, "Warranty", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['WarrantyTerms'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Price/Unit", 0, 0);
		$pdf->Cell(85	,5, $row['PriceperUnit'], 0, 0);
		$pdf->Cell(30	,5, "Shipping", 0, 0, 'R');
		$pdf->Cell(44	,5, $row['ShippingTerms'], 0, 1, 'R');
    
    	$pdf->Cell(30	,5, "Last Modify", 0, 0);
		$pdf->Cell(85	,5, $row['SRModifyDate'], 0, 1);
		
    	$modifybyid = $row['SRModifyBy'];
    	$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    	while($modifyrow = $modifybyresult->fetch_assoc()){
    	$pdf->Cell(30	,5, "Modify By", 0, 0);
		$pdf->Cell(85	,5, $modifyrow['username'], 0, 1);
        }
    
    	$pdf->Cell(189	,5, "-----------------------------------------------------------------------------------------------------------------------------------", 0, 1, 'C');
    }

	$pdf->Cell(189	,5, "", 0, 1); // add blank line between sample and vender
	$pdf->SetFont('Arial','B', 14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(189	,10, "There are ".count($eidarray)." Vender Related", 1, 1, 'C');
	$pdf->SetFont('Arial','B', 12);	// reset font
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(95	,5, "Vender Info", 1, 0, 'C');
	$pdf->Cell(94	,5, "Contact Info", 1, 1, 'C');
	
	$pdf->Cell(189	,5, "", 0, 1);
	$pdf->SetFont('Arial','', 12);
	foreach($eidarray as $eid){
    	$contactsql = "SELECT * FROM Entity e INNER JOIN Entity_RelateTo_Contact erc ON erc.EID = e.EID
						INNER JOIN Entity_Contact ec ON ec.ECID = erc.ECID
                        WHERE e.EID = $eid";
    
    	//echo $eid;
    	$contactfetch = $dbconnect->query($contactsql);
    	while($row = $contactfetch->fetch_array()){
        	$pdf->Cell(30	,5, "Status", 0, 0);
        	$pdf->SetTextColor(255,0,0);
			$pdf->Cell(80	,5, $row['EStatus'], 0, 0);
        	$pdf->SetTextColor(0,0,0);
			$pdf->Cell(30	,5, "Title", 0, 0);
			$pdf->Cell(49	,5, $row['ERCTitle'], 0, 1);
      
        
        	$pdf->Cell(30	,5, "Name", 0, 0);
			$pdf->Cell(80	,5, $row['EName'], 0, 0);
			$pdf->Cell(30	,5, "Name", 0, 0);
			$pdf->Cell(49	,5, $row['ECName'], 0, 1);
        
        	$pdf->Cell(30	,5, "Registered As", 0, 0);
			$pdf->Cell(80	,5, $row['ERegisteredName'], 0, 0);
			$pdf->Cell(30	,5, "Phone", 0, 0);
			$pdf->Cell(49	,5, $row['ECPhone'], 0, 1);
        
        	$pdf->Cell(30	,5, "Owner", 0, 0);
			$pdf->Cell(80	,5, $row['Owner'], 0, 0);
			$pdf->Cell(30	,5, "Email", 0, 0);
			$pdf->Cell(49	,5, $row['ECEmail'], 0, 1);
        
        	$pdf->Cell(30	,5, "Supplier", 0, 0);
			$pdf->Cell(80	,5, $row['Supplier'], 0, 0);
			$pdf->Cell(30	,5, "Fax", 0, 0);
			$pdf->Cell(49	,5, $row['ECFax'], 0, 1);
        
        	$pdf->Cell(30	,5, "OEM Customer", 0, 0);
			$pdf->Cell(80	,5, $row['OEMCustomer'], 0, 0);
			$pdf->Cell(30	,5, "Address 1", 0, 0);
			$pdf->Cell(49	,5, $row['ECAddress1'], 0, 1);
        
        	$pdf->Cell(30	,5, "# of Worker", 0, 0);
			$pdf->Cell(80	,5, $row['NumberofWorker'], 0, 0);
			$pdf->Cell(30	,5, "Address 2", 0, 0);
			$pdf->Cell(49	,5, $row['ECAddress2'], 0, 1);
        
        	$pdf->Cell(30	,5, "Annual Sale", 0, 0);
			$pdf->Cell(80	,5, $row['AnnualSales'], 0, 0);
			$pdf->Cell(30	,5, "City", 0, 0);
			$pdf->Cell(49	,5, $row['ECCity'], 0, 1);
        	
        	$pdf->Cell(30	,5, "Manufactured", 0, 0);
			$pdf->Cell(80	,5, $row['ProductManufactured'], 0, 0);
			$pdf->Cell(30	,5, "State", 0, 0);
			$pdf->Cell(49	,5, $row['ECState'], 0, 1);	
        
        	$pdf->Cell(30	,5, "", 0, 0);
			$pdf->Cell(80	,5, "", 0, 0);
			$pdf->Cell(30	,5, "Zip Code", 0, 0);
			$pdf->Cell(49	,5, $row['ECZip'], 0, 1);
        
        	$pdf->Cell(30	,5, "", 0, 0);
			$pdf->Cell(80	,5, "", 0, 0);
			$pdf->Cell(30	,5, "Country", 0, 0);
			$pdf->Cell(49	,5, $row['ECCountry'], 0, 1);
        
        	$pdf->Cell(30	,5, "", 0, 0);
			$pdf->Cell(80	,5, "", 0, 0);
			$pdf->Cell(30	,5, "Status", 0, 0);
        	$pdf->SetTextColor(255,0,0);
			$pdf->Cell(49	,5, $row['ERCStatus'], 0, 1);
        	$pdf->SetTextColor(0,0,0);

        	
        	$pdf->Cell(189	,5, "-----------------------------------------------------------------------------------------------------------------------------------", 0, 1, 'C');
        	
        }
    }
	*/
	$pdf->Output();
}

?>